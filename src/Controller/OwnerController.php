<?php

namespace App\Controller;

use App\Entity\Owner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OwnerController extends AbstractController
{
    /**
     * @Route("/owner", name="owner")
     */
    public function index(SerializerInterface $serializer): Response
    {
        $owner = new Owner('Doe', 'John', 'Developer');
        $saysa = new Owner('Bounkhong', 'Saysa', 'Trainer');

        $output = $serializer->serialize([$owner, $saysa], 'json');

        // dd($output);

        $json = '[{"name":"Doe","firstname":"John","job":"Developer"},{"name":"Bounkhong","firstname":"Saysa","job":"Trainer"}]';

        //$json = '{"name":"Doe","firstname":"John","job":"Developer"}';

        $objects = $serializer->deserialize($json, Owner::class.'[]', 'json');

        dd($objects);

        return $this->render('owner/index.html.twig', [
            'controller_name' => 'OwnerController',
        ]);
    }
}
