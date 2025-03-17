<?php

namespace App\Controller;

use App\Repository\StepRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class StepController extends AbstractController
{
    #[Route('/api/step/list', name: 'app_step')]
    public function index(StepRepository $stepRepository): JsonResponse
    {
        $steps = $stepRepository->findAll();

        return $this->json([$steps]);
    }
}
