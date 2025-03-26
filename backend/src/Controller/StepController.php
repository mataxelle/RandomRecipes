<?php

namespace App\Controller;

use App\Entity\Step;
use App\Repository\StepRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/step', name: 'app_step_')]
final class StepController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getStepList(StepRepository $stepRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $steps = $stepRepository->findAll();
        $jsonStepList = $serializerInterface->serialize($steps, 'json');

        return new JsonResponse($jsonStepList, 200, [], true);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function getStep(Step $step): JsonResponse
    {
        return $this->json($step, 200, []);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse
    {
        $step = $serializerInterface->deserialize($request->getContent(), Step::class, 'json');

        $errors = $validatorInterface->validate($step);
        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        $entityManagerInterface->persist($step);
        $entityManagerInterface->flush();

        return $this->json($step, 201, []);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(
        Step $step,
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SerializerInterface $serializerInterface,
        ValidatorInterface $validatorInterface
    ): JsonResponse
    {
        $serializerInterface->deserialize($request->getContent(), Step::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $step]);

        $errors = $validatorInterface->validate($step);
        if ($errors->count() > 0) {
            return $this->json($errors, 400);
        }

        $entityManagerInterface->persist($step);
        $entityManagerInterface->flush();

        return $this->json($step, 200, []);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteStep(Step $step, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $entityManagerInterface->remove($step);
        $entityManagerInterface->flush();
        
        return $this->json(['message' => 'Step deleted'], 204);
    }
}
