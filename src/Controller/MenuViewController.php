<?php

namespace App\Controller;

use App\Entity\DishMenu;
use App\Entity\MenuDayPrice;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuViewController extends AbstractController
{
    #[Route('/menu/view', name: 'app_menu_view')]
    public function index(ManagerRegistry $mr): Response
    {
        $dishMenuRepository = $mr->getRepository(DishMenu::class);
        $menuCategories = $dishMenuRepository->findAll();

        /** We calculate how many "div" elements are necessary to show all the categories in Menu view */
        $total_categories = count($menuCategories);
        $elements_by_group = 4;
        $total_groups = number_format(ceil($total_categories / $elements_by_group), 0);
           
        return $this->render('menu_view/index.html.twig', [
            'controller_name'   => 'MenuViewController',
            'sections'          => $menuCategories,
            'groups'            => $total_groups,
            'elements'          => $elements_by_group,
        ]);
    }
}
