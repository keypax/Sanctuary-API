<?php declare(strict_types=1);

namespace App\Repository\V1\Animal;

use App\DTO\V1\AnimalDTO;
use App\DTO\V1\AnimalPhotoDTO;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class AnimalRepository implements AnimalRepositoryInterface
{
    private const FIELDS = '
        animal.id AS animal_id,
        animal.animal_internal_id AS animal_internal_id,
        animal.animal_name AS animal_name,
        animal.species_id AS animal_species_id,
        animal.breed_id AS animal_breed_id,
        animal.gender AS animal_gender,
        animal.enclosure_id AS animal_enclosure_id,
        animal.birth_date AS animal_birth_date,
        animal.approximate_age AS animal_approximate_age,
        animal.description AS animal_description,
        animal.color AS animal_color,
        animal.distinctive_marks AS animal_distinctive_marks,
        animal.size AS animal_size,
        animal.weight AS animal_weight,
        animal.updated_at AS animal_updated_at
    ';

    private const FIELD_PHOTOS = '
        animal_photo.id AS animal_photo_id,
        animal_photo.filename_original AS animal_photo_filename_original,
        animal_photo.filename_big AS animal_photo_filename_big,
        animal_photo.filename_medium AS animal_photo_filename_medium,
        animal_photo.filename_small AS animal_photo_filename_small,
        animal_photo.width AS animal_photo_width,
        animal_photo.height AS animal_photo_height
    ';

    private const FIELD_SPECIES = '
        animal_species.species_name AS animal_species_name
    ';

    private const FIELD_BREED = '
        animal_breed.breed_name AS animal_breed_name
    ';

    private const FIELD_ENCLOSURE = '
        enclosure.enclosure_name AS animal_enclosure_name
    ';

    private string $allFields;

    public function __construct(private Connection $connection) {
        $this->allFields = implode(',', [self::FIELDS, self::FIELD_PHOTOS, self::FIELD_SPECIES, self::FIELD_BREED, self::FIELD_ENCLOSURE]);
    }

    public function getAll(): array
    {
        $qb = $this->returnBaseQueryBuilder();

        $results = $qb->executeQuery()->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    public function findByEnclosureId(int $enclosureId): array
    {
        $qb = $this->returnBaseQueryBuilder()
            ->where('animal.enclosure_id = :enclosureId')
            ->setParameter('enclosureId', $enclosureId);

        $results = $qb->executeQuery()->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    public function findBySpeciesId(int $speciesId)
    {
        $qb = $this->returnBaseQueryBuilder()
            ->where('animal.species_id = :speciesId')
            ->setParameter('speciesId', $speciesId);

        $results = $qb->executeQuery()->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    public function findByBreedId(int $breedId)
    {
        $qb = $this->returnBaseQueryBuilder()
            ->where('animal.breed_id = :breedId')
            ->setParameter('breedId', $breedId);

        $results = $qb->executeQuery()->fetchAllAssociative();

        return $this->mapResultsToDTOs($results);
    }

    private function returnBaseQueryBuilder(): QueryBuilder
    {
        return $this->connection->createQueryBuilder()
            ->select($this->allFields)
            ->from('animal')
            ->leftJoin('animal', 'public.animal_photo', 'animal_photo', 'animal.id = animal_photo.animal_id')
            ->leftJoin('animal', 'public.animal_species', 'animal_species', 'animal.species_id = animal_species.id')
            ->leftJoin('animal', 'public.animal_breed', 'animal_breed', 'animal.breed_id = animal_breed.id')
            ->leftJoin('animal', 'public.enclosure', 'enclosure', 'animal.enclosure_id = enclosure.id');
    }

    private function mapResultsToDTOs(array $results): array
    {
        $animals = [];
        $animalsDTOs = [];

        foreach ($results as $result) {
            $animalId = $result['animal_id'];
            if (!isset($animals[$animalId])) {
                $animals[$animalId] = $result;
                $animals[$animalId]['photos'] = [];
            }

            if (isset($result['animal_photo_id'])) {
                $animals[$animalId]['photos'][] = $result;
            }
        }

        foreach ($animals as $animal) {
            $animalPhotosDTOs = [];
            foreach ($animal['photos'] as $photo) {
                $animalPhotosDTOs[] = AnimalPhotoDTO::createFromArray($photo);
            }

            $animalsDTOs[] = AnimalDTO::createFromArray($animal, $animalPhotosDTOs);
        }

        return $animalsDTOs;
    }
}