<?php

namespace App\Controller;

use App\Entity\DishMenu;
use App\Entity\MenuDayPrice;
use App\Repository\DishRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuViewController extends AbstractController
{
    #[Route('/{_locale}/menu/view', name: 'app_menu_view')]
    public function index(ManagerRegistry $mr, DishRepository $dishRepository): Response
    {       
        try {
            $dishMenuRepository = $mr->getRepository(DishMenu::class);        
            $menuCategories = $dishMenuRepository->findAll();

            /** Show diferent Day's menu dishes */                
            $menuDayElements = $dishRepository->getMenuDayElements(); 

            /** We calculate how many "div" elements are necessary to show all the categories in Menu view */
            $total_categories = count($menuCategories);
            $elements_by_group = 4;
            $total_groups = number_format(ceil($total_categories / $elements_by_group), 0);

            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }
           
        return $this->render('menu_view/index.html.twig', [
            'controller_name'   => 'MenuViewController',
            'sections'          => $menuCategories,
            'groups'            => $total_groups,
            'elements'          => $elements_by_group,
            'menuDayElements'   => $menuDayElements,
            'price'             => $price,
            'active'            => "menu",
        ]);
    }
}
