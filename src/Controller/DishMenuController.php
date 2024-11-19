<?php

namespace App\Controller;

use App\Entity\DishMenu;
use App\Form\DishMenuType;
use App\Repository\DishMenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dishmenu')]
class DishMenuController extends AbstractController
{
    #[Route('/', name: 'app_dish_menu_index', methods: ['GET'])]
    public function index(DishMenuRepository $dishMenuRepository): Response
    {
        return $this->render('dish_menu/index.html.twig', [
            'dish_menus' => $dishMenuRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dish_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DishMenuRepository $dishMenuRepository): Response
    {
        $dishMenu = new DishMenu();
        $form = $this->createForm(DishMenuType::class, $dishMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dishMenuRepository->save($dishMenu, true);

            return $this->redirectToRoute('app_dish_menu_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dish_menu/new.html.twig', [
            'dish_menu' => $dishMenu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dish_menu_show', methods: ['GET'])]
    public function show(DishMenu $dishMenu): Response
    {
        return $this->render('dish_menu/show.html.twig', [
            'dish_menu' => $dishMenu,            
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dish_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DishMenu $dishMenu, DishMenuRepository $dishMenuRepository): Response
    {
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
    }

    #[Route('/{id}', name: 'app_dish_menu_delete', methods: ['POST'])]
    public function delete(Request $request, DishMenu $dishMenu, DishMenuRepository $dishMenuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dishMenu->getId(), $request->request->get('_token'))) {
            $dishMenuRepository->remove($dishMenu, true);
        }

        return $this->redirectToRoute('app_dish_menu_index', [], Response::HTTP_SEE_OTHER);
    }
}
