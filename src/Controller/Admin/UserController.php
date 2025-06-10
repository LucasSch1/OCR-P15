<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;

    }

    #[Route('/admin/guests', name: 'admin_guests_index')]
    public function index(): Response
    {
        $users = $this->userRepository->findBy(['admin' => false], ['id' => 'ASC']);

        return $this->render('admin/user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }


    #[Route('/admin/guests/suspend/{id}', name: 'admin_guest_remove_access')]
    public function removeAccess(#[MapEntity(id:'id')] User $user): Response
    {
        $user->setIsActive(false);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_guests_index');
    }

    #[Route('/admin/guests/unlock/{id}', name: 'admin_guest_add_access')]
    public function addAccess(#[MapEntity(id:'id')] User $user): Response
    {
        $user->setIsActive(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_guests_index');
    }

    #[Route('/admin/guests/add', name: 'admin_guest_add')]
    public function addGuest(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setIsActive(true);
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            return $this->redirectToRoute('admin_guests_index');
        }
        return $this->render('admin/user/add.html.twig',['form'=>$form->createView()]);
    }

    #[Route('/admin/guests/delete/{id}', name: 'admin_guest_delete')]
    public function deleteGuest(Request $request, #[MapEntity(id:'id')] User $user): Response
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return $this->redirectToRoute('admin_guests_index');
    }


//
//    #[Route('/admin/guest/{id}', name: 'admin_guest_show', methods: ['GET'])]



}
