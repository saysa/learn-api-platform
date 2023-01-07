<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
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

    public function testUpdateUser()
    {
        $client = self::createClient();
        $user = $this->createdUserAndLogIn($client, 'saysa@example.com', 'saysa');

        $client->request('PUT', '/api/users/'.$user->getId(), [
            'json' => [
                'username' => 'new_username',
                'roles' => ['ROLE_ADMIN'], // will be ignored
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'username' => 'new_username',
        ]);

        $em = $this->getEntityManager();
        /** @var User $user */
        $user = $em->getRepository(User::class)->find($user->getId());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());

    }

    public function testGetUser()
    {
        $client = self::createClient();
        $user = $this->createdUserAndLogIn($client, 'saysa@example.de', 'saysa');
        $user->setPhoneNumber('555-555-555');

        $em = $this->getEntityManager();
        $em->flush();

        $client->request('GET', '/api/users/'.$user->getId());

        $this->assertJsonContains([
            'username' => 'saysa',
        ]);

        $data = $client->getResponse()->toArray();
        $this->assertArrayNotHasKey('phoneNumber', $data);

        // refresh the user & elevate
        $user = $em->getRepository(User::class)->find($user->getId());
        $user->setRoles(['ROLE_ADMIN']);
        $em->flush();

        $this->logIn($client, 'saysa@example.de', 'saysa');

        $client->request('GET', '/api/users/'.$user->getId());

        $this->assertJsonContains([
            'phoneNumber' => '555-555-555',
        ]);
    }
}
