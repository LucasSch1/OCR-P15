<?php

namespace App\Tests\Functional\Album;

use App\Entity\Album;
use App\Tests\Functional\FunctionalTestCase;

class AddTest extends FunctionalTestCase
{
    private ?Album $album = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function testAdminAddAlbum(): void
    {
        $this->login('ina@zaoui.com');
        $this->get('/admin/album/add');
        $this->assertResponseIsSuccessful();
        self::assertSelectorExists('form');

        $formData = [
            'album[name]' => 'Test Album',
        ];
        $this->submit('Ajouter', $formData);
        self::assertResponseRedirects('/admin/album');
        $this->client->followRedirect();
        self::assertSelectorTextContains('main h1', 'Albums');
        self::assertSelectorExists('table');
        self::assertSelectorTextContains('table', 'Test Album');

        $this->album = $this->getEntityManager()->getRepository(Album::class)->findOneBy([
            'name' => 'Test Album',
        ]);
        $this->assertEquals('Test Album', $this->album->getName());
    }

    public function testUserAddAlbum(): void
    {
        $this->get('/admin/album/add');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testGuestAddAlbum(): void
    {
        $this->get('/logout');
        $this->get('/admin/album/add');
        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        self::assertSelectorExists('form');
    }

    public function createTestAlbum(): void
    {
        $album = new Album();
        $album->setName('Test Album');
        $this->getEntityManager()->persist($album);
        $this->getEntityManager()->flush();

        $this->album = $album;
    }
}
