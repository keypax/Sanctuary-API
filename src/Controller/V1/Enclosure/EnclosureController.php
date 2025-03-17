<?php declare(strict_types=1);

namespace App\Controller\V1\Enclosure;

use App\Controller\V1\ApiAbstractController;
use App\DTO\V1\AnimalDTO;
use App\DTO\V1\EnclosureDTO;
use App\Repository\V1\Animal\AnimalRepositoryInterface;
use App\Repository\V1\Enclosure\EnclosureRepositoryInterface;
use App\Repository\V1\Enclosure\Exception\EnclosureNotFoundRepositoryException;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/v1/enclosures', name: 'v1_enclosures_')]
class EnclosureController extends ApiAbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private EnclosureRepositoryInterface $enclosureRepository,
        SerializerInterface $serializer
    ) {
        parent::__construct($serializer);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Get(
        summary: "Get all enclosures",
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: EnclosureDTO::class))
        )
    )]
    public function index(): JsonResponse {
        $jsonContent = $this->toJson($this->enclosureRepository->getAll());

        return new JsonResponse($jsonContent, 200, [], true);
    }

    #[Route('/{enclosureId}/animals', name: 'animals', methods: ['GET'])]
    #[OA\Get(
        summary: "Get animals in enclosure",
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
        description: 'Enclosure not found',
        content: new OA\JsonContent(
            type: 'object',
            properties: [
                new OA\Property(property: 'message', type: 'string', example: 'Enclosure not found')
            ]
        )
    )]
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