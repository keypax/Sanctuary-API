<?php declare(strict_types=1);

namespace App\Repository\V1\Species;

use App\DTO\V1\SpeciesDTO;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class CachedSpeciesRepositoryDecorator implements SpeciesRepositoryInterface
{
    public function __construct(
        private SpeciesRepositoryInterface $decoratedRepository,
        private CacheInterface $cache
    ) {}

    /** @inheritDoc */
    public function getAll(): array
    {
        return $this->cache->get('species_get_all', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->decoratedRepository->getAll();
        });
    }

    /** @inheritDoc */
    public function getById(int $id): SpeciesDTO
    {
        $cacheKey = 'species_get_' . $id;
        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($id) {
            $item->expiresAfter(3600);
            return $this->decoratedRepository->getById($id);
        });
    }
}