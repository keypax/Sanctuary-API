<?php declare(strict_types=1);

namespace App\Repository\V1;

use App\DTO\V1\EnclosureDTO;
use Doctrine\DBAL\Connection;

class EnclosureRepository implements EnclosureRepositoryInterface
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
}