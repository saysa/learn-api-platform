<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CheeseListingResourceTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateCheeseListing()
    {
        $client = self::createClient();

        $client->request('POST', '/api/cheeses');
        $this->assertResponseStatusCodeSame(401);

        $user = new User();
        $user->setEmail('saysa@example.de');
        $user->setUsername('saysa');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$7DwAvEZGsYJm12aGXhnqvA$xjbjDjvNZr3P4utdj335mEmyo1MqejtcC9hlhSwOQew');

        $em = self::$container->get(EntityManagerInterface::class);
        $em->persist($user);
        $em->flush();

        $client->request('POST', '/login', [
            'json' => [
                'email' => 'saysa@example.de',
                'password' => 'saysa',
            ],
        ]);
        $this->assertResponseStatusCodeSame(204);
    }
}
