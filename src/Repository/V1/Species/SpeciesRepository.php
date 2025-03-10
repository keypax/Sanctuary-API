<?php declare(strict_types=1);

namespace App\Repository\V1\Species;

use App\DTO\V1\SpeciesDTO;
use Doctrine\DBAL\Connection;

readonly class SpeciesRepository implements SpeciesRepositoryInterface
{
    public function __construct(readonly Connection $connection) {}

    public function getAll(): array
    {
        $sql = '
            SELECT * FROM animal_species
            ORDER BY id ASC
        ';

        $stmt = $this->connection->prepare($sql);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        $dtos = [];
        foreach ($results as $result) {
            $dtos[] = SpeciesDTO::createFromArray($result);
        }

        return $dtos;
    }
}