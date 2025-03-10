<?php declare(strict_types=1);

namespace App\Controller\V1\Species;

use App\Controller\V1\ApiAbstractController;
use App\Repository\V1\Animal\AnimalRepositoryInterface;
use App\Repository\V1\Breed\BreedRepositoryInterface;
use App\Repository\V1\Species\Exception\SpeciesNotFoundRepositoryException;
use App\Repository\V1\Species\SpeciesRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/species', name: 'v1_species_')]
class SpeciesController extends ApiAbstractController
{
    public function __construct(
        private SpeciesRepositoryInterface $speciesRepository,
        private AnimalRepositoryInterface $animalRepository,
        private BreedRepositoryInterface $breedRepository,
        private SerializerInterface $serializer
    ) {
        parent::__construct($serializer);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse {
        $jsonContent = $this->serializer->serialize(
            $this->speciesRepository->getAll(), 'json'
        );

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/{speciesId}/breeds', name: 'breeds', methods: ['GET'])]
    public function breeds(int $speciesId): JsonResponse {
        try {
            $this->speciesRepository->getById($speciesId);
        } catch (SpeciesNotFoundRepositoryException) {
            return new JsonResponse('Species not found', 404);
        }

        $jsonContent = $this->toJson($this->breedRepository->findBySpeciesId($speciesId));

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/{speciesId}/animals', name: 'animals', methods: ['GET'])]
    public function animals(int $speciesId): JsonResponse {
        try {
            $this->speciesRepository->getById($speciesId);
        } catch (SpeciesNotFoundRepositoryException) {
            return new JsonResponse('Species not found', 404);
        }

        $jsonContent = $this->toJson($this->animalRepository->findBySpeciesId($speciesId));

        return new JsonResponse($jsonContent, 200, [], true);
    }
}