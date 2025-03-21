<?php

namespace App\Controller;

use App\Entity\Country;
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

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function getCountry(Country $country): JsonResponse
    {
        return $this->json($country, 200, []);
    }
}
