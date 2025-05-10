<?php

namespace App\Controller;

use App\Entity\MenuDayPrice;
use App\Entity\Reservation;
use App\Form\ReservationsType;
use App\Form\SearchBydateType;
use App\Repository\DishRepository;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('/{_locale}/reservation', name: 'app_reservation')]
    public function index(DishRepository $dishRepository, ManagerRegistry $mr, Request $request, ReservationRepository $reservationRepository): Response
    {
        try {
            /** Show diferent Day's menu dishes */            
            $menuDayElements = $dishRepository->getMenuDayElements();           
            
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
                'menuDayElements' => $menuDayElements,
                'price'           => $price,
                'active'          => "reservation",
                'form'            => $form,
            ]);

        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }
            
            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER); 
        }        
    }

    #[Route('/reservation/search', name: 'app_reservation_search')]
    public function search(Request $request): Response
    {
        try {
            $form = $this->createForm(SearchBydateType::class);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()) {
                $fields = $form->getData();
                  
                $date = $fields['date']->format('Y-m-d');              

                return $this->redirectToRoute(
                    'app_reservation_by_date', 
                    [
                        'date' => $date,
                        'time' => $fields['time']
                    ]
                );
            }                       

            return $this->render('reservation/search/search.html.twig', [
                'controller_name' => 'ReservationController',
                'active'          => "administration",
                'form'            => $form
            ]);

        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER); 
        }
    }

    #[Route('/reservation/all', name: 'app_reservation_all')]
    public function allReservations(ReservationRepository $reservationRepository, DishRepository $dishRepository, ManagerRegistry $mr): Response
    {
        try {
            /** Show diferent Day's menu dishes */            
            $menuDayElements = $dishRepository->getMenuDayElements();          
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            $dates = $reservationRepository->findDateFromCurrentDateGroupByDate();
            $reservations = $reservationRepository->findAll();

            return $this->render('reservation/search/search_results.html.twig', [
                'dates'           => $dates,
                'reservations'    => $reservations,
                'menuDayElements' => $menuDayElements,
                'price'           => $price,
                'active'          => "administration",
            ]);
            
        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER); 
        }
    }

    #[Route('/reservation/by_date/{?time}', name: 'app_reservation_by_date', methods: ['GET'])]
    public function byDate(
        ReservationRepository $reservationRepository, 
        DishRepository $dishRepository, Request $request, 
        ManagerRegistry $mr, 
        string $time = null
    ): Response
    {
        try {
            /** Show diferent Day's menu dishes */            
            $menuDayElements = $dishRepository->getMenuDayElements();          
            
            /** We obtain the Menu's day price */
            $priceObject = $mr->getRepository(MenuDayPrice::class)->find(1);
            $price = $priceObject->getPrice() ?? $price = 0;

            $date = $request->get('date');
            $time = $request->get('time');                      

            return $this->render('reservation/search/search_results.html.twig', [
                'dates'           => $reservationRepository->findDate($date),
                'reservations'    => $reservationRepository->findByDateAndTime($date, $time),
                'menuDayElements' => $menuDayElements,
                'price'           => $price,
                'active'          => "administration",
            ]);

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
