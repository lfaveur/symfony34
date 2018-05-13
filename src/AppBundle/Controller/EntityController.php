<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Auteur;
use AppBundle\Entity\Biographie;
use AppBundle\Entity\Livre;
use AppBundle\Entity\Theme;
use AppBundle\Repository\ThemeRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

class EntityController    extends Controller
{


    /**
     * @Route("/entity/OneLivre")
     */
    public function One()
    {
        $manager = $this->getDoctrine()->getManager();

        $repository = $manager->getRepository('AppBundle:Livre');
        $toto = $repository->find(1);
        dump($toto->getThemes());
        die;
    }
    /**
     * @Route("/entity/form")
     */
    public function form()
    {

        // creates a task and gives it some dummy data for this example
        $livre = new Livre();
        $em = $this->getDoctrine()->getManager();

        $livre = $em->getRepository('AppBundle:Livre')->findAll();


        $form = $this->createFormBuilder($livre)
            ->add('titre', TextType::class)
            ->add('themes', Entity::class,[
                'class' => 'AppBundle\Entity\Theme',
                'query_builder' => function (ThemeRepository $repository) use ($livre) {
                    return $repository
                        ->getAllThemeQueryBuilder($livre)
                        ->select('n');
                },
                'required' => true,
                'multiple'=> true,
            ])
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();


        return $this->render('entity/form.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/entity/OneAuthor")
     */
    public function OneAuthor()
    {
        $manager = $this->getDoctrine()->getManager();

        $repository = $manager->getRepository('AppBundle:Auteur');
        $toto = $repository->find(1);
        dump($toto->getLivres());
        die;
    }
    /**
     * @Route("/entity/ListBook")
     */
    public function listBook()
    {
        $manager = $this->getDoctrine()->getManager();

        $repository = $manager->getRepository('AppBundle:Livre');
        $toto = $repository->findAll();
        dump($toto);
        die;
    }
    /**
     * @Route("/entity/listBio")
     */
    public function listBio()
    {
        $manager = $this->getDoctrine()->getManager();

        $repository = $manager->getRepository('AppBundle:Biographie');
        $toto = $repository->findAll();
        dump($toto);
        die;
    }

    /**
     * @Route("/entity/loadFixtureTheme")
     */
    public function loadFixtureTheme()
    {
        $manager = $this->getDoctrine()->getManager();


        $manager->flush();
        dump('ok');die;
    }

    /**
     * @Route("/entity/loadFixture")
     */
    public function loadFixture()
    {
        $manager = $this->getDoctrine()->getManager();
        $nature = new Theme();
        $nature
            ->setName('nature')
        ;
        $manager->persist($nature);

        $bois = new Theme();
        $bois
            ->setName('bois')
        ;
        $manager->persist($bois);

        $terre = new Theme();
        $terre
            ->setName('terre')
        ;
        $manager->persist($terre);

        $orwell = new Auteur();
        $orwell
            ->setNom('Orwell')
            ->setPrenom('George')
            ->setNaissance(new \DateTime('1903-06-25'))
            ->setLieu('Motihari')
            ->setSlug('slug')
        ;
        $manager->persist($orwell);

        $bioOrwell = new Biographie();
        $bioOrwell
            ->setTitre('titre')
            ->setAuteur($orwell)
        ;
        $manager->persist($bioOrwell);


        $fermeAnimaux = new Livre();
        $fermeAnimaux
            ->setTitre('La ferme des animaux')
            ->setAuteur($orwell)
            ->setDateParution(new \DateTime('1945-08-17'))
            ->addTheme($terre)
            ->addTheme($nature)
        ;
        $manager->persist($fermeAnimaux);

        $fermeAnimaux2 = new Livre();
        $fermeAnimaux2
            ->setTitre('La ferme des animaux2')
            ->setAuteur($orwell)
            ->setDateParution(new \DateTime('1945-08-17'))
        ;
        $manager->persist($fermeAnimaux2);

        $verne = new Auteur();
        $verne
            ->setNom('Verne')
            ->setPrenom('Jules')
            ->setNaissance(new \DateTime('1828-02-08'))
            ->setLieu('Nantes')
            ->setSlug('slug1')
        ;
        $manager->persist($verne);

        $bioVerne = new Biographie();
        $bioVerne
            ->setTitre('verne')
            ->setAuteur($verne)
        ;
        $manager->persist($bioVerne);
        
        $tourDuMonde = new Livre;
        $tourDuMonde
            ->setTitre('Le tour du monde en 80 jours')
            ->setAuteur($verne)
            ->setDateParution(new \DateTime('1872-01-01'))
        ;
        $manager->persist($tourDuMonde);

        $tourDuMonde2 = new Livre;
        $tourDuMonde2
            ->setTitre('Le tour du monde en 80 jours 2')
            ->setAuteur($verne)
            ->setDateParution(new \DateTime('1872-01-01'))
        ;
        $manager->persist($tourDuMonde2);

        $manager->flush();
        dump('ok');die;
    }
}