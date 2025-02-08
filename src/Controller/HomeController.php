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
            $menuDayElements = $dishRepository->getMenuDayElements();          
            
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
                    
        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'menuDayElements'   => $menuDayElements,
            'price'             => $price,
            'active'            => "home",
        ]);
    }
}
