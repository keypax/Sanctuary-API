<?php declare(strict_types=1);

namespace App\Repository\V1\Species;

use App\DTO\V1\SpeciesDTO;
use App\Repository\V1\Species\Exception\SpeciesNotFoundRepositoryException;
use Doctrine\DBAL\Connection;

readonly class SpeciesRepository implements SpeciesRepositoryInterface
{
    public function __construct(private Connection $connection) {}

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

    public function getById(int $id): SpeciesDTO
    {
        $sql = '
            SELECT * FROM animal_species
            WHERE id = :id
            LIMIT 1
        ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $id);
        $result = $stmt->executeQuery()->fetchAssociative();

        if ($result === false) {
            throw new SpeciesNotFoundRepositoryException();
        }

        return SpeciesDTO::createFromArray($result);
    }
}