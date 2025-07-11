<?php

namespace App\Controller;

use App\Entity\Conversation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ConversationController extends AbstractController
{
    #[Route('/api/conversations', name: 'api_conversations', methods: ['GET'])]
    public function listConversations(EntityManagerInterface $em): JsonResponse
    {
        $user = $this->getUser();
        $conversations = $em->getRepository(Conversation::class)
            ->createQueryBuilder('c')
            ->where('c.participantA = :user OR c.participantB = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();

        $data = [];
        foreach ($conversations as $conversation) {
            $other = $conversation->getParticipantA() === $user
                ? $conversation->getParticipantB()
                : $conversation->getParticipantA();

            $data[] = [
                'id' => $conversation->getId(),
                'emetteur' => [
                    'id' => $user->getId(),
                    'nom' => $user->getNom(),
                    'email' => $user->getEmail(),
                ],
                'destinataire' => [
                    'id' => $other->getId(),
                    'nom' => $other->getNom(),
                    'email' => $other->getEmail(),
                ]
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/messagerie', name: 'app_messagerie')]
    public function afficherMessagerie(): Response
    {
        return $this->render('Authenticated/message/messagerie.html.twig', [
            'userId' => $this->getUser()->getId()
        ]);
    }

}
