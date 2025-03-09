<?php declare(strict_types=1);

namespace App\Controller\V1\Animal;

use App\Repository\V1\AnimalRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/animal', name: 'v1_animal_')]
class AnimalController extends AbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('/all', name: 'all', methods: ['GET'])]
    public function all(): JsonResponse {
        $jsonContent = $this->serializer->serialize($this->animalRepository->getAll(), 'json');

        return new JsonResponse($jsonContent, 200, [], true);
    }
}
