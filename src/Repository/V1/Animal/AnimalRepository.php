<?php declare(strict_types=1);

namespace App\Repository\V1\Animal;

use App\DTO\V1\AnimalDTO;
use Doctrine\DBAL\Connection;

readonly class AnimalRepository implements AnimalRepositoryInterface
{
    public function __construct(private Connection $connection) {}

    public function getAll(): array
    {
        $sql = 'SELECT * FROM animal';

        $stmt = $this->connection->prepare($sql);
        //$stmt->bindValue('id', $id);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    public function findByEnclosureId(int $enclosureId): array
    {
        $sql = '
            SELECT * FROM animal
            WHERE enclosure_id = :enclosureId
        ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('enclosureId', $enclosureId);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    public function findBySpeciesId(int $speciesId)
    {
        //todo: remove second query #FUTRZAK-97
        $sql = '
            SELECT * FROM animal
            WHERE species = (
                SELECT species_name 
                FROM animal_species 
                WHERE id = :speciesId
                LIMIT 1
            )
        ';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('speciesId', $speciesId);
        $results = $stmt->executeQuery()->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    private function mapResultsToDTOs(array $results): array
    {
        $dtos = [];
        foreach ($results as $result) {
            $dtos[] = AnimalDTO::createFromArray($result);
        }

        return $dtos;
    }
}