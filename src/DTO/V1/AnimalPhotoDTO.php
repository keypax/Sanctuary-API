<?php /** @noinspection PhpPropertyOnlyWrittenInspection */
declare(strict_types=1);

namespace App\DTO\V1;

use OpenApi\Attributes as OA;

#[OA\Schema(title: 'Animal Photo')]
final readonly class AnimalPhotoDTO
{
    public function __construct(
        #[OA\Property(property: 'filenameOriginal', title: 'Original Filename', type: 'string', example: 'http://example.com/photos/SOME_ID/original.jpg')]
        private string $filenameOriginal,
        #[OA\Property(property: 'filenameBig', title: 'Big Filename', type: 'string', example: 'http://example.com/photos/SOME_ID/big.jpg')]
        private string $filenameBig,
        #[OA\Property(property: 'filenameMedium', title: 'Medium Filename', type: 'string', example: 'http://example.com/photos/SOME_ID/medium.jpg')]
        private string $filenameMedium,
        #[OA\Property(property: 'filenameSmall', title: 'Small Filename', type: 'string', example: 'http://example.com/photos/SOME_ID/small.jpg')]
        private string $filenameSmall,
        #[OA\Property(property: 'width', title: 'Width of original photo', type: 'integer', format: 'int32', example: 1920)]
        private int $width,
        #[OA\Property(property: 'height', title: 'Height of original photo', type: 'integer', format: 'int32', example: 1080)]
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