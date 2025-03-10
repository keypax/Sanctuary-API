<?php declare(strict_types=1);

namespace App\Controller\V1\Enclosure;

use App\Controller\V1\ApiAbstractController;
use App\Repository\V1\Animal\AnimalRepositoryInterface;
use App\Repository\V1\Enclosure\EnclosureRepositoryInterface;
use App\Repository\V1\Enclosure\Exception\EnclosureNotFoundRepositoryException;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/enclosures', name: 'v1_enclosures_')]
class EnclosureController extends ApiAbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private EnclosureRepositoryInterface $enclosureRepository,
        private SerializerInterface $serializer
    ) {
        parent::__construct($serializer);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse {
        $jsonContent = $this->toJson($this->enclosureRepository->getAll());

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/{enclosureId}/animals', name: 'animals', methods: ['GET'])]
    public function animals(int $enclosureId): JsonResponse {
        try {
            $this->enclosureRepository->getById($enclosureId);
        } catch (EnclosureNotFoundRepositoryException) {
            return new JsonResponse('Enclosure not found', 404);
        }

        $jsonContent = $this->toJson($this->animalRepository->findByEnclosureId($enclosureId));

        return new JsonResponse($jsonContent, 200, [], true);
    }
}