<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Entity\User;
use App\Form\RendezVousType;
use App\Form\RendezVousTypeValidation;
use App\Repository\PostulerRepository;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/rendez/vous')]
class RendezVousController extends AbstractController
{
    #[Route('/', name: 'app_rendez_vous_index', methods: ['GET'])]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'rendez_vouses' => $rendezVousRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rendezVou = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rendez_vous/new.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

/*    #[Route('/{id}', name: 'app_rendez_vous_show', methods: ['GET'])]
    public function show(RendezVous $rendezVou): Response
    {
        return $this->render('rendez_vous/show.html.twig', [
            'rendez_vou' => $rendezVou,
        ]);
    }
*/
    #[Route('/{id}/edit', name: 'app_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rendez_vous/edit.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

  /*  #[Route('/{id}', name: 'app_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {

        return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
*/
    #[Route('/confirmation', name: 'app_rendez_vous_confirmation', methods: ['GET'])]
    public function rdvhopital(PostulerRepository $lespostulations): Response
    {



        ob_start();
        return $this->render('rendez_vous/confirmation.html.twig', [
            'postuler' => $lespostulations->findAll(),
        ]);
    }

    #[Route('/{id}/newrdv', name: 'app_rendez_vous_ajout', methods: ['GET', 'POST'])]
    public function ajtrdv(Request $request, RendezVous $rendezVou, EntityManagerInterface $entityManager): Response
    {


        $form = $this->createForm(RendezVousTypeValidation::class, $rendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rendez_vous/validation.html.twig', [
            'rendez_vou' => $rendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/accepterrdv', name: 'app_rendez_vous_accepter_index', methods: ['GET', 'POST'])]
    public function consultrdv(User $user, RendezVousRepository $rendezVousRepository, PostulerRepository $postulerRepository): Response
    {

        $rendezVousAvecUserNull = [];
        $lesrdv = $postulerRepository->findBy(['user' => $this->getUser()]);
        $rdvfiltre = $rendezVousRepository->createQueryBuilder('r')
            ->where('r.ref_user IS NULL')
            ->andWhere('r.date IS NOT NULL')
            ->getQuery()
            ->getResult();

        foreach ($lesrdv as $unrdv){
        foreach ($rdvfiltre as $lerdv){
if ($lerdv->getId()==$unrdv->getRendezVous()->getId())
    $rendezVousAvecUserNull[] = $lerdv;
        }
        }

        return $this->render('rendez_vous/accepter_index.html.twig', [
            'rendez_vouses' => $rendezVousAvecUserNull,
        ]);
    }

    #[Route('{id}/acceptation', name: 'app_rendez_vous_acceptation', methods: ['GET', 'POST'])]
    public function accepterrdv(Request $request, EntityManagerInterface $entityManager , RendezVousRepository $rendezVousRepository,RendezVous $rendezVous, PostulerRepository $postulerRepository): Response
    {


        $rendezVous->setRefUser($this->getUser());




        $entityManager->persist($rendezVous);
        $entityManager->flush();
        return $this->redirectToRoute("app_default");
    }
}
