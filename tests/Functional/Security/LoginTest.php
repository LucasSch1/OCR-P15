<?php

namespace App\Tests\Functional\Security;

use App\Tests\Functional\FunctionalTestCase;

class LoginTest extends FunctionalTestCase
{
    public function testThatLoginShouldSucceeded(): void
    {
        $this->get('/login');

        $this->client->submitForm('Connexion', [
            '_username' => 'invite+1@exemple.com',
            '_password' => 'password',
        ]);
        $this->assertResponseStatusCodeSame(302);
        $this->client->followRedirect();

        $this->assertStringNotContainsString('Connexion', $this->client->getResponse()->getContent());

        //        $this->get('/logout');
        //        self::assertFalse($authorizationChecker->isGranted('IS_AUTHENTICATED'));
    }

    public function testThatLoginShouldFailed(): void
    {
        $this->get('/login');

        $this->client->submitForm('Connexion', [
            '_username' => 'invite+1@exemple.com',
            '_password' => 'fail',
        ]);

        $this->client->followRedirect();

        $this->assertSelectorTextContains('.alert-danger', 'Invalid credentials.');
    }
}
