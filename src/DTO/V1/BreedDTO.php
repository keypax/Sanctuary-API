<?php declare(strict_types=1);

namespace App\DTO\V1;

final readonly class BreedDTO
{
    private ?int $id;
    private ?int $speciesId;
    private ?string $name;
    private ?string $description;

    public function __construct(
        ?int $id,
        ?int $speciesId,
        ?string $name,
        ?string $description
    ) {
        $this->id = $id;
        $this->speciesId = $speciesId;
        $this->name = $name;
        $this->description = $description;
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            speciesId: $data['animal_species_id'],
            name: $data['breed_name'],
            description: $data['description'],
        );
    }
}