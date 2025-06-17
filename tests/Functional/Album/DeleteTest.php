<?php

namespace App\Tests\Functional\Album;

use App\Entity\Album;
use App\Tests\Functional\FunctionalTestCase;

class DeleteTest extends FunctionalTestCase
{
    private ?int $albumId = null;
    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
        $this->createTestAlbum();
    }
    public function testAdminDeleteAlbum(): void
    {
        $this->login("ina@zaoui.com");
        $this->get('/admin/album/delete/' . $this->albumId);
        self::assertResponseRedirects('/admin/album');
        $this->client->followRedirect();
        $deletedMedia = $this->getEntityManager()->getRepository(Album::class)->find($this->albumId);
        self::assertNull($deletedMedia);
    }

    public function testAdminDeleteNotFoundAlbum(): void
    {
        $this->login("ina@zaoui.com");
        $this->get('/admin/album/delete/999999');
        $this->assertResponseStatusCodeSame(404);
    }

    public function testUserDeleteAlbum(): void
    {
        $this->get('/admin/album/delete/' . $this->albumId);
        $this->assertResponseStatusCodeSame(403);

    }

    public function testGuestDeleteAlbum(): void
    {
        $this->get('/logout');
        $this->get('/admin/album/delete/' . $this->albumId);
        $this->assertResponseRedirects('/login');

    }


    public function createTestAlbum(): void
    {
        $album = new Album();
        $album->setName('Test Album');
        $this->getEntityManager()->persist($album);
        $this->getEntityManager()->flush();
        $this->albumId = $album->getId();
    }
}
