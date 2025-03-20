<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/recipe', name: 'app_recipe_')]
final class RecipeController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getRecipeList(RecipeRepository $recipeRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $recipes = $recipeRepository->findAll();
        $jsonRecipeList = $serializerInterface->serialize($recipes, 'json');

        return new JsonResponse($jsonRecipeList, 200, [], true);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function getRecipe(int $id, RecipeRepository $recipeRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $recipe = $recipeRepository->find($id);

        if (!$recipe) {
            throw $this->createNotFoundException("No result");
        }

        $jsonRecipe = $serializerInterface->serialize($recipe, 'json');
        return new JsonResponse($jsonRecipe, 200, [], true);
    }
}
