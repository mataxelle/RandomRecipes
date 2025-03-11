<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DietController extends AbstractController
{
    #[Route('/diet', name: 'app_diet')]
    public function index(): Response
    {
        return $this->render('diet/index.html.twig', [
            'controller_name' => 'DietController',
        ]);
    }
}
