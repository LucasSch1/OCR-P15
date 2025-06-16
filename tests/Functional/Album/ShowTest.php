<?php

namespace App\Tests\Functional\Album;

use App\Tests\Functional\FunctionalTestCase;

class ShowTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function testAdminShowAlbumPage(): void
    {
        $this->login("ina@zaoui.com");
        $this->get('/admin/album');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('table', 'Nom');
        $this->assertSelectorTextContains('table tbody tr td:nth-child(2) a.btn-warning', 'Modifier');

    }

    public function testUserShowAlbumPage(): void
    {
        $this->get('/admin/album');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testGuestShowAlbumPage(): void
    {
        $this->get('/logout');
        $this->get('/admin/album');
        $this->assertResponseRedirects('/login');
    }
}
