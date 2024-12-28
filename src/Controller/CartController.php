<?php

namespace App\Controller;

use App\Entity\Dish;
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

        if($form->isSubmitted() && $form->isValid()) {
            //$data = $form->getData();                  

            //$firsts_id = $_POST['firsts_id'];
            //$firsts_category = $_POST['firsts_category'];
            $firsts_qty = $_POST['firsts_qty'];

            //foreach ($dishes as &$item) {
            //    if ($item['id'] === $data['id'] && $item['category'] === $data['category']) {
            //        /** Update the quantity if the dish is already in the cart */
            //        $item['qty'] = $data['qty'];
            //        $request->getSession()->set('dishes', $dishes);                                                                 
            //    }
            //}
            
            for($i = 0; $i < count($dishes), $i < count($firsts_qty); $i++) {
                /** Update the quantity if the dish is already in the cart */
                if($firsts_qty[$i] == 0) {
                    unset($dishes[$i]);
                    $request->getSession()->set('dishes', $dishes); 
                    continue;
                }

                $dishes[$i]['qty'] = $firsts_qty[$i];
                $request->getSession()->set('dishes', $dishes);   
            }            
        }

        return $this->render('cart/new.html.twig', [
            'controller_name' => 'CartController',
            'form'            => $form,
            'dishes'          => $dishes,            
        ]);
    }

    public function addDishToCart(Dish $dish, array $data, Request $request): void
    {
        $dishes = $request->getSession()->get('dishes') ?? [];                        

        foreach ($dishes as &$item) {
            if ($item['id'] === $dish->getId() && $item['category'] === $data['category']) {
                /** Increase the quantity if the dish is already in the cart */
                $item['qty'] += $data['qty'];
                $request->getSession()->set('dishes', $dishes);                                             
                return;
            }
        }

        $dishes[] = [
            'id'        => $dish->getId(),
            'name'      => $dish->getName(),
            'picture'   => $dish->getPicture(),
            'price'     => $dish->getPrice(),
            'qty'       => $data['qty'],
            'category'  => $data['category'],
        ];
        
        $request->getSession()->set('dishes', $dishes);                                             
    }
}
