<?php  /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

final readonly class SpeciesDTO
{
    public function __construct(
        private int $id,
        private string $name,
    ) {}

    public static function createFromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['species_name'],
        );
    }
}