<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use App\Test\CustomApiTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class CheeseListingResourceTest extends CustomApiTestCase
{
    use ReloadDatabaseTrait;

    public function testCreateCheeseListing()
    {
        $client = self::createClient();

        $client->request('POST', '/api/cheeses');
        $this->assertResponseStatusCodeSame(401);

        $this->createdUser('saysa@example.de', '$argon2id$v=19$m=65536,t=4,p=1$7DwAvEZGsYJm12aGXhnqvA$xjbjDjvNZr3P4utdj335mEmyo1MqejtcC9hlhSwOQew');
        $this->logIn($client, 'saysa@example.de', 'saysa');
    }
}
