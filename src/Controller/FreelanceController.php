<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Freelance;
use App\Entity\Message;
use App\Entity\Mission;
use App\Form\FreelanceType;
use App\Security\SecurityAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

final class FreelanceController extends AbstractController
{
    #[Route('/inscription/freelance', name: 'app_inscription_freelance')]
    public function InscriptionClient(Request $request,  UserPasswordHasherInterface $clientPasswordHasher, Security $security, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FreelanceType::class);
        $form->handleRequest($request);
        $plainPassword = $form->get('plainPassword')->getData();
        if ($form->isSubmitted() && $form->isValid()) {
            $freelance = $form->getData();

            $freelance->setEmail($freelance->getEmail());
            $freelance->setNom($freelance->getNom());
            $freelance->setPrenom($freelance->getPrenom());
            $freelance->setCompetances($freelance->getCompetances());
            $freelance->setPassword(
                $clientPasswordHasher->hashPassword(
                    $freelance,
                    $plainPassword
                )
            );
            $freelance->setRole('ROLE_FREELANCE');

            $entityManager->persist($freelance);
            $entityManager->flush();

            return $security->login($freelance, SecurityAuthenticator::class, 'main');

            //message indiquant la reussite de la création de compte

        }

        return $this->render('default/Inscription/inscriptionFreelance.html.twig', [
            'formFreelance' => $form->createView(),
        ]);
    }
    #[Route('/mission/{id}/postuler', name: 'app_freelance_postuler')]
    public function candidater(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Rediriger un client qui essaie de postuler
        if (in_array('ROLE_CLIENT', $this->getUser()->getRoles())) {
            $referer = $request->headers->get('referer');
            return new RedirectResponse($referer ?: $this->generateUrl('app_home'));
        }

        $mission = $entityManager->getRepository(Mission::class)->find($id);
        if (!$mission) {
            throw $this->createNotFoundException('Mission non trouvée.');
        }

        /** @var Freelance $freelance */
        $freelance = $entityManager->getRepository(Freelance::class)
            ->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

        if (!$freelance) {
            throw $this->createNotFoundException('Freelance non trouvé.');
        }

        // ✅ Vérifie si le freelance a déjà postulé à cette mission
        if ($freelance->getMissions()->contains($mission)) {
            // Rediriger vers ses candidatures sans réincrémentation
            $this->addFlash('info', 'Vous avez déjà postulé à cette mission.');
            return $this->redirectToRoute('app_freelance_candidatures');
        }

        // Incrémentation du nombre de candidatures
        $mission->setNombreCandidatures($mission->getNombreCandidatures() + 1);

        // Ajouter la mission au freelance
        $freelance->addMission($mission);
        $client = $mission->getClient();

        // ✅ Vérifie s’il existe déjà une conversation entre le freelance et le client
        $conversationRepo = $entityManager->getRepository(Conversation::class);
        $conversations = $conversationRepo->createQueryBuilder('c')
            ->where('(c.participantA = :freelance AND c.participantB = :client)')
            ->orWhere('(c.participantA = :client AND c.participantB = :freelance)')
            ->setParameter('freelance', $freelance)
            ->setParameter('client', $client)
            ->orderBy('c.id', 'DESC') // Optionnel : pour prendre la plus récente
            ->getQuery()
            ->getResult();

        $existingConversation = $conversations[0] ?? null;


        // Création du message
        $message = new Message();
        $message->setContenu(sprintf(
            'Le freelance "%s" a postulé à votre mission "%s".',
            $freelance->getNom(),
            $mission->getTitre()
        ));
        $message->setEmetteur($freelance);
        $message->setDateEnvoi(new \DateTime());
        $message->addReceveur($client);

        if ($existingConversation) {
            // ✅ Ajouter le message à la conversation existante
            $existingConversation->addMessage($message);
            $entityManager->persist($existingConversation);
        } else {
            // ❌ Sinon, on en crée une nouvelle
            $conversation = new Conversation();
            $conversation->setParticipantA($freelance);
            $conversation->setParticipantB($client);
            $conversation->addMessage($message);
            $entityManager->persist($conversation);
        }

        $entityManager->persist($freelance);
        $entityManager->persist($message);
        $entityManager->flush();

        return $this->redirectToRoute('app_freelance_candidatures');
    }


    #[Route('/freelance/mesCandidatures', name: 'app_freelance_candidatures')]
    public function mesCandidatures(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (in_array('ROLE_CLIENT', $this->getUser()->getRoles())) {
            // Redirection vers la page précédente
            $referer = $request->headers->get('referer');
            return new RedirectResponse($referer ?: $this->generateUrl('app_home'));
        }

        $freelance = $entityManager->getRepository(Freelance::class)
            ->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

        $candidatures = $freelance->getMissions();

        return $this->render('Authenticated/Freelance/candidatures.html.twig', [
            'candidatures' => $candidatures
        ]);
    }
}
