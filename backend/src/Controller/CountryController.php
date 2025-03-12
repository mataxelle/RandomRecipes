<?php

namespace App\Controller;

use App\Repository\CountryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CountryController extends AbstractController
{
    #[Route('/api/country/list', name: 'app_country')]
    public function index(CountryRepository $countryRepository): Response
    {
        $countries = $countryRepository->findAll();
        
        return $this->json($countries);
    }
}
