<?php

namespace App\Controller;

use App\Entity\Diet;
use App\Repository\DietRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse
    {
        $diet = $serializerInterface->deserialize($request->getContent(), Diet::class, 'json');

        $errors = $validatorInterface->validate($diet);
        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        $entityManagerInterface->persist($diet);
        $entityManagerInterface->flush();

        return $this->json($diet, 201, []);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Diet $diet,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse
    {
        $serializerInterface->deserialize($request->getContent(), Diet::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $diet]);

        $errors = $validatorInterface->validate($diet);
        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        $entityManagerInterface->persist($diet);
        $entityManagerInterface->flush();

        return $this->json($diet, 200, []);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deteleDiet(Diet $diet, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $entityManagerInterface->remove($diet);
        $entityManagerInterface->flush();

        return $this->json(['message' => 'Diet deleted'], 204);
    }
}
