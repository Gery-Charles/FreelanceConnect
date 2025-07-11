<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\ClientType;
use App\Form\CreerMissionType;
use App\Form\MissionImgType;
use App\Security\SecurityAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ClientController extends AbstractController
{
    #[Route('/inscription/client', name: 'app_inscription_client')]
    public function InscriptionClient(Request $request,  UserPasswordHasherInterface $clientPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClientType::class);
        $form->handleRequest($request);
        $plainPassword = $form->get('plainPassword')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $client = $form->getData();
            $client->setEmail($client->getEmail());
            $client->setNom($client->getNom());
            $client->setPassword(
                $clientPasswordHasher->hashPassword(
                    $client,
                    $plainPassword
                )
            );
            $client->setRole('ROLE_CLIENT');

            $entityManager->persist($client);
            $entityManager->flush();

            return $security->login($client, SecurityAuthenticator::class, 'main');

        }

        return $this->render('default/Inscription/inscriptionClient.html.twig', [
            'formClient' => $form->createView(),
        ]);
    }

    #[IsGranted("ROLE_CLIENT")]
    #[Route('/client/missions', name: 'app_client_missions')]
    public function afficherMissions(EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'utilisateur connecté
        $client = $this->getUser();

        // Récupérer les missions liées à ce client
        $missions = $entityManager->getRepository(Mission::class)->findBy([
            'client' => $client
        ], [
            'datePublication' => 'DESC' // Optionnel : tri par date décroissante
        ]);

        return $this->render('Authenticated/Client/clientMissions.html.twig', [
            'missions' => $missions,
        ]);
    }


    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('client/creer-mission', name: 'app_client_creer-mission')]
    public function creerMission(Request $request): Response
    {
        $form = $this->createForm(CreerMissionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Stocker les données temporairement en session
            $data = $form->getData();
            $request->getSession()->set('mission_data', [
                'titre' => $data->getTitre(),
                'description' => $data->getDescription(),
                'duree' => $data->getDuree(),
                'categorie' => $data->getCategorie()

            ]);

            // Redirection vers le formulaire d'image
            return $this->redirectToRoute('app_client_creer_mission-image');
        }

        return $this->render('Authenticated/Client/creerMission.html.twig', [
            'formMission' => $form->createView(),
        ]);
    }

    #[Route('/client/creer-mission/image', name: 'app_client_creer_mission-image')]
    #[IsGranted("ROLE_CLIENT")]
    public function ajouterImageMission(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sessionData = $request->getSession()->get('mission_data');

        if (!$sessionData) {
            // Retour au début si pas de données
            return $this->redirectToRoute('app_client_creer-mission');
        }

        $mission = new Mission();
        $form = $this->createForm(MissionImgType::class, $mission, [
            'existing_images' => $this->getExistingImages(), // méthode à créer
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Renseigner les autres infos récupérées de la session
            $mission->setTitre($sessionData['titre']);
            $mission->setDescription($sessionData['description']);
            $mission->setDuree($sessionData['duree']);
            $mission->setCategorie($sessionData['categorie']);
            $mission->setClient($this->getUser());
            $mission->setDatePublication(new \DateTime());
            $mission->setNombreCandidatures(0);

            // Vérifier si une image a été uploadée
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                // Si une image est uploadée via VichUploader
                $mission->setIsImageUploaded(true);
            } else {
                // Si une image est choisie parmi les existantes
                $selectedImage = $form->get('imageName')->getData();
                if ($selectedImage) {
                    $mission->setImageName($selectedImage);
                    $mission->setIsImageUploaded(false);
                }
            }

            $entityManager->persist($mission);
            $entityManager->flush();

            // Nettoyer la session
            $request->getSession()->remove('mission_data');

            return $this->redirectToRoute('app_client_missions');
        }

        return $this->render('Authenticated/Client/ajouterImageMission.html.twig', [
            'formMission' => $form->createView(),
        ]);
    }


    private function getExistingImages(): array
    {
        $dir = $this->getParameter('kernel.project_dir') . '/public/images/';
        $files = array_diff(scandir($dir), ['.', '..']);
        $choices = [];
        foreach ($files as $file) {
            $choices[$file] = $file;
        }
        return $choices;
    }


}
