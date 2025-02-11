<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\RolesRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        try {
            return $this->render('user/index.html.twig', [
                'users'     => $userRepository->findAll(),
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

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        try {
            $user = new User();
            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {                        
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );

                $userRepository->save($user, true);           

                $this->addFlash('success', 'User created successfully.');
            
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('user/new.html.twig', [
                'user'      => $user,
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

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        try {
            return $this->render('user/show.html.twig', [
                'user'      => $user,
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

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, RolesRepository $rolesRepository): Response
    {                       
        try {
            $roles = $rolesRepository->findAll();            

            if ($this->isCsrfTokenValid('edit'.$user->getId(), $request->request->get('_token'))) {
                $user->setUserName($request->request->get("user_name"));
                $user->setEmail($request->request->get("email"));               

                if(!($user->getRoles() === json_decode($request->request->get("role")))) 
                    $user->setRoles([$request->request->get("role")]);                 

                $userRepository->save($user, true);
    
                $this->addFlash('success', 'User updated successfully.');
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }             
            
        } catch (\Throwable $th) {
            $this->addFlash('danger', "{$th->getMessage()}");
        }

        return $this->render('user/edit.html.twig', [
            'user'      => $user,
            'roles'     => $roles,
            'active'    => "administration",          
        ]);        
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        try {
            if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
                $userRepository->remove($user, true);
            }
    
            $this->addFlash('success', 'User deleted successfully.');
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            
        } catch (\Throwable $th) {
            if ($this->isGranted('ROLE_ADMIN')) {
                $this->addFlash('danger', sprintf('Error in %s on line %d: %s', $th->getFile(), $th->getLine(), $th->getMessage()));
            } else {
                $this->addFlash('danger', $th->getMessage());
            }

            return $this->redirectToRoute('app_error', [], Response::HTTP_SEE_OTHER);
        }        
    }

    #[Route('/{id}/changepassword', name: 'app_user_change_password', methods: ['GET', 'POST'])]
    public function changePassword(Request $request, User $user, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher): Response
    {           
        try {
            if ($this->isCsrfTokenValid('changePassword'.$user->getId(), $request->request->get('_token'))) {
                $password = $request->request->get('password');
                $repeated_password = $request->request->get('new_password');

                if($password !== $repeated_password) throw new \Exception("Passwords aren't equals", 1);
                
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $request->request->get('new_password')
                    )
                ); 
    
                $userRepository->save($user, true);
    
                $this->addFlash('success', 'Updated password successfully.');
                return $this->redirectToRoute('app_user_edit', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
            }

        } catch (\Throwable $th) {
            $this->addFlash('danger', $th->getMessage());
            return $this->redirectToRoute('app_user_change_password', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/change_password.html.twig', [
            'user'      => $user,
            'active'    => "administration",                    
        ]);
    }
}
