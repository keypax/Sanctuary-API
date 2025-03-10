<?php declare(strict_types=1);

namespace App\DTO\V1;

final readonly class BreedDTO
{
    private ?int $id;
    private ?string $name;

    public function __construct(
        ?int $id,
        ?string $name,

    ) {
        $this->id = $id;
        $this->name = $name;

    }

    public static function createFromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['enclosure_name'],
        );
    }
}