<?php

namespace App\Repository\V1\Breed;

use App\DTO\V1\BreedDTO;
use App\Repository\V1\Breed\Exception\BreedNotFoundRepositoryException;

interface BreedRepositoryInterface
{
    /** @return BreedDTO[] */
    public function getAll(): array;
    /**
     * @param int $id
     * @return BreedDTO
     * @throws BreedNotFoundRepositoryException
     */
    public function getById(int $id): BreedDTO;
    /** @return BreedDTO[] */
    public function findBySpeciesId(int $speciesId): array;
}