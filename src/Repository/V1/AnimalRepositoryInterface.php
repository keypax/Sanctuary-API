<?php declare(strict_types=1);

namespace App\Repository\V1;

use App\DTO\V1\AnimalDTO;

interface AnimalRepositoryInterface
{
    /** @return AnimalDTO[] */
    public function getAll(): array;
}