<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserSearchType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[IsGranted('ROLE_ADMIN')]
#[ROUTE('/admin/users')]
class AdminUserController extends AbstractController
{
    #[Route('/', name: 'app_admin_user_list')]
    public function list(Request $request, UserRepository $repository): Response
    {

        $form = $this->createForm(UserSearchType::class);
        $form->handleRequest($request);

        $users = $repository->findBySearch($form->getData());

        
        return $this->render('admin/user/list.html.twig', [
           "users" => $users,
           'form' => $form->createView(),
        ]);
    }


    #[ROUTE('/{id}/modify', name: 'app_admin_user_update')]
    public function update(Request $request, UserRepository $repository, User $user): Response
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $repository->add($form->getData(), true);

            return $this->redirectToRoute('app_admin_user_list');

        }

        return $this->render('admin/user/update.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);


    }


    #[ROUTE('/{id}/delete', name: 'app_admin_user_delete')]
    public function delete( UserRepository $repository, User $user): Response
    {
        $repository->remove($user, true);
        return $this->redirectToRoute('app_admin_user_list');



    }
}
