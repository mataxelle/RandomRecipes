<?php

namespace App\Controller;

use App\Entity\Season;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function getSeason(Season $season): JsonResponse
    {
        return $this->json($season, 200, []);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteSeason(Season $season, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $entityManagerInterface->remove($season);
        $entityManagerInterface->flush();
        
        return $this->json(['message' => 'Season deleted'], 204);
    }
}
