<?php
namespace App\Controller;

use App\Repository\MissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MissionApiController extends AbstractController
{
    #[Route('/api/missions', name: 'api_missions', methods: ['GET'])]
    public function index(MissionRepository $missionRepository): JsonResponse
    {
        $missions = $missionRepository->findAll();
        return $this->json($missions, 200, [], ['groups' => 'mission:read']);
    }
}
