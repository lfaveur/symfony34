<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class ProductController extends Controller
{
    /**
     * @Route("/product/add", name="product.add")
     */
    public function addAction(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $product = new Product();

        $form = $this->createFormBuilder($product)
            ->add('description', TextareaType::class)
            ->add('price', IntegerType::class)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Product'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $product = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirect($this->generateUrl('product.view', array( 'id' => $product->getId())));
        }
        return $this->render('product/add.index.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/product/{id}", name="product.view")
     */
    public function viewAction(Product $product)
    {
        return $this->render('product/view.index.twig', array(
            'product' => $product
        ));
    }
}
