<?php

namespace App\Controller;

use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(DishRepository $dishRepository): Response
    {        
        /** Show diferent Day's menu dishes */
        $primeros = $dishRepository->findDishesByDishday("primero");
        $segundos = $dishRepository->findDishesByDishday("segundo");
        $postres  = $dishRepository->findDishesByDishday("postre");       

        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'primeros'          => $primeros,
            'segundos'          => $segundos,
            'postres'           => $postres,
        ]);
    }
}
