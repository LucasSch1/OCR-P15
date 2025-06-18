<?php

namespace App\Tests\Functional\Media;

use App\Entity\Media;
use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DeleteTest extends FunctionalTestCase
{
    private ?User $user = null;
    private ?Media $media = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
        $this->user = $this->getEntityManager()->getRepository(User::class)
            ->findOneBy(['email' => 'invite+1@exemple.com']);
        $this->createTestMedia();
    }

    public function testUserDeleteMediaSuccess(): void
    {
        $this->get('/admin/media/delete/'.$this->media->getId());
        self::assertResponseRedirects('/admin/media');
        $this->client->followRedirect();
        $deletedMedia = $this->getEntityManager()->getRepository(Media::class)->find($this->media->getId());
        self::assertNull($deletedMedia);
    }

    public function testGuestDeleteMedia(): void
    {
        $this->get('/logout');
        $this->get('/admin/media/delete/'.$this->media->getId());
        self::assertResponseRedirects('/login');
    }

    public function testUserDeleteNotFoundMedia(): void
    {
        $this->get('/admin/media/delete/99999');
        $this->assertResponseStatusCodeSame(404);
    }

    private function createTestMedia(): void
    {
        $this->get('/admin/media/add');
        $this->assertResponseIsSuccessful();

        $formData = [
            'media[user]' => $this->user->getId(),
            'media[title]' => 'Test Media to Delete',
            'media[file]' => new UploadedFile(
                __DIR__.'/fixtures/test_media.jpg',
                'test_media.jpg',
                'image/jpeg',
                null,
                true
            ),
        ];

        $this->submit('Ajouter', $formData);
        self::assertResponseRedirects('/admin/media');
        $this->client->followRedirect();

        $this->media = $this->getEntityManager()->getRepository(Media::class)->findOneBy([
            'title' => 'Test Media to Delete',
            'user' => $this->user,
        ]);
    }
}
