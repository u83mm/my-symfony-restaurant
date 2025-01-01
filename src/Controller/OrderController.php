<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/order')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order')]
    public function index(ManagerRegistry $mr): Response
    {
        $orders = $mr->getRepository(Order::class)->findAll();

        return $this->render('order/index.html.twig', [
            'controller_name'   => 'OrderController',
            'orders'            => $orders
        ]);
    }

    #[Route('/show/{id}', name: 'app_order_show')]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'controller_name'   => 'OrderController',
            'order'             => $order
        ]);
    }
}
