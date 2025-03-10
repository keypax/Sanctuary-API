<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

final readonly class AnimalPhotoDTO
{
    public function __construct(
        private string $filenameOriginal,
        private string $filenameBig,
        private string $filenameMedium,
        private string $filenameSmall,
        private int $width,
        private int $height
    ) {}

    public static function createFromArray(array $data): self
    {
        return new self(
            filenameOriginal: $data['animal_photo_filename_original'],
            filenameBig: $data['animal_photo_filename_big'],
            filenameMedium: $data['animal_photo_filename_medium'],
            filenameSmall: $data['animal_photo_filename_small'],
            width: $data['animal_photo_width'],
            height: $data['animal_photo_height']
        );
    }
}