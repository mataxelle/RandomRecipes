<?php

namespace App\Controller;

use App\Repository\SeasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/season', name: 'app_season_')]
final class SeasonController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getSeasonList(SeasonRepository $seasonRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $seasons = $seasonRepository->findAll();
        $jsonSeasonList = $serializerInterface->serialize($seasons, 'json');

        return new JsonResponse($jsonSeasonList, 200, [], true);
    }
}
