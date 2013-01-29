<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\TrenBundle\Entity\TrenEmpresa;
use Andean\BackendBundle\Form\TrenEmpresaType;

/**
 * TrenEmpresa controller.
 *
 */
class TrenEmpresaController extends Controller
{
    /**
     * Lists all TrenEmpresa entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TrenBundle:TrenEmpresa')->findAll();

        return $this->render('BackendBundle:TrenEmpresa:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a TrenEmpresa entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la empresa de tren solicitada.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:TrenEmpresa:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new TrenEmpresa entity.
     *
     */
    public function newAction()
    {
        $entity = new TrenEmpresa();
        $form   = $this->createForm(new TrenEmpresaType(), $entity);

        return $this->render('BackendBundle:TrenEmpresa:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new TrenEmpresa entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new TrenEmpresa();
        $form = $this->createForm(new TrenEmpresaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha creado la empresa de tren %s', $entity)
            );

            return $this->redirect($this->generateUrl('backend_trenempresa_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:TrenEmpresa:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrenEmpresa entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la empresa de tren solicitada.');
        }

        $editForm = $this->createForm(new TrenEmpresaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:TrenEmpresa:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing TrenEmpresa entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la empresa de tren solicitada.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TrenEmpresaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              'Se ha actualizado la empresa de tren.'
            );

            return $this->redirect($this->generateUrl('backend_trenempresa_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:TrenEmpresa:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrenEmpresa entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TrenBundle:TrenEmpresa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado la empresa de tren solicitada.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_trenempresa'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
