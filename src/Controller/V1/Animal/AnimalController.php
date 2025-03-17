<?php declare(strict_types=1);

namespace App\Controller\V1\Animal;

use App\Controller\V1\ApiAbstractController;
use App\DTO\V1\AnimalDTO;
use App\Repository\V1\Animal\AnimalRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;

#[Route('/v1/animals', name: 'v1_animals_')]
class AnimalController extends ApiAbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        SerializerInterface $serializer
    ) {
        parent::__construct($serializer);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    #[OA\Get(
        summary: "Get all animals",
    )]
    #[OA\Response(
        response: 200,
        description: 'Successful response',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: AnimalDTO::class))
        )
    )]
    public function index(): JsonResponse {
        $jsonContent = $this->toJson($this->animalRepository->getAll());

        return new JsonResponse($jsonContent, 200, [], true);
    }
}
