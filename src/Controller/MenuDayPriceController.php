<?php

namespace App\Controller;

use App\Entity\MenuDayPrice;
use App\Repository\MenuDayPriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuDayPriceController extends AbstractController
{
    #[Route('/menuday/price', name: 'app_menu_day_price')]
    public function index(Request $request, MenuDayPriceRepository $menuDayPriceRepository): Response
    {
        try {
            $price = $request->request->get('price');

            $menu_day_price = new MenuDayPrice();
            $menu_day_price->setPrice($price);

            $menuDayPriceRepository->truncateTable("menu_day_price");
            $menuDayPriceRepository->save($menu_day_price, true);
            

            return $this->redirectToRoute("app_dish_index", ['message' => "Menu's price stablish"]);
            
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
