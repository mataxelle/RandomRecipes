<?php

namespace App\Controller;

use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SeasonController extends AbstractController
{
    #[Route('/api/season/list', name: 'app_season')]
    public function index(SeasonRepository $seasonRepository): Response
    {
        $seasons = $seasonRepository->findAll();

        return $this->json([$seasons]);
    }
}
