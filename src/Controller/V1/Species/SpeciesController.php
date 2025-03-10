<?php declare(strict_types=1);

namespace App\Controller\V1\Species;

use App\Repository\V1\Animal\AnimalRepositoryInterface;
use App\Repository\V1\Enclosure\EnclosureRepositoryInterface;
use App\Repository\V1\Enclosure\Exception\EnclosureNotFoundRepositoryException;
use App\Repository\V1\Species\SpeciesRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/species', name: 'v1_species_')]
class SpeciesController extends AbstractController
{
    public function __construct(
        private SpeciesRepositoryInterface $speciesRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse {
        $jsonContent = $this->serializer->serialize(
            $this->speciesRepository->getAll(), 'json'
        );

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/{enclosureId}/animals', name: 'animals', methods: ['GET'])]
    public function animals(int $enclosureId): JsonResponse {
        try {
            $this->enclosureRepository->getById($enclosureId);
        } catch (EnclosureNotFoundRepositoryException) {
            return new JsonResponse('Enclosure not found', 404);
        }

        $jsonContent = $this->serializer->serialize(
            $this->animalRepository->findByEnclosureId($enclosureId), 'json'
        );

        return new JsonResponse($jsonContent, 200, [], true);
    }
}