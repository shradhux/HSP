<?php

namespace App\Controller;

use App\Entity\Conference;
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



    #[Route('/inscription/{id}/rejoindre', name: 'app_inscription_rejoindre', methods: ['GET','POST'])]
    public function rejoindre(Conference $conference): Response
    {

        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }


    #[Route('/quitter', name: 'app_inscription_quitter')]
    public function quitter(): Response
    {
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'InscriptionController',
        ]);
    }
}
