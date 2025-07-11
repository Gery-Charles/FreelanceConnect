<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /**
     * Récupérer la liste des conversations de l’utilisateur connecté
     */
    #[Route('/api/conversations', name: 'api_conversations_list', methods: ['GET'])]
    public function listConversations(EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();
        $repo = $em->getRepository(Conversation::class);

        // Rechercher toutes les conversations où l'utilisateur est participant
        $conversations = $repo->createQueryBuilder('c')
            ->where('c.participantA = :user OR c.participantB = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        $data = [];
        foreach ($conversations as $conversation) {
            // Déterminer l’autre participant (destinataire)
            $otherUser = $conversation->getParticipantA() === $user ? $conversation->getParticipantB() : $conversation->getParticipantA();

            $data[] = [
                'id' => $conversation->getId(),
                'destinataire' => [
                    'id' => $otherUser->getId(),
                    'nom' => $otherUser->getNom(),
                    'prenom' => $otherUser->getPrenom(),
                    'email' => $otherUser->getEmail(),
                ],
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Récupérer les messages d’une conversation
     */
    #[Route('/api/conversations/{id}/messages', name: 'api_conversation_messages', methods: ['GET'])]
    public function getConversationMessages(int $id, EntityManagerInterface $em): JsonResponse
    {
        $conversation = $em->getRepository(Conversation::class)->find($id);
        $user = $this->getUser();

        if (!$conversation || !in_array($user, [$conversation->getParticipantA(), $conversation->getParticipantB()])) {
            return new JsonResponse(['error' => 'Conversation inaccessible.'], 403);
        }

        $messages = $conversation->getMessages();
        $data = [];

        foreach ($messages as $message) {
            $data[] = [
                'id' => $message->getId(),
                'contenu' => $message->getContenu(),
                'emetteur' => [
                    'id' => $message->getEmetteur()->getId(),
                    'nom' => $message->getEmetteur()->getNom(),
                ],
                'dateEnvoi' => $message->getDateEnvoi()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse($data);
    }

    /**
     * Envoyer un message à un destinataire (création ou récupération de conversation)
     */
    #[Route('/api/messages', name: 'api_message_post', methods: ['POST'])]
    public function newMessage(Request $request, EntityManagerInterface $em, Security $security): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        /** @var Utilisateur $emetteur */
        $emetteur = $security->getUser();

        if (empty($data['contenu']) || empty($data['receveur_id'])) {
            return new JsonResponse(['error' => 'Données incomplètes.'], 400);
        }

        $receveur = $em->getRepository(Utilisateur::class)->find($data['receveur_id']);
        if (!$receveur || $receveur === $emetteur) {
            return new JsonResponse(['error' => 'Destinataire invalide.'], 400);
        }

        // Chercher conversation existante (participant A/B interchangeables)
        $conversationRepo = $em->getRepository(Conversation::class);
        $conversation = $conversationRepo->findOneBy([
            'participantA' => $emetteur,
            'participantB' => $receveur,
        ]) ?? $conversationRepo->findOneBy([
            'participantA' => $receveur,
            'participantB' => $emetteur,
        ]);

        if (!$conversation) {
            $conversation = new Conversation();
            $conversation->setParticipantA($emetteur);
            $conversation->setParticipantB($receveur);
            $em->persist($conversation);
        }

        $message = new Message();
        $message->setContenu($data['contenu']);
        $message->setDateEnvoi(new \DateTime());
        $message->setEmetteur($emetteur);
        $message->addReceveur($receveur);
        $message->setConversation($conversation);

        $em->persist($message);
        $em->flush();

        return new JsonResponse([
            'status' => 'Message envoyé',
            'conversation_id' => $conversation->getId(),
            'message_id' => $message->getId(),
        ], 201);
    }
}
