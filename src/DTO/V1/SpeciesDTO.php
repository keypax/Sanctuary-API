<?php  /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Species')]
final readonly class SpeciesDTO
{
    public function __construct(
        #[OA\Property(title: 'The unique identifier of the species.', type: 'integer', format: 'int64', example: "1")]
        private int $id,
        #[OA\Property(title: 'The name of the species.', type: 'string', example: "Dog")]
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