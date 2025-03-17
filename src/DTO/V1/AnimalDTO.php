<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

use DateTime;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Animal')]
final readonly class AnimalDTO
{
    public function __construct(
        #[OA\Property(title: 'The unique identifier of the animal in repository.', type: 'integer', format: 'int64', example: "12345")]
        private int $id,
        #[OA\Property(title: 'The unique, human-friendly *internal* identifier of the animal.', type: 'string', example: "145/2025")]
        private string $internalId,
        #[OA\Property(title: 'The name of the animal.', type: 'string', example: "Rex")]
        private ?string $name,
        #[OA\Property(property: 'speciesId', title: 'Species ID', type: 'integer', format: 'int64', example: "1", nullable: true)]
        private ?int $speciesId,
        #[OA\Property(property: 'speciesName', title: 'Species Name', type: 'string', example: "Dog", nullable: true)]
        private ?string $speciesName,
        #[OA\Property(property: 'breedId', title: 'Breed ID', type: 'integer', format: 'int64', example: "2", nullable: true)]
        private ?int $breedId,
        #[OA\Property(property: 'breedName', title: 'Breed Name', type: 'string', example: "Golden Retriever", nullable: true)]
        private ?string $breedName,
        #[OA\Property(property: 'gender', title: 'Gender', description: 'Numeric representation of gender (e.g., 0 - not set/unknown, 1 for male, 2 for female).  Consider using an enum for clarity.', type: 'integer', format: 'int32', example: "1", nullable: true)]
        private ?int $gender,
        #[OA\Property(property: 'enclosureId', title: 'Enclosure ID', type: 'integer', format: 'int64', example: "5", nullable: true)]
        private ?int $enclosureId,
        #[OA\Property(property: 'enclosureName', title: 'Enclosure Name', type: 'string', example: "Dog House #4", nullable: true)]
        private ?string $enclosureName,
        #[OA\Property(property: 'birthDate', title: 'Birth Date', type: 'string', format: 'date', example: "2023-01-15", nullable: true)]
        private ?DateTime $birthDate,
        #[OA\Property(property: 'approximateAge', title: 'Approximate Age (in months)', type: 'integer', example: 24, nullable: true)]
        private ?int $approximateAge,
        #[OA\Property(property: 'description', title: 'Description', type: 'string', example: "Friendly and playful dog.", nullable: true)]
        private ?string $description,
        #[OA\Property(property: 'color', title: 'Color', type: 'string', example: "Golden", nullable: true)]
        private ?string $color,
        #[OA\Property(property: 'distinctiveMarks', title: 'Distinctive Marks', type: 'string', example: "White patch on chest.", nullable: true)]
        private ?string $distinctiveMarks,
        #[OA\Property(property: 'size', title: 'Predicted final size of the animal (0-4)', type: 'integer', example: "2", nullable: true)]
        private ?int $size,
        #[OA\Property(property: 'weight', title: 'Weight (e.g., in kg)', type: 'number', format: 'float', example: "25.5", nullable: true)]
        private ?float $weight,
        #[OA\Property(property: 'updatedAt', title: 'Last Updated At', type: 'string', format: 'date-time', example: "2024-07-27T10:00:00Z", nullable: true)]
        private ?DateTime $updatedAt,
        #[OA\Property(property: 'photos', title: 'Photos', type: 'array', items: new OA\Items(ref: new Model(type: AnimalPhotoDTO::class)), nullable: true)]
        private array $photos = []
    ) {}

    public static function createFromArray(array $data, array $photos = []): self
    {
        return new self(
            id: $data['animal_id'],
            internalId: $data['animal_internal_id'],
            name: $data['animal_name'],
            speciesId: $data['animal_species_id'],
            speciesName: $data['animal_species_name'],
            breedId: $data['animal_breed_id'],
            breedName: $data['animal_breed_name'],
            gender: $data['animal_gender'],
            enclosureId: $data['animal_enclosure_id'],
            enclosureName: $data['animal_enclosure_name'],
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
}