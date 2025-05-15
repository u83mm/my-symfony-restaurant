<?php

namespace App\Controller;

use App\Entity\DishMenu;
use App\Form\DishMenuType;
use App\Repository\DishMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Require ROLE_ADMIN for this actions
 */ 
#[IsGranted('ROLE_ADMIN')]
#[Route('/dishmenu')]
class DishMenuController extends AbstractController
{
    #[Route('/', name: 'app_dish_menu_index', methods: ['GET'])]
    public function index(DishMenuRepository $dishMenuRepository): Response
    {
        try {
            return $this->render('dish_menu/index.html.twig', [
                'dish_menus' => $dishMenuRepository->findAll(),
                'active'     => "administration",
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

    #[Route('/new', name: 'app_dish_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DishMenuRepository $dishMenuRepository): Response
    {
        try {
            $dishMenu = new_dishMenu();
            $form = $this->createForm(DishMenuType::class, $dishMenu);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // Check if the emoji field is empty
                if($dishMenu->getMenuEmoji() == null) {
                    $this->addFlash('danger', 'The emoji field is required.');

                    return $this->render('dish_menu/new.html.twig', [
                        'dish_menu' => $dishMenu,
                        'form'      => $form,
                        'active'    => "administration",
                    ]);
                }

                // Check if the category exists
                if($dishMenuRepository->findOneBy(['menuCategory' => $dishMenu->getMenuCategory()]) != null) {
                    $this->addFlash('danger', 'The category already exist.');

                    return $this->render('dish_menu/new.html.twig', [
                        'dish_menu' => $dishMenu,
                        'form'      => $form,
                        'active'    => "administration",
                    ]);
                }

                // Save the new category
                $this->addFlash('success', 'The category has been created successfully.');
                $dishMenuRepository->save($dishMenu, true);

                return $this->redirectToRoute('app_dish_menu_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('dish_menu/new.html.twig', [
                'dish_menu' => $dishMenu,
                'form'      => $form,
                'active'    => "administration",
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

    #[Route('/{id}', name: 'app_dish_menu_show', methods: ['GET'])]
    public function show(DishMenu $dishMenu): Response
    {
        try {

            return $this->render('dish_menu/show.html.twig', [
                'dish_menu' => $dishMenu,
                'active'    => "administration",       
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

    #[Route('/{id}/edit', name: 'app_dish_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DishMenu $dishMenu, DishMenuRepository $dishMenuRepository): Response
    {
        try {
            $form = $this->createForm(DishMenuType::class, $dishMenu);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $dishMenuRepository->save($dishMenu, true);

                return $this->redirectToRoute('app_dish_menu_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('dish_menu/edit.html.twig', [
                'dish_menu' => $dishMenu,
                'form'      => $form,
                'active'    => "administration",
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

    #[Route('/{id}', name: 'app_dish_menu_delete', methods: ['POST'])]
    public function delete(Request $request, DishMenu $dishMenu, DishMenuRepository $dishMenuRepository): Response
    {
        try {
            if ($this->isCsrfTokenValid('delete'.$dishMenu->getId(), $request->request->get('_token'))) {
                $dishMenuRepository->remove($dishMenu, true);
            }
    
            return $this->redirectToRoute('app_dish_menu_index', [], Response::HTTP_SEE_OTHER);

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
