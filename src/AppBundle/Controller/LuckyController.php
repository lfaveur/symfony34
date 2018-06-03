<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class LuckyController    extends Controller
{
    /**
     * @Route("/lucky/number")
     *
     * @return Response
     */
    public function number(LoggerInterface $logger)
    {
        $toto = $this->getDoctrine()->getManager();
// doctrine !!        dump($toto->getRepository('AppBundle:Product')->findOneBy(['price' => 0]));

        $logger->info('I just got the logger');
        $logger->error('An error occurred');

        $logger->critical('I left the oven on!', array(
            // include extra "context" info in your logs
            'cause' => 'in_hurry',
        ));

//        $tutu = $this->container->get('tutuService');

//        dump($tutu->kiki());
//        die;

        //$success = mail('lionel.faveur@gmail.com', 'My Subject', 'message');
//        if (!$success) {
//            $errorMessage = error_get_last()['message'];
//            dump($errorMessage);
//            die;
//        }
        $number = mt_rand(0, 100);
        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
        ));
    }

    /**
     * @Route("/datafiltered")
     *
     * @return string
     */
    public function testDataFiltered()
    {
        return $this->render('@App/toto.html.twig', []);
    }

    /**
     * @Route("/datafiltered2")
     *
     * @return string
     */
    public function testDataFiltered2()
    {
        return $this->render('@App/jqueryDatafiltered.html.twig', []);
    }
    /**
     * @Route("/lucky/numberC")
     */
    public function numberCAction()
    {
        $number = mt_rand(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/lucky/numberD/{max}")
     */
    public function numberDAction($max)
    {
        $number = mt_rand(0, $max);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @Route("/lucky/redirect")
     *
     */
    public function redirectAction()
    {
//        // redirects to the "homepage" route
//        return $this->redirectToRoute('homepage');
//
//        // does a permanent - 301 redirect
//        return $this->redirectToRoute('homepage', array(), 301);
//
//        // redirects to a route with parameters
//        return $this->redirectToRoute('blog_show', array('slug' => 'my-page'));

        // redirects externally
        return $this->redirect('http://symfony.com/doc');
    }

    /**
     * @Route("/lucky/numberp/{max}")
     */
    public function numberpAction($max, LoggerInterface $logger)
    {
//        throw $this->createAccessDeniedException('denied');
//        dump($this->get('service_container'));
        $logger->info('We are logging!');
        dump($logger);
        die;
        // ...
    }
    /**
     * @param SessionInterface $session
     * @Route("/lucky/luke")
     */
    public function luckyAction(SessionInterface $session)
    {
        // stores an attribute for reuse during a later user request
        $session->set('foo', 'bar');

        // gets the attribute set by another controller in another request
        $foobar = $session->get('foo');

        // uses a default value if the attribute doesn't exist
        $filters = $session->get('foo', array());

        dump($filters);
        die;
    }
    /**
     * @Route("/lucky/message")
     */
    public function flashmessageAction(Request $request)
    {
//        dump($request);
//        return $this->json(['toto' => 'toto']);
//        die;
        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
        return $this->render('lucky/number.html.twig', array(
            'number' => 9,
        ));
    }
}