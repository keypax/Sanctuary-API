<?php declare(strict_types=1);

namespace App\Controller\V1\Species;

use App\Controller\V1\ApiAbstractController;
use App\DTO\V1\AnimalDTO;
use App\DTO\V1\BreedDTO;
use App\DTO\V1\SpeciesDTO;
use App\Repository\V1\Animal\AnimalRepositoryInterface;
use App\Repository\V1\Breed\BreedRepositoryInterface;
use App\Repository\V1\Species\Exception\SpeciesNotFoundRepositoryException;
use App\Repository\V1\Species\SpeciesRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/v1/species', name: 'v1_species_')]
class SpeciesController extends ApiAbstractController
{
    public function __construct(
        private SpeciesRepositoryInterface $speciesRepository,
        private AnimalRepositoryInterface $animalRepository,
        private BreedRepositoryInterface $breedRepository,
        SerializerInterface $serializer
    ) {
        parent::__construct($serializer);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Get(
        summary: "Get all species",
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: SpeciesDTO::class))
        )
    )]
    public function index(): JsonResponse {
        $jsonContent = $this->toJson($this->speciesRepository->getAll());

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/{speciesId}/breeds', name: 'breeds', methods: ['GET'])]
    #[OA\Get(
        summary: "Get breeds by species",
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: BreedDTO::class))
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Species not found',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Species not found')
            ]
        )
    )]
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
    #[OA\Get(
        summary: "Get animals by species",
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AnimalDTO::class))
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Species not found',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Species not found')
            ]
        )
    )]
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