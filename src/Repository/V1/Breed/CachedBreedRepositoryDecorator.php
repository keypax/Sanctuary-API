<?php declare(strict_types=1);

namespace App\Repository\V1\Breed;

use App\DTO\V1\BreedDTO;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class CachedBreedRepositoryDecorator implements BreedRepositoryInterface
{
    public function __construct(
        private BreedRepositoryInterface $decoratedRepository,
        private CacheInterface $cache
    ) {}

    /** @inheritDoc */
    public function getAll(): array
    {
        return $this->cache->get('breed_get_all', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->decoratedRepository->getAll();
        });
    }

    /** @inheritDoc */
    public function getById(int $id): BreedDTO
    {
        $cacheKey = 'breed_get_by_id_' . $id;
        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($id) {
            $item->expiresAfter(3600);
            return $this->decoratedRepository->getById($id);
        });
    }

    //** @inheritDoc */
    public function findBySpeciesId(int $speciesId): array
    {
        $cacheKey = 'breed_find_by_species_' . $speciesId;
        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($speciesId) {
            $item->expiresAfter(3600);
            return $this->decoratedRepository->findBySpeciesId($speciesId);
        });
    }
}