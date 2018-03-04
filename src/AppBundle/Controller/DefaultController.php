<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/i", name="homepage2")
     */
    public function indexBisAction(Request $request)
    {
        $data = [
            [
                'nom' => 'Faveur',
                'prenom' => 'Lionel'
            ],
            [
                'nom' => 'Faveur',
                'prenom' => 'Darida'
            ],
        ];
        // replace this example code with whatever you need
        return $this->render('beautiful/famille.html.twig', ['data' => $data]);
    }
}
