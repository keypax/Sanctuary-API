<?php  /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Breed')]
final readonly class BreedDTO
{
    public function __construct(
        #[OA\Property(title: 'The unique identifier of the breed.', type: 'integer', format: 'int64', example: "1")]
        private int $id,
        #[OA\Property(title: 'The identifier of the species this breed belongs to.', type: 'integer', format: 'int64', example: "2")]
        private int $speciesId,
        #[OA\Property(title: 'The name of the breed.', type: 'string', example: "Golden Retriever")]
        private string $name,
        #[OA\Property(title: 'A description of the breed.', type: 'string', example: "A large, friendly dog breed.", nullable: true)]
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