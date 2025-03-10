<?php declare(strict_types=1);

namespace App\Controller\V1\Enclosure;

use App\Repository\V1\AnimalRepositoryInterface;
use App\Repository\V1\EnclosureRepository;
use App\Repository\V1\EnclosureRepositoryInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/v1/enclosures', name: 'v1_enclosures_')]
class EnclosureController extends AbstractController
{
    public function __construct(
        private AnimalRepositoryInterface $animalRepository,
        private EnclosureRepositoryInterface $enclosureRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse {
        $jsonContent = $this->serializer->serialize(
            $this->enclosureRepository->getAll(), 'json'
        );

        return new JsonResponse($jsonContent, 200, [], true);
    }
}