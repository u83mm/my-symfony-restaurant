<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN") or is_granted("ROLE_WAITER")'))]
#[Route('/{_locale}/order')]
class OrderController extends AbstractController
{
    public function __construct(private TranslatorInterface $translator)
    {
        
    }
    #[Route('/', name: 'app_order')]
    public function index(ManagerRegistry $mr): Response
    {
        try {
            $orders = $mr->getRepository(Order::class)->findAll();

            return $this->render('order/index.html.twig', [
                'controller_name'   => 'OrderController',
                'orders'            => $orders,
                'active'            => "administration"  
            ]);

        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }        
    }

    #[Route('/{id}', name: 'app_order_show')]
    public function show(Order $order): Response
    {
        try {
            return $this->render('order/show.html.twig', [
                'controller_name'   => 'OrderController',
                'order'             => $order,
                'active'            => "administration"
            ]);
            
        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }        
    }

    #[Route('/{id}/edit', name: 'app_order_edit')]
    public function edit(Request $request, Order $order, OrderRepository $orderRepository): Response
    {  
        try {
            if ($this->isCsrfTokenValid('edit'.$order->getId(), $request->request->get('_token'))) {
                $orderRepository->update($order, true);
                $this->addFlash('success', ucfirst($this->translator->trans('updated order')));                        
                
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/delete', name: 'app_order_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        try {                       
            if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
                $orderRepository->remove($order, true);
                $this->addFlash('success', ucfirst($this->translator->trans('delected order')));

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

    #[Route('/{id}/add', name: 'app_order_add', methods: ['GET'])]
    public function addToOrder(Request $request, Order $order, OrderRepository $orderRepository): Response
    {
        try {
            $request->getSession()->set('order', $order);
            $request->getSession()->set('data', [
                'tableNumber' => $order->getTableNumber(),
                'peopleQty' => $order->getPeopleQty()
            ]);            
            
            return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);

        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
            return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);
        }
    }
}
