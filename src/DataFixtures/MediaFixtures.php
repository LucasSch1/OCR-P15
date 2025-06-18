<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use App\Repository\AlbumRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var UserRepository<User>
     */
    private UserRepository $userRepository;

    private AlbumRepository $albumRepository;

    /**
     * @param UserRepository<User> $userRepository
     */
    public function __construct(UserRepository $userRepository, AlbumRepository $albumRepository)
    {
        $this->userRepository = $userRepository;
        $this->albumRepository = $albumRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $user = $this->userRepository->findAll();
        $album = $this->albumRepository->findAll();

        for ($j = 0; $j < 5000; ++$j) {
            $randomUser = $user[array_rand($user)];
            $media = new Media();
            $media->setUser($randomUser);
            $filename = str_pad((string) $j, 4, '0', STR_PAD_LEFT).'.webp';
            $media->setPath('uploads/'.$filename);
            $media->setTitle('Title'.$j + 1);
            $manager->persist($media);
        }

        // Boucle avec les album_id
        for ($i = 5000; $i < 5051; ++$i) {
            $randomUser = $user[array_rand($user)];
            $randomAlbum = $album[array_rand($album)];
            $media = new Media();
            $media->setUser($randomUser);
            $media->setPath('uploads/'.$i.'.webp');
            $media->setTitle("Title $i");
            $media->setAlbum($randomAlbum);
            $manager->persist($media);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AlbumFixtures::class,
        ];
    }
}
