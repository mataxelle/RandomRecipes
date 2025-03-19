<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/ingredient', name: 'app_ingredient_')]
final class IngredientController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getIngredientList(IngredientRepository $ingredientRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $ingredients = $ingredientRepository->findAll();
        $jsonIngredientList = $serializerInterface->serialize($ingredients, 'json');

        return new JsonResponse($jsonIngredientList, 200, [], true);
    }
}
