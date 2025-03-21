<?php

namespace App\Controller;

use App\Entity\Step;
use App\Repository\StepRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteStep(Step $step, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $entityManagerInterface->remove($step);
        $entityManagerInterface->flush();
        
        return $this->json(['message' => 'Step deleted'], 204);
    }
}
