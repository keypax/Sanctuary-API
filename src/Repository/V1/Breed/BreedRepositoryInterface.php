<?php

namespace App\Repository\V1\Breed;

use App\DTO\V1\BreedDTO;

interface BreedRepositoryInterface
{
    /** @return BreedDTO[] */
    public function getAll(): array;
    /** @return BreedDTO[] */
    public function findBySpeciesId(int $speciesId): array;
}