<?php

namespace App\Repository\V1\Breed;

use App\DTO\V1\BreedDTO;
use Doctrine\DBAL\Connection;

readonly class BreedRepository implements BreedRepositoryInterface
{
    public function __construct(private Connection $connection) {}

    public function getAll(): array
    {
        $sql = '
            SELECT * FROM animal_breed
            ORDER BY animal_species_id ASC, breed_name ASC
        ';

        $stmt = $this->connection->prepare($sql);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    public function findBySpeciesId(int $speciesId): array
    {
        $sql = '
            SELECT * FROM animal_breed
            WHERE animal_species_id = :speciesId
            ORDER BY id ASC
        ';

        $stmt = $this->connection->prepare($sql);
        $results = $stmt->executeQuery(['speciesId' => $speciesId])->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    private function mapResultsToDTOs(array $results): array
    {
        $dtos = [];
        foreach ($results as $result) {
            $dtos[] = BreedDTO::createFromArray($result);
        }

        return $dtos;
    }
}