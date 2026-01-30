<?php

namespace App\Common;

abstract class BaseService
{
    protected BaseRepository $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Trova un record per ID
     */
    public function findById(int $id): ?object
    {
        return $this->repository->findById($id);
    }

    /**
     * Trova tutti i record con filtri opzionali
     */
    public function findAll(array $filters = [], string $orderBy = 'id DESC', ?int $limit = null): array
    {
        return $this->repository->findAll($filters, $orderBy, $limit);
    }
}
