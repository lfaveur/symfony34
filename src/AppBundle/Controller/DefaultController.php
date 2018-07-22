<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use GeoIp2\Database\Reader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Cyprus\Hello;



class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, \Swift_Mailer $mailer)
    {
        $this->get('monolog.logger.test')->log('error','dgfdgd', []);

//        $toto = new Hello\Hello();
//        dump($toto->say());
//        die;        $toto = new Hello\Hello();
//        dump($toto->say());
//        die;
                     /*todo: a service can be done for mailing ! same for geoip*/
//        $message = (new \Swift_Message('Hello Email'))
//            ->setFrom('draculadelanochedelavide@gmail.com')
//            ->setTo('lionel.faveur@gmail.com')
//            ->setBody('un autre test', 'text/html')
//            /*
//             * If you also want to include a plaintext version of the message
//            ->addPart(
//                $this->renderView(
//                    'Emails/registration.txt.twig',
//                    array('name' => $name)
//                ),
//                'text/plain'
//            )
//            */
//        ;
//
//        try {
//            dump($mailer->send($message));
//        }catch(\Exception $e){
//            dump($e);
//        }
//        die;

//        // Declare the path to the GeoLite2-City.mmdb file (database)
//        $GeoLiteDatabasePath = $this->get('kernel')->getRootDir() . '/../private/GeoLite2-Country/GeoLite2-Country.mmdb';
//
//        // Create an instance of the Reader of GeoIp2 and provide as first argument
//        // the path to the database file
//        $reader = new Reader($GeoLiteDatabasePath);
//
//        try{
//            // if you are in the production environment you can retrieve the
//            // user's IP with $request->getClientIp()
//            // Note that in a development environment 127.0.0.1 will
//            // throw the AddressNotFoundException
//
//
//            // In this example, use a fixed IP address in Minnesota
//            $record = $reader->country('14.0.16.0');
//            dump($record);
//            die;
//        } catch (\Exception $ex) {
//            // Couldn't retrieve geo information from the given IP
//            return new Response("It wasn't possible to retrieve information about the providen IP");
//        }
//
//        $this->settoto();
//        dump($request->cookies,$request->getClientIp());
//        die;
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


    public function settoto(){
        $cookie = new Cookie(
            'my_cookie',    // Cookie name.
            'ggfgf',    // Cookie value.
            time() + ( 2 * 365 * 24 * 60 * 60)  // Expires 2 years.
        );
        $res = new Response();
        $res->headers->setCookie( $cookie );
        $res->send();
    }

    public function createAction()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: createAction(EntityManagerInterface $em)
        $entityManager = $this->getDoctrine()->getManager();

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(19.99);
        $product->setDescription('Ergonomic and stylish!');

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

// if you have multiple entity managers, use the registry to fetch them
    public function editAction()
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $em2 = $doctrine->getManager('other_connection');
    }

    public function showAction($productId)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($productId);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$productId
            );
        }
    }
}
