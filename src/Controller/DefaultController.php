<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Mission;
use App\Entity\Utilisateur;
use App\Form\RoleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les deux dernières missions
        $missions = $entityManager->getRepository(Mission::class)
            ->findBy([], ['id' => 'DESC'], 2);

        // Passer les missions à la vue
        return $this->render('default/index.html.twig', [
            'missions' => $missions,
        ]);
    }

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request): Response
    {
        $form = $this->createForm(RoleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $role = $formData['role'];

            if ($role == 'ROLE_CLIENT') {
                return $this->redirectToRoute('app_inscription_client');
            } else {
                return $this->redirectToRoute('app_inscription_freelance');
            }
        }

        return $this->render('default/inscription/inscription.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/missions', name: 'app_missions')]
    public function missions(EntityManagerInterface $entityManager): Response
    {
        $missions = $entityManager->getRepository(Mission::class)->findAll();
        return $this->render('default/lesMissions.html.twig', [
            'missions' => $missions
        ]);
    }

    #[Route('/monCompte', name: 'app_monCompte')]
    public function profil(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if($user instanceof Client){
            $missions = $entityManager->getRepository(Mission::class)->findBy([
                'client' => $user
            ], [
                'datePublication' => 'DESC' // Optionnel : tri par date décroissante
            ], 3);
            return $this->render('Authenticated/profil.html.twig', [
                'user' => $user,
                'missions' => $missions,
            ]);
        } else {
            return $this->render('Authenticated/profil.html.twig', [
                'user' => $user,
            ]);
        }

    }

    #[Route('/mission_n°{id}/en-savoir-plus', name: 'app_mission_enSavoirPlus')]
    public function enSavoirPlus(int $id, EntityManagerInterface $entityManager): Response
    {
        $mission = $entityManager->getRepository(Mission::class)->find($id);
        if (!$mission) {
            throw $this->createNotFoundException('Mission non trouvée.');
        }
        return $this->render('default/uneMission.html.twig', [
            'mission' => $mission
        ]);
    }

    #[Route('/profil-{id}', name: 'app_profil')]
    public function profilUnUtilisateur(int $id, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = $entityManager->getRepository(Utilisateur::class)->find($id);
        if (!$utilisateur) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }
        if($utilisateur instanceof Client){
            $missions = $entityManager->getRepository(Mission::class)->findBy([
                'client' => $utilisateur
            ], [
                'datePublication' => 'DESC' // Optionnel : tri par date décroissante
            ], 3);
            return $this->render('default/unUtilisateur.html.twig', [
                'user' => $utilisateur,
                'missions' => $missions,
                'utilisateurMail' => $utilisateur->getEmail(),
                'utilisateur' => $utilisateur->getNom()
            ]);
        } else {
            return $this->render('default/unUtilisateur.html.twig', [
                'user' => $utilisateur,
                'utilisateurMail' => $utilisateur->getEmail(),
                'utilisateur' => $utilisateur->getNom()
            ]);
        }
    }
}
