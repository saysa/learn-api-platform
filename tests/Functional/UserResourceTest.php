<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class UserResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateUser()
    {
        $client = self::createClient();

        $client->request('POST', '/api/users', [
            'json' => [
                'email' => 'saysa@example.com',
                'username' => 'saysa',
                'password' => 'saysa',
            ],
        ]);
        $this->assertResponseStatusCodeSame(201);

        $this->logIn($client, 'saysa@example.com', 'saysa');
    }
}
