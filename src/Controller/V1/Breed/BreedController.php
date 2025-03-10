<?php

namespace App\Controller\V1\Breed;

use App\Controller\V1\ApiAbstractController;
use App\Repository\V1\Animal\AnimalRepositoryInterface;
use App\Repository\V1\Breed\BreedRepositoryInterface;
use App\Repository\V1\Breed\Exception\BreedNotFoundRepositoryException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/breeds', name: 'v1_breeds_')]
class BreedController extends ApiAbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private BreedRepositoryInterface $breedRepository,
        private SerializerInterface $serializer
    ) {
        parent::__construct($serializer);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse {
        $jsonContent = $this->toJson($this->breedRepository->getAll());

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/{breedId}/animals', name: 'animals', methods: ['GET'])]
    public function animals(int $breedId): JsonResponse {
        try {
            $this->breedRepository->getById($breedId);
        } catch (BreedNotFoundRepositoryException) {
            return new JsonResponse('Breed not found', 404);
        }

        $jsonContent = $this->toJson($this->animalRepository->findByBreedId($breedId));

        return new JsonResponse($jsonContent, 200, [], true);
    }
}