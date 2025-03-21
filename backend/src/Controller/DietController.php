<?php

namespace App\Controller;

use App\Entity\Diet;
use App\Repository\DietRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/diet', name: 'app_diet_')]
final class DietController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getDietList(DietRepository $dietRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $diets = $dietRepository->findAll();
        $jsonDietList = $serializerInterface->serialize($diets, 'json');

        return new JsonResponse($jsonDietList, 200, [], true);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function getDiet(Diet $diet): JsonResponse
    {
        return $this->json($$diet, 200, []);
    }
}
