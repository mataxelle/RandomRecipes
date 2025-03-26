<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    #[Route('create', name: 'create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse
    {
        $recipe = $serializerInterface->deserialize($request->getContent(), Recipe::class, 'json');

        $errors = $validatorInterface->validate($recipe);
        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        $entityManagerInterface->persist($recipe);
        $entityManagerInterface->flush();

        return $this->json($recipe, 201, [], ['groups' => 'recipe:read']);
    }

    #[Route('{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Recipe $recipe,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse
    {
        $serializerInterface->deserialize($request->getContent(), Recipe::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $recipe]);

        $errors = $validatorInterface->validate($recipe);
        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        $entityManagerInterface->persist($recipe);
        $entityManagerInterface->flush();

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
