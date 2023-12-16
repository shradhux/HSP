<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Entity\Inscription;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }



    #[Route('/{id}/rejoindre', name: 'app_inscription_rejoindre', methods: ['POST'])]
    public function rejoindre(Conference $conference, ConferenceRepository $conferenceRepository, EntityManagerInterface $entityManager): Response
    {
        $inscription = new Inscription();
        $inscription->setConference($conference);
        $inscription->setUser($this->getUser());


        $entityManager->persist($inscription);
        $entityManager->flush();

        return $this->render('conference/conference_index.html.twig', [
            'conferences' => $conferenceRepository->findBy(['isValidated' => true]),
        ]);
    }

    #[Route('/{id}/quitter', name: 'app_inscription_quitter', methods: ['POST'])]
    public function quitter(Conference $conference, ConferenceRepository $conferenceRepository, EntityManagerInterface $entityManager): Response
    {
        $inscription = $entityManager->getRepository(Inscription::class)->findOneBy([
            'conference' => $conference,
            'user' => $this->getUser(),
        ]);


        $entityManager->remove($inscription);
        $entityManager->flush();

        return $this->render('conference/conference_index.html.twig', [
            'conferences' => $conferenceRepository->findBy(['isValidated' => true]),
        ]);
    }





}
