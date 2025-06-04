<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use App\Repository\AlbumRepository;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(UserRepository $userRepository ,EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;

    }


    #[Route('/', name: 'home')]
    public function home() : Response
    {
        return $this->render('front/home.html.twig');
    }

    #[Route('/guests', name: 'guests')]
    public function guests() : Response
    {
        $guests = $this->userRepository->findBy(['admin' => false]);
        return $this->render('front/guests.html.twig', [
            'guests' => $guests
        ]);
    }

    #[Route('/guest/{id}', name: 'guest')]
    public function guest(int $id) : Response
    {
        $guest = $this->userRepository->find($id);
        return $this->render('front/guest.html.twig', [
            'guest' => $guest
        ]);
    }


    #[Route('/portfolio/{id}', name: 'portfolio')]
    public function portfolio(?int $id = null,UserRepository $userRepository, AlbumRepository $albumRepository,MediaRepository $mediaRepository) : Response
    {
        $albums = $albumRepository->findAll();
        $album = $id ? $albumRepository->find($id) : null;
        $user = $userRepository->findOneByAdmin(true);

        $medias = $album
            ? $mediaRepository->findByAlbum($album)
            : $mediaRepository->findByUser($user);
        return $this->render('front/portfolio.html.twig', [
            'albums' => $albums,
            'album' => $album,
            'medias' => $medias
        ]);
    }


    #[Route('/about', name: 'about')]
    public function about() : Response
    {
        return $this->render('front/about.html.twig');
    }
}