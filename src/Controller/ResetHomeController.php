<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Renter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ResetHomeController
{
    public function __invoke(Renter $data, EntityManagerInterface $manager)
    {
        $homes = $data->getHome();
        foreach ($homes as $home) {
            $manager->remove($home);
        }
        $manager->flush();

        return new Response(null, 204);
    }
}
