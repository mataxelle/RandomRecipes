<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/category', name: 'app_category_')]
final class CategoryController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getCategoryList(CategoryRepository $categoryRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $categories = $categoryRepository->findAll();
        $jsonCategoryList = $serializerInterface->serialize($categories, 'json');

        return new JsonResponse($jsonCategoryList, 200, [], true);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function getCategory(int $id, CategoryRepository $categoryRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException("No result");
        }

        $jsonCategory = $serializerInterface->serialize($category, 'json');
        return new JsonResponse($jsonCategory, 200, [], true);
    }
}
