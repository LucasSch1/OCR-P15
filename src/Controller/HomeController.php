<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\User;
use App\Repository\AlbumRepository;
use App\Repository\MediaRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var UserRepository<User>
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository<User> $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->render('front/home.html.twig');
    }

    #[Route('/guests', name: 'guests')]
    public function guests(): Response
    {
        $guests = $this->userRepository->findAllWithoutAdmin();

        return $this->render('front/guests.html.twig', [
            'guests' => $guests,
        ]);
    }

    #[Route('/guest/{id}', name: 'guest')]
    public function guest(#[MapEntity(id: 'id')] User $guest): Response
    {
        return $this->render('front/guest.html.twig', [
            'guest' => $guest,
        ]);
    }

    /**
     * @param UserRepository<User> $userRepository
     */
    #[Route('/portfolio/{id?}', name: 'portfolio')]
    public function portfolio(UserRepository $userRepository, AlbumRepository $albumRepository, MediaRepository $mediaRepository, #[MapEntity(id: 'id')] ?Album $album): Response
    {
        $albums = $albumRepository->findAll();
        $user = $userRepository->findOneByAdmin(true);

        $medias = $album
            ? $mediaRepository->findByAlbum($album)
            : $mediaRepository->findByUser($user);

        return $this->render('front/portfolio.html.twig', [
            'albums' => $albums,
            'album' => $album,
            'medias' => $medias,
        ]);
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('front/about.html.twig');
    }
}
