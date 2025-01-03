<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function edit(Request $request, Order $order, OrderRepository $orderRepository): Response
    {  
        try {
            if ($this->isCsrfTokenValid('edit'.$order->getId(), $request->request->get('_token'))) {
                $orderRepository->update($order, true);
                $this->addFlash('success', 'Order updated successfully.');                        
                
                return $this->redirectToRoute('app_order_show', ['id' => $order->getId()]);
            }
            else {
                throw new \Exception("Invalid token", 1);                
            }
        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
            return $this->redirectToRoute('app_order_show', ['id' => $order->getId()]);            
        }                
    }

    #[Route('/{id}/delete', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        try {
            if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
                $orderRepository->remove($order, true);
                $this->addFlash('success', 'Order deleted successfully.');

                return $this->redirectToRoute('app_order', [], Response::HTTP_SEE_OTHER);
            }
            else {
                throw new \Exception("Invalid token", 1);
            }
            
        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
            return $this->redirectToRoute('app_order_show', ['id' => $order->getId()]);
        }        
    }
}
