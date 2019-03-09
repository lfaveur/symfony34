<?php

namespace AppBundle\Controller;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use ReCaptcha\ReCaptcha;
use AppBundle\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Livre controller.
 *
 */
class LivreController extends Controller
{
    /**
     * Lists all livre entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $livres = $em->getRepository('AppBundle:Livre')->findAll();

        return $this->render('livre/index.html.twig', array(
            'livres' => $livres,
        ));
    }

    /**
     * A simple collection that even don't use an entity.
     *
     * @Route("/simple-collection", name="basic")
     * @Template()
     */
    public function simpleCollectionAction(Request $request)
    {
        $data = ['values' => ['a', 'b', 'c']];

        $form = $this
            ->createFormBuilder($data)
            ->add('values', CollectionType::class, [
                'entry_type'    => TextType::class,
                'entry_options' => [
                    'label' => 'Value',
                ],
                'label'        => 'Add, move, remove values and press Submit.',
                'allow_add'    => true,
                'allow_delete' => true,
                'prototype'    => true,
                'required'     => false,
                'attr'         => [
                    'class' => 'my-selector',
                ],
            ])
            ->add('submit', SubmitType::class)
            ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
        }

        return $this->render('livre/tt.html.twig', [
            'form' => $form->createView(),
            'data' => $data,
        ]);
    }

    /**
     * Creates a new livre entity.
     *
     */
    public function newAction(Request $request)
    {
        $livre = new Livre();
        $form = $this->createForm('AppBundle\Form\LivreType', $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            $reCaptcha = new ReCaptcha($this->getParameter('secret_key'));
//            $reCaptchaResponse = $request->get('g-recaptcha-response');
//            $reCaptchaCheck = $reCaptcha->verify($reCaptchaResponse, $request->getClientIp());
//            if ($reCaptchaCheck->isSuccess()) {
//                dump('gfbgf');
//                die;
                $em = $this->getDoctrine()->getManager();
                $em->persist($livre);
                $em->flush();
                return $this->redirectToRoute('livre_show', array('id' => $livre->getId()));
//            }

        }

        return $this->render('livre/new.html.twig', array(
            'livre' => $livre,
            'form' => $form->createView(),
            'captchaOwnerKey' => $this->getParameter('site_key')
        ));
    }

    /**
     * Finds and displays a livre entity.
     *
     */
    public function showAction(Livre $livre)
    {
        $deleteForm = $this->createDeleteForm($livre);

        return $this->render('livre/show.html.twig', array(
            'livre' => $livre,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing livre entity.
     *
     */
    public function editAction(Request $request, Livre $livre)
    {
        $deleteForm = $this->createDeleteForm($livre);
        $editForm = $this->createForm('AppBundle\Form\LivreType', $livre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('livre_edit', array('id' => $livre->getId()));
        }

        return $this->render('livre/edit.html.twig', array(
            'livre' => $livre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a livre entity.
     *
     */
    public function deleteAction(Request $request, Livre $livre)
    {
        $form = $this->createDeleteForm($livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($livre);
            $em->flush();
        }

        return $this->redirectToRoute('livre_index');
    }

    /**
     * Creates a form to delete a livre entity.
     *
     * @param Livre $livre The livre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Livre $livre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('livre_delete', array('id' => $livre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
