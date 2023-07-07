<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthController extends AbstractController
{
    #[Route('/server/health', name: 'app_health')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'OK',
            'status' => Response::HTTP_OK,
        ]);
    }
}
