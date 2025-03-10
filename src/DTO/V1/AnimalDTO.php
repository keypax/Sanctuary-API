<?php declare(strict_types=1);

namespace App\DTO\V1;

final readonly class AnimalDTO
{
    private ?string $animalInternalId;
    private ?string $animalName;
    private ?string $species;
    private ?string $breed;
    private ?int $gender;

    public function __construct(
        ?string $animalInternalId,
        ?string $animalName,
        ?string $species,
        ?string $breed,
        ?int $gender
    ) {
        $this->animalInternalId = $animalInternalId;
        $this->animalName = $animalName;
        $this->species = $species;
        $this->breed = $breed;
        $this->gender = $gender;
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            animalInternalId: $data['animal_internal_id'],
            animalName: $data['animal_name'],
            species: $data['species'],
            breed: $data['breed'],
            gender: $data['gender']
        );
    }
}