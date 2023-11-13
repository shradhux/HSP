<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/conference')]
class ConferenceController extends AbstractController
{
    #[Route('/', name: 'app_conference_index', methods: ['GET', 'POST'])]
    public function index(ConferenceRepository $conferenceRepository): Response
    {
        return $this->render('conference/index.html.twig', [
            'conferences' => $conferenceRepository->findAll(),
        ]);
    }
    #[Route('/admin/conference/validation', name: 'admin_conference_validation_page')]
    public function conferenceValidationPage(EntityManagerInterface $entityManager): Response
    {
        $pendingConferences = $entityManager->getRepository(Conference::class)->findBy(['isValidated' => false]);

        return $this->render('conference/conference_validation.html.twig', [
            'pendingConferences' => $pendingConferences,
        ]);
    }

    #[Route('/new', name: 'app_conference_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->remove('ref_user');
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
            // L'administrateur crée la conférence
            $conference->setIsValidated(true); // Automatiquement validé par l'administrateur
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // Si ce n'est pas un administrateur, définissez isValidated sur false, l'administrateur validera plus tard
            if (!$conference->getIsValidated()) {
                $conference->setIsValidated(false);
            }

            $entityManager->persist($conference);
            $entityManager->flush();

            if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
                return $this->redirectToRoute('admin_conference_validation_page');
            } else {

                return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('conference/new.html.twig', [
            'conference' => $conference,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_conference_show', methods: ['GET'])]
    public function show(Conference $conference): Response
    {
        return $this->render('conference/show.html.twig', [
            'conference' => $conference,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_conference_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conference $conference, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('conference/edit.html.twig', [
            'conference' => $conference,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_conference_delete', methods: ['POST'])]
    public function delete(Request $request, Conference $conference, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conference->getId(), $request->request->get('_token'))) {
            $entityManager->remove($conference);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_conference_index', [], Response::HTTP_SEE_OTHER);
    }
}
