<?php declare(strict_types=1);

namespace App\Repository\V1;

use App\DTO\V1\AnimalDTO;
use Doctrine\DBAL\Connection;

class AnimalRepository implements AnimalRepositoryInterface
{
    public function __construct(readonly Connection $connection) {}

    public function getAll(): array
    {
        $sql = 'SELECT * FROM animal';

        $stmt = $this->connection->prepare($sql);
        //$stmt->bindValue('id', $id);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        $dtos = [];
        foreach ($results as $result) {
            $dtos[] = AnimalDTO::createFromArray($result);
        }
        return $dtos;
    }
}