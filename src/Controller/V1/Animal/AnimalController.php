<?php declare(strict_types=1);

namespace App\Controller\V1\Animal;

use App\Controller\V1\ApiAbstractController;
use App\Repository\V1\Animal\AnimalRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/animals', name: 'v1_animals_')]
class AnimalController extends ApiAbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private SerializerInterface $serializer
    ) {
        parent::__construct($serializer);
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse {
        $jsonContent = $this->toJson($this->animalRepository->getAll());

        return new JsonResponse($jsonContent, 200, [], true);
    }
}
