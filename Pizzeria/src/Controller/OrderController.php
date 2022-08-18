<?php

namespace App\Controller;

use App\DTO\payment;
use App\Entity\User;
use App\Entity\Order;
use App\Form\PaymentType;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/command', name: 'app_order_display')]
    public function display(Request $request, OrderRepository $repository): Response
    {
    /** @var User $user */
    $user = $this->getUser();

    $payment = new payment();
    $payment->address = $user->getAddress();

    $form = $this->createForm(PaymentType::class, $payment);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Create  command
        $order = new Order();
        $order->setUser($user);
        $order->setAddress($payment->address);

        foreach ($user->getCart()->getArticles() as $article) {
            $order->addArticle($article);
        }

        $repository->add($order, true);

        return $this->redirectToRoute('app_order_validate', [
        'id' => $order->getId(),
        ]);
    }

    return $this->render('order/display.html.twig', [
    'form' => $form->createView(),
    ]);
}

    #[Route('/command/{id}/validation', name: 'app_order_validate')]
    public function validate(Order $order): Response
    {
        return $this->render('order/validate.html.twig', [
            'order' => $order,
        ]);
    }




}
