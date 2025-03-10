<?php declare(strict_types=1);

namespace App\Repository\V1\Enclosure;

use App\DTO\V1\EnclosureDTO;
use App\Repository\V1\Enclosure\Exception\EnclosureNotFoundRepositoryException;

interface EnclosureRepositoryInterface
{
    /**
     * @param int $id
     * @return EnclosureDTO
     * @throws EnclosureNotFoundRepositoryException
     */
    public function getById(int $id): EnclosureDTO;

    /** @return EnclosureDTO[] */
    public function getAll(): array;
}