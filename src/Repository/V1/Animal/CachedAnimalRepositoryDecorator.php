<?php declare(strict_types=1);

namespace App\Repository\V1\Animal;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class CachedAnimalRepositoryDecorator implements AnimalRepositoryInterface
{
    public function __construct(
        private AnimalRepositoryInterface $decoratedRepository,
        private CacheInterface $cache
    ) {}

    /** @inheritDoc */
    public function getAll(): array
    {
        return $this->cache->get('animal_get_all', function (ItemInterface $item) {
            $item->expiresAfter(600);
            return $this->decoratedRepository->getAll();
        });
    }

    /** @inheritDoc */
    public function findByEnclosureId(int $enclosureId): array
    {
        $cacheKey = 'animal_find_by_enclosure_'.$enclosureId;
        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($enclosureId) {
            $item->expiresAfter(600);
            return $this->decoratedRepository->findByEnclosureId($enclosureId);
        });
    }

    /** @inheritDoc */
    public function findBySpeciesId(int $speciesId)
    {
        $cacheKey = 'animal_find_by_species_'.$speciesId;
        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($speciesId) {
            $item->expiresAfter(600);
            return $this->decoratedRepository->findBySpeciesId($speciesId);
        });
    }

    /** @inheritDoc */
    public function findByBreedId(int $breedId)
    {
        $cacheKey = 'animal_find_by_breed_' . $breedId;
        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($breedId) {
            $item->expiresAfter(600);
            return $this->decoratedRepository->findByBreedId($breedId);
        });
    }
}