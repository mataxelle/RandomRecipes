<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class IngredientController extends AbstractController
{
    #[Route('/api/ingredient/list', name: 'app_ingredient')]
    public function index(IngredientRepository $ingredientRepository): JsonResponse
    {
        $ingredients = $ingredientRepository->findAll();

        return $this->json([$ingredients]);
    }
}
