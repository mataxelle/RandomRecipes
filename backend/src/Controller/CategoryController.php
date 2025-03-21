<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function getCategory(Category $category): JsonResponse
    {
        return $this->json($category, 200, []);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteCategory(Category $category, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $entityManagerInterface->remove($category);
        $entityManagerInterface->flush();

        return $this->json(['message' => 'Category deleted'], 204);
    }
}
