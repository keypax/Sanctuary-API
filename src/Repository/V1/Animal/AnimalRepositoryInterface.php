<?php declare(strict_types=1);

namespace App\Repository\V1\Animal;

use App\DTO\V1\AnimalDTO;

interface AnimalRepositoryInterface
{
    /** @return AnimalDTO[] */
    public function getAll(): array;
    /** @return AnimalDTO[] */
    public function findByEnclosureId(int $enclosureId): array;
    /** @return AnimalDTO[] */
    public function findBySpeciesId(int $speciesId);
}