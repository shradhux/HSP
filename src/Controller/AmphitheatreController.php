<?php

namespace App\Controller;

use App\Entity\Amphitheatre;
use App\Form\AmphitheatreType;
use App\Repository\AmphitheatreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/amphitheatre')]
class AmphitheatreController extends AbstractController
{
    #[Route('/', name: 'app_amphitheatre_index', methods: ['GET'])]
    public function index(AmphitheatreRepository $amphitheatreRepository): Response
    {
        return $this->render('amphitheatre/index.html.twig', [
            'amphitheatres' => $amphitheatreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_amphitheatre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $amphitheatre = new Amphitheatre();
        $form = $this->createForm(AmphitheatreType::class, $amphitheatre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($amphitheatre);
            $entityManager->flush();

            return $this->redirectToRoute('app_amphitheatre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('amphitheatre/new.html.twig', [
            'amphitheatre' => $amphitheatre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_amphitheatre_show', methods: ['GET'])]
    public function show(Amphitheatre $amphitheatre): Response
    {
        return $this->render('amphitheatre/show.html.twig', [
            'amphitheatre' => $amphitheatre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_amphitheatre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Amphitheatre $amphitheatre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AmphitheatreType::class, $amphitheatre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_amphitheatre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('amphitheatre/edit.html.twig', [
            'amphitheatre' => $amphitheatre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_amphitheatre_delete', methods: ['POST'])]
    public function delete(Request $request, Amphitheatre $amphitheatre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$amphitheatre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($amphitheatre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_amphitheatre_index', [], Response::HTTP_SEE_OTHER);
    }
}
