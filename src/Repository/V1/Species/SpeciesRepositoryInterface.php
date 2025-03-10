<?php declare(strict_types=1);

namespace App\Repository\V1\Species;

use App\DTO\V1\SpeciesDTO;
use App\Repository\V1\Species\Exception\SpeciesNotFoundRepositoryException;

interface SpeciesRepositoryInterface
{
    /** @return SpeciesDTO[] */
    public function getAll(): array;

    /**
     * @param int $id
     * @return SpeciesDTO
     * @throws SpeciesNotFoundRepositoryException
     */
    public function getById(int $id): SpeciesDTO;
}