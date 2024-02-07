<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function createRecord(array $createArr): void;
    public function updateRecord(int $id, array $updateArr): void;
    public function deleteRecord(int $id): void;
}