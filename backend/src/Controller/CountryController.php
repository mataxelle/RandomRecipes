<?php

namespace App\Controller;

use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class CountryController extends AbstractController
{
    #[Route('/api/country/list', name: 'app_country_list')]
    public function index(CountryRepository $countryRepository): JsonResponse
    {
        $countries = $countryRepository->findAll();
        
        return $this->json($countries);
    }
}
