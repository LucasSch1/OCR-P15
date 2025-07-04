<?php

namespace App\Tests\Functional\Media;

use App\Tests\Functional\FunctionalTestCase;

class ShowTest extends FunctionalTestCase
{
    public function testShowMediaShouldSuccess(): void
    {
        $this->login();
        $this->get('/admin/media');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('table', 'Image');
    }

    public function testGuestShowMedia(): void
    {
        $this->get('/logout');
        $this->get('/admin/media');
        self::assertResponseRedirects('/login');
    }
}
