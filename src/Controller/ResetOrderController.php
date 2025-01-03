<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResetOrderController extends AbstractController
{
    #[Route('/reset/order', name: 'app_reset_order')]
    public function resetOrders(Request $request): Response    
    {       
        $request->getSession()->set('dishes', []);
        $request->getSession()->set('data', []);
        return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);
    }
}
