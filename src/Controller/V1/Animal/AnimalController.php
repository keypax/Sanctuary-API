<?php declare(strict_types=1);

namespace App\Controller\V1\Animal;

use App\Repository\V1\Animal\AnimalRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/animals', name: 'v1_animals_')]
class AnimalController extends AbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse {
        $jsonContent = $this->serializer->serialize(
            $this->animalRepository->getAll(), 'json'
        );

        return new JsonResponse($jsonContent, 200, [], true);
    }
}
