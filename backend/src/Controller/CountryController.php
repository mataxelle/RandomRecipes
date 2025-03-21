<?php

namespace App\Controller;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function deleteCountry(Country $country, EntityManagerInterface $entityManagerInterface): JsonResponse
    {
        $entityManagerInterface->remove($country);
        $entityManagerInterface->flush();

        return $this->json(['message' => 'Country deleted'], 204);
    }
}
