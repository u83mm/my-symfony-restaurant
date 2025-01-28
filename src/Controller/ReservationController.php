<?php

namespace App\Controller;

use App\Entity\MenuDayPrice;
use App\Entity\Reservation;
use App\Form\ReservationsType;
use App\Repository\DishRepository;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(DishRepository $dishRepository, ManagerRegistry $mr, Request $request, ReservationRepository $reservationRepository): Response
    {
        try {
            /** Show diferent Day's menu dishes */
            $primeros = $dishRepository->findDishesByDishday("primero");            
            $segundos = $dishRepository->findDishesByDishday("segundo");
            $postres  = $dishRepository->findDishesByDishday("postre");           
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;
            
            /** Show the reservation form */
            $reservation = new Reservation();
            $form = $this->createForm(ReservationsType::class, $reservation);
            $form->handleRequest($request);           

            /** Save the reservation */
            if ($form->isSubmitted() && $form->isValid()) {                
                $reservationRepository->save($reservation, true);
                $this->addFlash('success', 'Thank you for your reservation!');
                return $this->redirectToRoute('app_reservation', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('reservation/index.html.twig', [
                'controller_name' => 'ReservationController',
                'primeros'        => $primeros,
                'segundos'        => $segundos,
                'postres'         => $postres,
                'price'           => $price,
                'active'          => "reservation",
                'form'            => $form,
            ]);

        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER); 
        }        
    }
}
