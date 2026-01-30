<?php

namespace App\Common;

use App\Database\Database;
use mysqli_result;

abstract class BaseRepository
{
    protected string $tableName;
    protected string $modelClass;

    public function __construct(string $tableName, string $modelClass)
    {
        $this->tableName = $tableName;
        $this->modelClass = $modelClass;
    }

    protected function getConnection()
    {
        return Database::getConnection();
    }

    /**
     * Determina il tipo di parametro per mysqli
     */
    protected function getParamType($value): string
    {
        if (is_int($value)) {
            return 'i';
        } elseif (is_float($value)) {
            return 'd';
        } else {
            return 's';
        }
    }

    /**
     * Esegue una query SELECT e restituisce un array di modelli
     */
    protected function query(string $sql, array $params = []): array
    {
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        
        if ($stmt === false) {
            throw new \RuntimeException("Errore preparazione query: " . $connection->error);
        }

        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                $types .= $this->getParamType($param);
            }
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = new $this->modelClass($row);
        }
        
        $stmt->close();
        return $items;
    }

    /**
     * Esegue una query SELECT e restituisce un singolo modello
     */
    protected function queryOne(string $sql, array $params = []): ?object
    {
        $results = $this->query($sql, $params);
        return !empty($results) ? $results[0] : null;
    }

    /**
     * Esegue una query SELECT e restituisce il risultato raw
     */
    protected function queryRaw(string $sql, array $params = []): array
    {
        $connection = $this->getConnection();
        $stmt = $connection->prepare($sql);
        
        if ($stmt === false) {
            throw new \RuntimeException("Errore preparazione query: " . $connection->error);
        }

        if (!empty($params)) {
            $types = '';
            foreach ($params as $param) {
                $types .= $this->getParamType($param);
            }
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        $stmt->close();
        return $items;
    }

    /**
     * Trova un record per ID
     */
    public function findById(int $id): ?object
    {
        $sql = "SELECT * FROM `{$this->tableName}` WHERE id = ? LIMIT 1";
        return $this->queryOne($sql, [$id]);
    }

    /**
     * Trova tutti i record
     */
    public function findAll(array $filters = [], string $orderBy = 'id DESC', ?int $limit = null): array
    {
        $sql = "SELECT * FROM `{$this->tableName}`";
        $params = [];
        $where = [];

        foreach ($filters as $field => $value) {
            $where[] = "`{$field}` = ?";
            $params[] = $value;
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        if ($orderBy) {
            $sql .= " ORDER BY {$orderBy}";
        }

        if ($limit !== null) {
            $sql .= " LIMIT ?";
            $params[] = $limit;
        }

        return $this->query($sql, $params);
    }

    /**
     * Inserisce multipli record in batch (metodo interno)
     */
    protected function insertBatchInternal(array $data, array $fields): bool
    {
        if (empty($data)) {
            return false;
        }

        $connection = $this->getConnection();
        $fieldList = '`' . implode('`, `', $fields) . '`';
        $placeholders = '(' . implode(', ', array_fill(0, count($fields), '?')) . ')';
        $values = implode(', ', array_fill(0, count($data), $placeholders));
        
        $sql = "INSERT INTO `{$this->tableName}` ({$fieldList}) VALUES {$values}";
        
        $stmt = $connection->prepare($sql);
        if ($stmt === false) {
            throw new \RuntimeException("Errore preparazione query: " . $connection->error);
        }

        $params = [];
        $types = '';
        foreach ($data as $row) {
            foreach ($fields as $field) {
                $value = $row[$field] ?? null;
                $params[] = $value;
                $types .= $this->getParamType($value);
            }
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $result = $stmt->execute();
        $stmt->close();
        
        return $result;
    }

    /**
     * Inserisce un singolo record
     */
    protected function insert(array $data): bool
    {
        return $this->insertBatchInternal([$data], array_keys($data));
    }
}
