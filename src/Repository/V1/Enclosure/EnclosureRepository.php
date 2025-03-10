<?php declare(strict_types=1);

namespace App\Repository\V1\Enclosure;

use App\DTO\V1\EnclosureDTO;
use App\Repository\V1\Enclosure\Exception\EnclosureNotFoundRepositoryException;
use Doctrine\DBAL\Connection;

readonly class EnclosureRepository implements EnclosureRepositoryInterface
{
    public function __construct(readonly Connection $connection) {}

    public function getAll(): array
    {
        $sql = '
            SELECT * FROM enclosure
            ORDER BY enclosure_name ASC
        ';

        $stmt = $this->connection->prepare($sql);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        $dtos = [];
        foreach ($results as $result) {
            $dtos[] = EnclosureDTO::createFromArray($result);
        }

        return $dtos;
    }

    public function getById(int $id): EnclosureDTO
    {
        $sql = '
            SELECT * FROM enclosure
            WHERE id = :id
            LIMIT 1
        ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $id);
        $result = $stmt->executeQuery()->fetchAllAssociative();

        if (empty($result)) {
            throw new EnclosureNotFoundRepositoryException();
        }

        return EnclosureDTO::createFromArray($result[0]);
    }
}