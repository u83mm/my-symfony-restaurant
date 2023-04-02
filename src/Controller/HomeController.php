<?php

namespace App\Controller;

use App\Entity\MenuDayPrice;
use App\Repository\DishRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DishRepository $dishRepository, ManagerRegistry $mr): Response
    {                 
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

        } catch (\Throwable $th) {
            echo $th->getMessage();            
        }
                    
        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
            'price'             => $price,
        ]);
    }
}
