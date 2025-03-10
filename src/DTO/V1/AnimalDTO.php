<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

use DateTime;

final readonly class AnimalDTO
{
    public function __construct(
        private int $id,
        private string $internalId,
        private ?string $name,
        private ?string $species,
        private ?string $breed,
        private ?int $gender,
        private ?int $enclosureId,
        private ?DateTime $birthDate,
        private ?int $approximateAge,
        private ?string $description,
        private ?string $color,
        private ?string $distinctiveMarks,
        private ?int $size,
        private ?float $weight,
        private ?DateTime $updatedAt,
        private array $photos = []
    ) {}

    public static function createFromArray(array $data, array $photos = []): self
    {
        return new self(
            id: $data['animal_id'],
            internalId: $data['animal_internal_id'],
            name: $data['animal_name'],
            species: $data['animal_species'],
            breed: $data['animal_breed'],
            gender: $data['animal_gender'],
            enclosureId: $data['animal_enclosure_id'],
            birthDate: $data['animal_birth_date'] === null ? null : new DateTime($data['animal_birth_date']),
            approximateAge: $data['animal_approximate_age'],
            description: $data['animal_description'],
            color: $data['animal_color'],
            distinctiveMarks: $data['animal_distinctive_marks'],
            size: $data['animal_size'],
            weight: $data['animal_weight'],
            updatedAt: new DateTime($data['animal_updated_at']),
            photos: $photos
        );
    }

    /**
     * @return AnimalPhotoDTO[]
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }
}