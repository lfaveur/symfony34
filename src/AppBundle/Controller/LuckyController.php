<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class LuckyController    extends Controller
{
    /**
     * @Route("/lucky/number")
     *
     * @return Response
     */
    public function number()
    {
        $number = mt_rand(0, 100);
        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }
}