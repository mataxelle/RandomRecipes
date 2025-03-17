<?php

namespace App\Controller;

use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class SeasonController extends AbstractController
{
    #[Route('/api/season/list', name: 'app_season')]
    public function index(SeasonRepository $seasonRepository): JsonResponse
    {
        $seasons = $seasonRepository->findAll();

        return $this->json([$seasons]);
    }
}
