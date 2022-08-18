<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/register', name: 'app_user_register')]
    public function register(Request $request, UserRepository $repository, UserPasswordHasherInterface $hasher,EntityManagerInterface $entityManager): Response
    {

        $newUser = new User();

       // Create the form 
       $form = $this->createForm(RegisterFormType::class);

       // Fill with the infos of the user
       $form->handleRequest($request);

       // Condition if the form it was send and it was valide
       if ($form->isSubmitted() && $form->isValid()) {
           // Get the new user
           $user = $form->getData();

           // Encrypt the password
           $cryptedPassword = $hasher->hashPassword($user, $user->getPassword());
           $user->setPassword($cryptedPassword);

            // Register in the database
            $repository->add($user, true);

            $entityManager->persist($newUser);
            $entityManager->flush();

                //redirection in page
        //    return $this->redirectToRoute('app_user_register');
        // after register take me to login page 
        return $this->redirectToRoute('app_login');

       }

       return $this->render('user/register.html.twig', [
           'form' => $form-> createView(),
       ]);
    }

    #[Route('/my-profil', name: 'app_user_profil')]
    #[IsGranted('ROLE_USER')]
    public function profil(
        Request $request,
        UserRepository $repository,
        UserPasswordHasherInterface $hasher,
    ): Response {
        $form = $this->createForm(RegisterFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            if ($form->get('password')->getData()) {
                $user->setPassword($hasher->hashPassword(
                    $user,
                    $form->get('password')->getData(),
                ));
            }

            $repository->add($user);

            return $this->redirectToRoute('app_logout');
        }

        return $this->render('user/profil.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
