<?php

namespace App\Tests\Functional\Media;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddTest extends FunctionalTestCase
{

    /**
     *
     * @return void
     */
    public function testUserAddMediaSuccessful(): void
    {
        $this->login();
        $this->get('/admin/media/add');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('.form-label', 'Album');
        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['email'=>'invite+1@exemple.com']);
        $formData = [
            'media[user]' => $user->getId(),
            'media[title]' => 'Test Media',
            'media[file]' => new UploadedFile(
                __DIR__.'/fixtures/test_media.jpg',
                'test_media.jpg',
                'image/jpeg',
                null,
                true
            ),
        ];
        $this->submit('Ajouter',$formData);
        self::assertResponseRedirects('/admin/media');
        $this->client->followRedirect();
        $medias = $this->getEntityManager()->getRepository(Media::class)->findOneBy([
            'title'=>'Test Media',
            'user'=>$user
        ]);

        self::assertNotNull($medias);
    }

    public function testAdminAddMediaSuccessful(): void
    {
        $this->login("ina@zaoui.com");
        $album = new Album();
        $album->setName('Test Album');
        $this->getEntityManager()->persist($album);
        $this->getEntityManager()->flush();
        $this->get('/admin/media/add');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextNotContains('.form-label', 'Album');
        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['email'=>'ina@zaoui.com']);
        $formData = [
            'media[user]' => $user->getId(),
            'media[title]' => 'Test Media Admin',
            'media[album]' => $album->getId(),
            'media[file]' => new UploadedFile(
                __DIR__.'/fixtures/test_media.jpg',
                'test_media.jpg',
                'image/jpeg',
                null,
                true
            ),
        ];
        $this->submit('Ajouter',$formData);
        self::assertResponseRedirects('/admin/media');
        $this->client->followRedirect();

        $medias = $this->getEntityManager()->getRepository(Media::class)->findOneBy([
            'title'=>'Test Media Admin',
            'user'=>$user
        ]);

        self::assertNotNull($medias);
    }


    public function testGuestAddMedia(): void
    {
        $this->get("/logout");
        $this->get('/admin/media/add');
        self::assertResponseRedirects('/login');

    }

}
