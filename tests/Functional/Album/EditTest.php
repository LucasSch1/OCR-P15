<?php

namespace App\Tests\Functional\Album;

use App\Entity\Album;
use App\Tests\Functional\FunctionalTestCase;

class EditTest extends FunctionalTestCase
{
    private ?Album $album = null;
    private ?int $albumId = null;


    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
        $this->createTestAlbum();
    }

    public function testAdminEditAlbum(): void
    {
        $this->login("ina@zaoui.com");
        $this->get('/admin/album/update/'. $this->albumId);
        $this->assertResponseIsSuccessful();
        $formData = [
            "album[name]" => "Test Album Edit",
        ];
        $this->submit('Modifier',$formData);
        self::assertResponseRedirects('/admin/album');
        $this->client->followRedirect();
        $albumEdit = $this->getEntityManager()->getRepository(Album::class)->findOneBy(["name" => "Test Album Edit"]);
        $this->assertNotNull($albumEdit);

    }

    public function testUserEditAlbum(): void
    {
        $this->get('/admin/album/update/'. $this->albumId);
        $this->assertResponseStatusCodeSame(403);

    }


    public function testGuestEditAlbum(): void
    {
        $this->get("/logout");
        $this->get('/admin/album/update/' . $this->albumId);
        $this->assertResponseRedirects('/login');
    }


    public function createTestAlbum(): void
    {
        $album = new Album();
        $album->setName('Test Album');
        $this->getEntityManager()->persist($album);
        $this->getEntityManager()->flush();
        $this->album = $album;
        $this->albumId = $album->getId();
    }
}
