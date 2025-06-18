<?php

namespace App\Tests\Functional\User;

use App\Tests\Functional\FunctionalTestCase;

class ShowTest extends FunctionalTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->login();
    }

    public function testAdminShowGuestsPage(): void
    {
        $this->login('ina@zaoui.com');
        $this->get('/admin/guests');
        self::assertResponseIsSuccessful();
        $this->assertSelectorTextContains('main h1', 'Invités');
    }

    public function testUserShowGuestsPage(): void
    {
        $this->get('/admin/guests');
        $this->assertResponseStatusCodeSame(403);
    }

    public function testGuestShowGuestsPage(): void
    {
        $this->get('/logout');
        $this->get('/admin/guests');
        self::assertResponseRedirects('/login');
    }
}
