<?php

namespace App\Controller;

use App\Entity\DishDay;
use App\Form\DishDayType;
use App\Repository\DishDayRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/{_locale}/dishday')]
class DishDayController extends AbstractController
{
    #[Route('/', name: 'app_dish_day_index', methods: ['GET'])]
    public function index(DishDayRepository $dishDayRepository): Response
    {
        try {

            return $this->render('dish_day/index.html.twig', [
                'dish_days' => $dishDayRepository->findAll(),
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

    #[Route('/new', name: 'app_dish_day_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DishDayRepository $dishDayRepository): Response
    {
        try {
            $dishDay = new dishDay();
            $form = $this->createForm(DishDayType::class, $dishDay);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $dishDayRepository->save($dishDay, true);

                return $this->redirectToRoute('app_dish_day_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('dish_day/new.html.twig', [
                'dish_day' => $dishDay,
                'form' => $form,
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

    #[Route('/{id}', name: 'app_dish_day_show', methods: ['GET'])]
    public function show(DishDay $dishDay): Response
    {
        try {
            return $this->render('dish_day/show.html.twig', [
                'dish_day' => $dishDay,
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

    #[Route('/{id}/edit', name: 'app_dish_day_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DishDay $dishDay, DishDayRepository $dishDayRepository): Response
    {
        try {
            $form = $this->createForm(DishDayType::class, $dishDay);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $dishDayRepository->save($dishDay, true);

                return $this->redirectToRoute('app_dish_day_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('dish_day/edit.html.twig', [
                'dish_day' => $dishDay,
                'form' => $form,
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

    #[Route('/{id}', name: 'app_dish_day_delete', methods: ['POST'])]
    public function delete(Request $request, DishDay $dishDay, DishDayRepository $dishDayRepository): Response
    {
        try {
            if ($this->isCsrfTokenValid('delete'.$dishDay->getId(), $request->request->get('_token'))) {
                $dishDayRepository->remove($dishDay, true);
            }
    
            return $this->redirectToRoute('app_dish_day_index', [], Response::HTTP_SEE_OTHER);
            
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
