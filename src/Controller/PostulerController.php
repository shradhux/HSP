<?php

namespace App\Controller;

use App\Entity\Postuler;
use App\Form\PostulerType;
use App\Repository\PostulerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/postuler')]
class PostulerController extends AbstractController
{
    #[Route('/', name: 'app_postuler_index', methods: ['GET'])]
    public function index(PostulerRepository $postulerRepository): Response
    {
        return $this->render('postuler/index.html.twig', [
            'postulers' => $postulerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_postuler_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $postuler = new Postuler();
        $form = $this->createForm(PostulerType::class, $postuler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($postuler);
            $entityManager->flush();

            return $this->redirectToRoute('app_postuler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postuler/new.html.twig', [
            'postuler' => $postuler,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_postuler_show', methods: ['GET'])]
    public function show(Postuler $postuler): Response
    {
        return $this->render('postuler/show.html.twig', [
            'postuler' => $postuler,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_postuler_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Postuler $postuler, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostulerType::class, $postuler);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_postuler_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('postuler/edit.html.twig', [
            'postuler' => $postuler,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_postuler_delete', methods: ['POST'])]
    public function delete(Request $request, Postuler $postuler, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postuler->getId(), $request->request->get('_token'))) {
            $entityManager->remove($postuler);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_postuler_index', [], Response::HTTP_SEE_OTHER);
    }
}
