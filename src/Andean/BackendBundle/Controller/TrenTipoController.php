<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\TrenBundle\Entity\TrenTipo;
use Andean\BackendBundle\Form\TrenTipoType;

/**
 * TrenTipo controller.
 *
 */
class TrenTipoController extends Controller
{
    /**
     * Lists all TrenTipo entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TrenBundle:TrenTipo')->findAll();

        return $this->render('BackendBundle:TrenTipo:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a TrenTipo entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenTipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tipo solicitado.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:TrenTipo:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new TrenTipo entity.
     *
     */
    public function newAction()
    {
        $entity = new TrenTipo();
        $form   = $this->createForm(new TrenTipoType(), $entity);

        return $this->render('BackendBundle:TrenTipo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new TrenTipo entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new TrenTipo();
        $form = $this->createForm(new TrenTipoType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha creado el tipo de tren %s', $entity)
            );

            return $this->redirect($this->generateUrl('backend_trentipo_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:TrenTipo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrenTipo entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenTipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tipo solicitado.');
        }

        $editForm = $this->createForm(new TrenTipoType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:TrenTipo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing TrenTipo entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenTipo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tipo solicitado.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TrenTipoType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              'Se ha actualizado el tipo de tren.'
            );

            return $this->redirect($this->generateUrl('backend_trentipo_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:TrenTipo:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrenTipo entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TrenBundle:TrenTipo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado el tipo solicitado.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_trentipo'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
