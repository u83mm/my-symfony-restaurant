<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\Order;
use App\Form\Custom\NewOrderType;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[IsGranted(new Expression(
    'is_granted("ROLE_ADMIN") or 
    is_granted("ROLE_WAITER")'))]
#[Route('/{_locale}/cart')]
class CartController extends AbstractController
{
    public function __construct(private TranslatorInterface $translator)
    {
        
    }
    #[Route('/', name: 'app_cart')]
    public function index(): Response
    {  
        
        try {

            return $this->render('cart/index.html.twig', [
                'controller_name' => 'CartController',
                
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

   
    #[Route('/new', name: 'app_cart_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        try {
            $dishes = $request->getSession()->get('dishes');              

            $form = $this->createForm(NewOrderType::class, null);
            $form->handleRequest($request);        

            if($form->isSubmitted() && $form->isValid()) { 
                $request->getSession()->set('data', $form->getData());
                                    
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

                if(isset($dishes)) $dishes = array_values($dishes);
                
                $request->getSession()->set('dishes', $dishes);
                $this->addFlash('success', ucfirst($this->translator->trans('updated order')));                        
            }

            return $this->render('cart/new.html.twig', [
                'controller_name' => 'CartController',
                'form'            => $form,
                'dishes'          => $dishes,
                'active'          => "order",
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

    public function addDishToCart(Dish $dish, array $data, Request $request)
    {
        try {
            $dishes = $request->getSession()->get('dishes') ?? [];                        

            foreach ($dishes as &$item) {
                if ($item['id'] === $dish->getId() && $item['category'] === $data['category']) {
                    /** Increase the quantity if the dish is already in the cart */
                    $item['qty'] += $data['qty'];
                    $request->getSession()->set('dishes', $dishes);                                             
                    return true;
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

        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }                                                     
    }

    #[Route('/save', name: 'app_save_cart', methods: ['GET', 'POST'])]
    public function saveOrder(Request $request, OrderRepository $orderRepository): Response
    {  
        try {
            // Get the dishes and data from the session
            $dishes = $request->getSession()->get('dishes');        
            $data = $request->getSession()->get('data');

            // Test if data are selected
            if(!$data) {
                $this->addFlash('danger', ucfirst($this->translator->trans('select table and people')));
                return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);
            }
            
            // Adds new_dishes to an existing order, updates table number or people quantity
            if($oldOrder = $request->getSession()->get('order')) {
                $order = $orderRepository->findOneBy(['id' => $oldOrder->getId()]);
                $order->setTableNumber(0);
                $orderRepository->update($order, true);

                // Updates table number or people quantity or both
                $order->setTableNumber($data['tableNumber']);
                $order->setPeopleQty($data['peopleQty']);

                // Test if the table is bussy
                if($orderRepository->testIfTheTableIsBussy($data['tableNumber'])) {
                    $this->addFlash('danger', ucfirst($this->translator->trans('bussy table')));
                    return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);
                }

                // Adds new_dishes to an existing order
                if($dishes) $orderRepository->addDishesToAnExistingOrder($dishes, $order);         

                $orderRepository->update($order, true);
                $this->addFlash('success', ucfirst($this->translator->trans('updated order')));
                $request->getSession()->remove('order');
                $request->getSession()->remove('dishes');
                $request->getSession()->remove('data');

                return $this->redirectToRoute('app_order_show', ['id' => $order->getId()], Response::HTTP_SEE_OTHER);
            }
            else {
                $order = new Order();
            }

            // Test if the table is bussy
            if($orderRepository->testIfTheTableIsBussy($data['tableNumber'])) {
                $this->addFlash('danger', ucfirst($this->translator->trans('bussy table')));
                return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);
            }
            
            // Test if the order is empty
            if(!$dishes) {
                $this->addFlash('danger', ucfirst($this->translator->trans('empty order')));
                return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);
            }
            
            // Set the order
            $order->setTableNumber($data['tableNumber']);
            $order->setPeopleQty($data['peopleQty']);

            foreach($dishes as $dish) {
                match($dish['category']) {
                    'aperitifs' => $order->setAperitifs($dish),
                    'firsts'    => $order->setFirsts($dish),
                    'seconds'   => $order->setSeconds($dish),
                    'drinks'    => $order->setDrinks($dish),
                    'desserts'  => $order->setDesserts($dish),
                    'coffees'   => $order->setCoffees($dish),
                };
            }

            // Save the order
            $orderRepository->save($order, true);
            $request->getSession()->remove('dishes');
            $request->getSession()->remove('data');
            $this->addFlash('success', ucfirst($this->translator->trans('saved order')));
            
            return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);

        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }        
    }    
}
