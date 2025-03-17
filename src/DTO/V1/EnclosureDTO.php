<?php  /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Enclosure')]
final readonly class EnclosureDTO
{
    public function __construct(
        #[OA\Property(title: 'The unique identifier of the enclosure.', type: 'integer', format: 'int64', example: "1")]
        private int $id,
        #[OA\Property(title: 'The name of the enclosure.', type: 'string', example: "Dog Box #5")]
        private string $name,
    ) {}

    public static function createFromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['enclosure_name'],
        );
    }
}