<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
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
        $jsonRecipeList = $serializerInterface->serialize($recipes, 'json', ['groups' => 'recipe:read']);

        return new JsonResponse($jsonRecipeList, 200, [], true);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function getRecipe(Recipe $recipe): JsonResponse
    {
        return $this->json($recipe, 200, [], ['groups' => 'recipe:read']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteRecipe(Recipe $recipe, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $entityManagerInterface->remove($recipe);
        $entityManagerInterface->flush();

        return $this->json(['message' => 'Recipe deleted'], 204);
    }
}
