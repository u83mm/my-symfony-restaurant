<?php

namespace App\Controller;

use App\Form\Custom\NewOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
    #[Route('/', name: 'app_cart')]
    public function index(): Response
    {

        
        
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            
        ]);
    }

    #[Route('/new', name: 'app_cart_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $dishes = $request->getSession()->get('dishes');

        $form = $this->createForm(NewOrderType::class, null);
        $form->handleRequest($request);

        return $this->render('cart/new.html.twig', [
            'controller_name' => 'CartController',
            'form'            => $form,
            'dishes'          => $dishes
        ]);
    }
}
