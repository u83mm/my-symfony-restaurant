<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\MenuDayPrice;
use App\Form\DishType;
use App\Repository\DishMenuRepository;
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
    #[Route('/', name: 'app_dish_index', methods: ['GET'])]
    public function index(DishRepository $dishRepository, Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $dishRepository->getDishPaginator($offset);

        return $this->render('dish/index.html.twig', [
            //'dishes' => $dishRepository->findAll(),
            'dishes'    => $paginator,
            'previous'  => $offset - DishRepository::PAGINATOR_PER_PAGE,
            'next'      => min(count($paginator), $offset + DishRepository::PAGINATOR_PER_PAGE),
            'desde'     => $offset + 1,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/new', name: 'app_dish_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DishRepository $dishRepository, SluggerInterface $slugger): Response
    {
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
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dish_show', methods: ['GET'])]
    public function show(Dish $dish, DishRepository $dishRepository, ManagerRegistry $mr): Response
    {     
        /** Show diferent Day's menu dishes */
        $primeros = $dishRepository->findDishesByDishday("primero");
        $segundos = $dishRepository->findDishesByDishday("segundo");
        $postres  = $dishRepository->findDishesByDishday("postre"); 
        
        /** We obtain the Menu's day price */
        $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
        $price = $priceObject->getPrice() ?? $price = 0;     

        return $this->render('dish/show.html.twig', [
            'dish'      => $dish,
            'primeros'  => $primeros,
            'segundos'  => $segundos,
            'postres'   => $postres,
            'price'     => $price,            
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}/edit', name: 'app_dish_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dish $dish, DishRepository $dishRepository, SluggerInterface $slugger): Response
    {
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
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{id}', name: 'app_dish_delete', methods: ['POST'])]
    public function delete(Request $request, Dish $dish, DishRepository $dishRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dish->getId(), $request->request->get('_token'))) {            
            $dishRepository->remove($dish, true);
        }

        return $this->redirectToRoute('app_dish_index', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/search/dishes/names', name: 'app_dish_search', methods: ['POST'])]
    public function searchDishesName(Request $request, DishRepository $dishRepository): Response
    {
        $critery = $request->request->get('critery');
        $field = $request->request->get('field');
        
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $dishRepository->selectDishesByCritery($offset, $field, $critery);                       
        
        return $this->render('dish/index.html.twig', [
            'dishes' => $paginator,
            'previous'  => $offset - DishRepository::PAGINATOR_PER_PAGE,
            'next'      => min(count($paginator), $offset + DishRepository::PAGINATOR_PER_PAGE),
            'desde'     => $offset + 1,
        ]);
    } 
    
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/search/dishes/category', name: 'app_dish_search_menu_category', methods: ['POST'])]
    public function searchDishesCategory(Request $request, DishRepository $dishRepository): Response
    {
        $critery = $request->request->get('critery');
        $field = $request->request->get('field');            
                  
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $dishRepository->getDishPaginator($offset, $field, $critery);               
        
        return $this->render('dish/index.html.twig', [
            'dishes' => $paginator,
            'previous'  => $offset - DishRepository::PAGINATOR_PER_PAGE,
            'next'      => min(count($paginator), $offset + DishRepository::PAGINATOR_PER_PAGE),
            'desde'     => $offset + 1,
        ]);
    } 
}
