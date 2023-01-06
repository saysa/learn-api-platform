<?php

declare(strict_types=1);

namespace App\Test;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Client;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CustomApiTestCase extends ApiTestCase
{
    protected function createdUser(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setUsername(substr($email, 0, strpos($email, '@')));
        $user->setPassword($password);

        $em = self::$container->get(EntityManagerInterface::class);
        $em->persist($user);
        $em->flush();

        return $user;
    }

    protected function logIn(Client $client, string $email, string $password)
    {
        $client->request('POST', '/login', [
            'json' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        $this->assertResponseStatusCodeSame(204);
    }
}
