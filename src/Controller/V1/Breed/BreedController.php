<?php

namespace App\Controller\V1\Breed;

use App\Controller\V1\ApiAbstractController;
use App\DTO\V1\BreedDTO;
use App\Repository\V1\Animal\AnimalRepositoryInterface;
use App\Repository\V1\Breed\BreedRepositoryInterface;
use App\Repository\V1\Breed\Exception\BreedNotFoundRepositoryException;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/v1/breeds', name: 'v1_breeds_')]
class BreedController extends ApiAbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private BreedRepositoryInterface $breedRepository,
        SerializerInterface $serializer
    ) {
        parent::__construct($serializer);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Get(
        summary: "Get all breeds",
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: BreedDTO::class))
        )
    )]
    public function index(): JsonResponse {
        $jsonContent = $this->toJson($this->breedRepository->getAll());

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/{breedId}/animals', name: 'animals', methods: ['GET'])]
    #[OA\Get(
        summary: "Get animals by breed",
        description: "Get animals by breed. If breed not found, return 404",
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new Model(type: BreedDTO::class)
    )]
    #[OA\Response(
        response: 404,
        description: 'Breed not found',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Breed not found')
            ]
        )
    )]
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