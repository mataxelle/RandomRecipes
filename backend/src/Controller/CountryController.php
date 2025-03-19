<?php

namespace App\Controller;

use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/country', name: 'app_country_')]
final class CountryController extends AbstractController
{
    #[Route('/list', name: 'list', methods: ['GET'])]
    public function getCountryList(CountryRepository $countryRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $countries = $countryRepository->findAll();
        $jsonCountryList = $serializerInterface->serialize($countries, 'json');
        
        return new JsonResponse($jsonCountryList, 200, [], true);
    }
}
