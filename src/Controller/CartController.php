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
            $aperitifs_qty  = $_POST['aperitifs_qty'] ?? [];
            $firsts_qty     = $_POST['firsts_qty']    ?? [];
            $seconds_qty    = $_POST['seconds_qty']   ?? [];
            $drinks_qty     = $_POST['drinks_qty']    ?? [];
            $desserts_qty   = $_POST['desserts_qty']  ?? [];
            $coffees_qty    = $_POST['coffees_qty']   ?? [];                                    

            if(count($aperitifs_qty) > 0) {
                $count = 0;
                foreach($dishes as $key => &$dish) {
                    if($dish['category'] == 'aperitifs') {
                        if($aperitifs_qty[$count] == 0) {
                            unset($dishes[$key]);
                            $count++;
                            continue;
                        }

                        $dish['qty'] = $aperitifs_qty[$count];
                        $count++;
                    }
                }
            }
            
            if(count($firsts_qty) > 0) {
                $count = 0;
                foreach($dishes as $key => &$dish) {
                    if($dish['category'] == 'firsts') {
                        if($firsts_qty[$count] == 0) {
                            unset($dishes[$key]);
                            $count++;
                            continue;
                        }

                        $dish['qty'] = $firsts_qty[$count];
                        $count++;
                    }
                }
            }

            if(count($seconds_qty) > 0) {
                $count = 0;
                foreach($dishes as $key => &$dish) {
                    if($dish['category'] == 'seconds') {
                        if($seconds_qty[$count] == 0) {
                            unset($dishes[$key]);
                            $count++;
                            continue;
                        }

                        $dish['qty'] = $seconds_qty[$count]; 
                        $count++;                       
                    }
                }
            }

            if(count($drinks_qty) > 0) {
                $count = 0;
                foreach($dishes as $key => &$dish) {
                    if($dish['category'] == 'drinks') {
                        if($drinks_qty[$count] == 0) {
                            unset($dishes[$key]);
                            $count++;
                            continue;
                        }

                        $dish['qty'] = $drinks_qty[$count];
                        $count++;
                    }
                }
            }

            if(count($desserts_qty) > 0) {
                $count = 0;
                foreach($dishes as $key => &$dish) {
                    if($dish['category'] == 'desserts') {
                        if($desserts_qty[$count] == 0) {
                            unset($dishes[$key]);
                            $count++;
                            continue;
                        }

                        $dish['qty'] = $desserts_qty[$count];
                        $count++;
                    }
                }
            }

            if(count($coffees_qty) > 0) {
                $count = 0;
                foreach($dishes as $key => &$dish) {
                    if($dish['category'] == 'coffees') {
                        if($coffees_qty[$count] == 0) {
                            unset($dishes[$key]);
                            $count++;
                            continue;
                        }

                        $dish['qty'] = $coffees_qty[$count];
                        $count++;
                    }
                }
            }

            $dishes =array_values($dishes);
            $request->getSession()->set('dishes', $dishes);                        
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

        array_values($dishes);
        
        $request->getSession()->set('dishes', $dishes);                                             
    }
}
