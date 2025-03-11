<?php declare(strict_types=1);

namespace App\Repository\V1\Enclosure;

use App\DTO\V1\EnclosureDTO;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

readonly class CachedEnclosureRepositoryDecorator implements EnclosureRepositoryInterface
{
    public function __construct(
        private EnclosureRepositoryInterface $decoratedRepository,
        private CacheInterface $cache
    ) {}

    /** @inheritDoc */
    public function getById(int $id): EnclosureDTO
    {
        $cacheKey = 'enclosure_get_by_id_' . $id;
        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($id) {
            $item->expiresAfter(3600);
            return $this->decoratedRepository->getById($id);
        });
    }

    /** @inheritDoc */
    public function getAll(): array
    {
        return $this->cache->get('enclosure_get_all', function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->decoratedRepository->getAll();
        });
    }
}