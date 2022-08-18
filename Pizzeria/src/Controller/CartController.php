<?php

namespace App\Controller;

use App\Entity\Pizza;
use App\Entity\Article;
use App\Repository\CartRepository;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_USER')]
class CartController extends AbstractController
{
    #[Route('/my-cart', name: 'app_cart_display')]
    public function display(): Response
    {
        return $this->render('cart/display.html.twig');
    }

    #[Route('/my-cart/{id}/add', name: 'app_cart_addArticle')]
    public function addArticle(Pizza $pizza, CartRepository $repository): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $cart = $user->getCart();

        $article = new Article();
        $article->setQuantity(1);
        $article->setCart($cart);
        $article->setPizza($pizza);

        $cart->addArticle($article);

        $repository->add($cart, true);

        return $this->redirectToRoute('app_cart_display');
    }

    #[Route('/my-cart/{id}/plus', name: 'app_cart_increase')]
    public function increase(Article $article, ArticleRepository $repository): Response
    {
        $article->setQuantity($article->getQuantity() + 1);

        $repository->add($article, true);

        return $this->redirectToRoute('app_cart_display');
    }

    #[Route('/my-cart/{id}/minus', name: 'app_cart_decrease')]
    public function decrease(Article $article, ArticleRepository $repository, cartRepository $cartRepository): Response
    {
        $article->setQuantity($article->getQuantity() - 1);

        if ($article->getQuantity() <= 0) {
            /** @var User $user */
            $user = $this->getUser();
            $cart = $user->getBasket();

            $cart->removeArticle($article);

            $cartRepository->add($cart, true);

            return $this->redirectToRoute('app_cart_display');
        }

        $repository->add($article, true);

        return $this->redirectToRoute('app_cart_display');
    }
}
