<?php

namespace App\Controller;

use App\Entity\MenuDayPrice;
use App\Repository\DishRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/menu/categories')]
class MenuCategoriesController extends AbstractController
{  
    #[Route('/{category}', name: 'app_dishes_category')]
    public function index(DishRepository $dishRepository, ManagerRegistry $mr, Request $request): Response
    {        
        try {                        
            /** Show diferent Day's menu dishes */            
            $menuDayElements = $dishRepository->getMenuDayElements();
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            /** We obtain the current category and all categories*/
            $category = $request->get('category');                              
            
            /** We calculate how many dishes we have with the current category */            
            $dishes = $dishRepository->findAll();
            $dishesByCategory = [];

            foreach ($dishes as $dish) {                          
                if($dish->getDishMenu()->getMenuCategory() === $category && $dish->getAvailable() === True) $dishesByCategory[] = $dish;
            }            
            
            /** We calculate how many "div" elements are necessary to show all the categories in Menu view */
            $total_categories = count($dishesByCategory);
            $elements_by_group = 4;
            $total_groups = number_format(ceil($total_categories / $elements_by_group), 0);                         

        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('menu_categories/index.html.twig', [
            'controller_name'   => 'MenuCategoriesController',
            'sections'          => $dishesByCategory,
            'groups'            => $total_groups,
            'elements'          => $elements_by_group,
            'menuDayElements'   => $menuDayElements,
            'price'             => $price,
            'category'          => $category,
            'active'            => "menu",
        ]);
    }    
}
