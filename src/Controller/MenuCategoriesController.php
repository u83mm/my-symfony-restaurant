<?php

namespace App\Controller;

use App\Entity\DishMenu;
use App\Entity\MenuDayPrice;
use App\Repository\DishRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu/categories')]
class MenuCategoriesController extends AbstractController
{  
    #[Route('/{category}', name: 'aperitivos')]
    public function index(DishRepository $dishRepository, ManagerRegistry $mr, Request $request, $category = ""): Response
    {        
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');
            

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'entrantes')]
    public function starts(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'ensaladas')]
    public function salads(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'carnes')]
    public function meats(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    } 
    
    #[Route('/{category}', name: 'pescados')]
    public function fishes(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'arroces')]
    public function rices(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'postres')]
    public function desserts(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'cafés')]
    public function coffes(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'tintos')]
    public function reds(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'blancos')]
    public function whites(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'rosados')]
    public function pinkWines(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'cavas')]
    public function sparklingWines(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'champagne')]
    public function champagne(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'bebidas')]
    public function drinks(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }

    #[Route('/{category}', name: 'licores')]
    public function liquors(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category */
            $category = $request->get('category');

        } catch (\Throwable $th) {
            echo "We have a problem with the price";
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name' => 'MenuCategoriesController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
            'category'          => $category,
        ]);
    }
}
