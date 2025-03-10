<?php

namespace App\Repository\V1\Breed;

use App\DTO\V1\BreedDTO;
use Doctrine\DBAL\Connection;

readonly class BreedRepository implements BreedRepositoryInterface
{
    public function __construct(readonly Connection $connection) {}

    public function getAll(): array
    {
        $sql = '
            SELECT * FROM animal_breed
            ORDER BY animal_species_id ASC, breed_name ASC
        ';

        $stmt = $this->connection->prepare($sql);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        $dtos = [];
        foreach ($results as $result) {
            $dtos[] = BreedDTO::createFromArray($result);
        }

        return $dtos;
    }
}