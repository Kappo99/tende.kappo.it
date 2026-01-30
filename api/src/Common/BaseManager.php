<?php

namespace App\Common;

abstract class BaseManager
{
    protected BaseService $service;

    public function __construct(BaseService $service)
    {
        $this->service = $service;
    }

    /**
     * Gestisce la logica di business per trovare un record per ID
     */
    public function getById(int $id): ?object
    {
        return $this->service->findById($id);
    }

    /**
     * Gestisce la logica di business per trovare tutti i record
     */
    public function getAll(array $filters = [], string $orderBy = 'id DESC', ?int $limit = null): array
    {
        return $this->service->findAll($filters, $orderBy, $limit);
    }
}
