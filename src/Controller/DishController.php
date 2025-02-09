<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\MenuDayPrice;
use App\Form\Custom\AddToOrderType;
use App\Form\DishType;
use App\Repository\DishRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/dish')]
class DishController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/', name: 'app_dish_index', methods: ['GET', 'POST'])]
    public function index(DishRepository $dishRepository, Request $request): Response
    {
        try {
            /** We get "critery" and "field" if necessary */
            $critery = $request->request->get('critery') ?? $request->query->get('critery') ?? null;
            $field = $request->request->get('field') ?? $request->query->get('field') ?? null;        
            
            /** We obtain the paginator */
            $offset = max(0, $request->query->getInt('offset', 0));
            $paginator = $dishRepository->getDishPaginator($offset, $field, $critery);

            /** We calculate total pages and how many pages show in each pagination */
            $pages = ceil(count($paginator) / DishRepository::PAGINATOR_PER_PAGE);
            $paginator_per_page = DishRepository::PAGINATOR_PER_PAGE;
            
            $last_page_offset = ($pages - 1) * DishRepository::PAGINATOR_PER_PAGE;

            return $this->render('dish/index.html.twig', [            
                'dishes'                => $paginator,
                'previous'              => $offset - DishRepository::PAGINATOR_PER_PAGE,
                'next'                  => min(count($paginator), $offset + DishRepository::PAGINATOR_PER_PAGE),
                'desde'                 => $offset + 1,
                'route'                 => "app_dish_index",
                'critery'               => $critery,
                'field'                 => $field,
                'pages'                 => $pages,
                'offset'                => $offset,
                'paginator_per_pages'   => $paginator_per_page,
                'last_page_offset'      => $last_page_offset, 
                'active'                => "administration",           
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_dish_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DishRepository $dishRepository, SluggerInterface $slugger): Response
    {
        try {
            $dish = new Dish();
            $form = $this->createForm(DishType::class, $dish);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $img = $form->get('select_picture')->getData();                      
            
                if ($img) {
                    $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();

                    // Move the file to the directory where products are stored
                    try {
                        $img->move(
                            $this->getParameter('dishes_pictures_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        echo "The image can't be uploaded.";
                    }

                    // updates the 'image' property to store the IMG file name
                    // instead of its contents
                    $dish->setPicture($newFilename);
                }                
                        
                $dishRepository->save($dish, true);

                return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('dish/new.html.twig', [
                'dish'      => $dish,
                'form'      => $form,
                'active'    => "administration",
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

    #[Route('/{id}', name: 'app_dish_show', methods: ['GET', 'POST'])]
    public function show(Dish $dish, DishRepository $dishRepository, ManagerRegistry $mr, Request $request, CartController $cart): Response
    { 
        try {
            /** Show diferent Day's menu dishes */            
            $menuDayElements = $dishRepository->getMenuDayElements();
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? 0;
            
            /** We obtain the dish category */
            $category = $dish->getDishMenu()->getMenuCategory();

            $form = $this->createForm(AddToOrderType::class, null);
            $form->handleRequest($request);

            /** Add dish to cart */
            if ($form->isSubmitted() && $form->isValid()) {                                 
                $data = $form->getData();                      
                $cart->addDishToCart($dish, $data, $request);
                return $this->redirectToRoute('app_cart_new', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('dish/show.html.twig', [
                'dish'            => $dish,
                'menuDayElements' => $menuDayElements,
                'price'           => $price, 
                'category'        => $category,
                'form'            => $form,
                'active'          => "menu",          
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_dish_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dish $dish, DishRepository $dishRepository, SluggerInterface $slugger): Response
    {
        try {
            $form = $this->createForm(DishType::class, $dish);
            $form->handleRequest($request);                  
                        
            if ($form->isSubmitted() && $form->isValid()) {
                $img = $form->get('select_picture')->getData();
                                                                                        
                if($img) {
                    $filesystem = new Filesystem(); 
                    $dish->getPicture() != null ? $imgToRemove = $dish->getPicture() : $imgToRemove = "";

                    if($imgToRemove) {
                        try {
                            $filesystem->remove($this->getParameter('dishes_pictures_directory') . "/". $imgToRemove);
                        } catch (IOExceptionInterface $exception) {
                            echo "An error occurred while delecting image at " . $exception->getPath();
                        }
                    }                                                

                    $originalFilename = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$img->guessExtension();

                    // Move the file to the directory where dishes are stored
                    try {
                        $img->move(
                            $this->getParameter('dishes_pictures_directory'),
                            $newFilename
                        );                                  

                    } catch (FileException $e) {
                        echo "The image can't be uploaded.";
                    }        

                    // updates the 'image' property to store the IMG file name
                    // instead of its contents
                    $dish->setPicture($newFilename);               
                }                           
                
                $dishRepository->save($dish, true);

                return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('dish/edit.html.twig', [
                'dish'      => $dish,
                'form'      => $form,
                'active'    => "administration",
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

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_dish_delete', methods: ['POST'])]
    public function delete(Request $request, Dish $dish, DishRepository $dishRepository): Response
    {
        try {
            
            if ($this->isCsrfTokenValid('delete'.$dish->getId(), $request->request->get('_token'))) {            
                $dishRepository->remove($dish, true);
            }

            return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);

        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }        
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/search/dishes/names', name: 'app_dish_search', methods: ['GET', 'POST'])]
    public function searchDishesName(Request $request, DishRepository $dishRepository): Response
    {  
        try {
            /** We get "critery" and "field" if necessary */         
            $critery = $request->request->get('critery') ?? $request->query->get('critery') ?? null;
            $field = $request->request->get('field') ?? $request->query->get('field') ?? null;         
            
            /** We obtain the paginator */
            $offset = max(0, $request->query->getInt('offset', 0));
            $paginator = $dishRepository->selectDishesByCritery($offset, $field, $critery);
            
            /** We calculate total pages and how many pages show in each pagination */
            $pages = ceil(count($paginator) / DishRepository::PAGINATOR_PER_PAGE);
            $paginator_per_page = DishRepository::PAGINATOR_PER_PAGE;
            
            $last_page_offset = ($pages - 1) * DishRepository::PAGINATOR_PER_PAGE;
            
            return $this->render('dish/index.html.twig', [
                'dishes'                => $paginator,
                'previous'              => $offset - DishRepository::PAGINATOR_PER_PAGE,
                'next'                  => min(count($paginator), $offset + DishRepository::PAGINATOR_PER_PAGE),
                'desde'                 => $offset + 1,
                'route'                 => "app_dish_search",
                'critery'               => $critery,
                'field'                 => $field,
                'pages'                 => $pages,
                'offset'                => $offset,
                'paginator_per_pages'   => $paginator_per_page,
                'last_page_offset'      => $last_page_offset,  
                'active'                => "administration",         
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
}
