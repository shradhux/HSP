<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserSecurity;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $user->setIsVerified(false); // Défaut à false
        $user->setEstValide(false); // Défaut à false

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser(); // Récupérer l'utilisateur actuel

        if ($currentUser !== null) {
            $isAdmin = in_array("ROLE_ADMIN", $currentUser->getRoles());
            // Vérifier si l'utilisateur actuel est un administrateur et s'il tente de modifier son propre mot de passe
            $isEditingOwnPassword = $isAdmin && $currentUser === $user;

            $form = $this->createForm(UserType::class, $user);
            if (!$currentUser->hasRole("ROLE_ADMIN")) {
                $form->remove("roles");
                $form->remove("est_valide");
                $form->remove("isVerified");

                if (!$currentUser->hasRole("ROLE_HOPITAL")) {
                    $form->remove("role");
                    $form->remove("rue");
                    $form->remove("code_postal");
                    $form->remove("ville");
                }
                if (!$currentUser->hasRole("ROLE_ETUDIANT")) {
                    $form->remove("domaine_etude");

                }


                // Si l'utilisateur n'est pas en train de modifier son propre mot de passe, retirez le champ de mot de passe du formulaire
                if (!$isEditingOwnPassword) {
                    $form->remove('password');
                }

                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    // Empêcher un administrateur de modifier le mot de passe des autres utilisateurs
                    if ($form->has('roles')) {
                        $user->setRoles([$form->get('roles')->getData()]);
                    }
                    if ($user->getRoles() == ["ROLE_ADMIN"]) {
                        throw new AccessDeniedException('Vous n\'êtes pas autorisé à modifier le mot de passe des autres utilisateurs.');
                    }
                    $entityManager->persist($user);
                    $entityManager->flush();

                    return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('user/edit.html.twig', [
                    'user' => $user,
                    'form' => $form,
                ]);
            } else {
                return $this->redirectToRoute('app_default');
                // Gérer le cas où l'utilisateur n'est pas authentifié, par exemple, rediriger vers une page de connexion
            }
        }
    }
    #[Route('/valide-compte/{id}', name: 'app_valide_compte')]
    public function valideCompte(User $user, Request $request)
    {
        // Passer l'entité User au formulaire
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsVerified(true);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a été validé avec succès.');

            return $this->redirectToRoute('app_validation_index');
        }

        return $this->render('account/validation.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


}
