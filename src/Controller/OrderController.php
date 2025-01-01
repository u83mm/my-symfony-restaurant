<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
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

    #[Route('/{id}', name: 'app_order_show')]
    public function show(Order $order): Response
    {
        return $this->render('order/show.html.twig', [
            'controller_name'   => 'OrderController',
            'order'             => $order
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_edit')]
    public function edit(Order $order, OrderRepository $orderRepository): Response
    {  
        $order = $orderRepository->update($order);
        
        $orderRepository->save($order, true);
        
        return $this->redirectToRoute('app_order_show', ['id' => $order->getId()]);

        /* return $this->render('order/edit.html.twig', [
            'controller_name'   => 'OrderController',
            'order'             => $order
        ]); */
    }
}
