<?php

namespace AppBundle\Controller;


use ReCaptcha\ReCaptcha;
use AppBundle\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * Creates a new livre entity.
     *
     */
    public function newAction(Request $request)
    {
        $livre = new Livre();
        $form = $this->createForm('AppBundle\Form\LivreType', $livre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reCaptcha = new ReCaptcha($this->getParameter('secret_key'));
            $reCaptchaResponse = $request->get('g-recaptcha-response');
            $reCaptchaCheck = $reCaptcha->verify($reCaptchaResponse, $request->getClientIp());
            if ($reCaptchaCheck->isSuccess()) {
                dump('gfbgf');
                die;
                $em = $this->getDoctrine()->getManager();
                $em->persist($livre);
                $em->flush();
                return $this->redirectToRoute('livre_show', array('id' => $livre->getId()));
            }

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
