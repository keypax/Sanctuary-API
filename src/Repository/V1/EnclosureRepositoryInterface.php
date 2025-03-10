<?php declare(strict_types=1);

namespace App\Repository\V1;

use App\DTO\V1\EnclosureDTO;

interface EnclosureRepositoryInterface
{
    /** @return EnclosureDTO[] */
    public function getAll(): array;
}