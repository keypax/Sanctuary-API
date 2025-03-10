<?php declare(strict_types=1);

namespace App\Repository\V1\Species;

use App\DTO\V1\SpeciesDTO;

interface SpeciesRepositoryInterface
{
    /** @return SpeciesDTO[] */
    public function getAll(): array;
}