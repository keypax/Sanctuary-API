<?php  /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

final readonly class BreedDTO
{
    public function __construct(
        private int $id,
        private int $speciesId,
        private string $name,
        ?string $description
    ) {}

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