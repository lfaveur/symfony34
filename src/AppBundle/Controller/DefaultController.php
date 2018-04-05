<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use RiotAPI\RiotAPI;
use RiotAPI\Definitions\Region;
use DataDragonAPI\DataDragonAPI;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        try {
            $api = new RiotAPI([
                //  Your API key, you can get one at https://developer.riotgames.com/
                RiotAPI::SET_KEY => $this->getParameter('api_key_riot'),
                //  Target region (you can change it during lifetime of the library instance)
                RiotAPI::SET_REGION => Region::EUROPE_EAST,
            ]);
            dump($api->getStaticChampion(61)); // Orianna <3);
        }catch(\Exception $e){

        }
        echo "fesq";
        echo DataDragonAPI::getChampionLoading('Orianna');
        echo "fesq";

        die;
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
