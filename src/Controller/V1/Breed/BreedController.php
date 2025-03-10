<?php

namespace App\Controller\V1\Breed;

use App\Repository\V1\Animal\AnimalRepositoryInterface;
use App\Repository\V1\Breed\BreedRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/breeds', name: 'v1_breeds_')]
class BreedController extends AbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private BreedRepositoryInterface $breedRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse {
        $jsonContent = $this->serializer->serialize(
            $this->breedRepository->getAll(), 'json'
        );

        return new JsonResponse($jsonContent, 200, [], true);
    }
}