<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\TrenBundle\Entity\TrenHorario;
use Andean\BackendBundle\Form\TrenHorarioType;

/**
 * TrenHorario controller.
 *
 */
class TrenHorarioController extends Controller
{
    /**
     * Lists all TrenHorario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TrenBundle:TrenHorario')->findAll();

        return $this->render('BackendBundle:TrenHorario:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a TrenHorario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenHorario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el horario solicitado.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:TrenHorario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new TrenHorario entity.
     *
     */
    public function newAction()
    {
        $entity = new TrenHorario();
        $form   = $this->createForm(new TrenHorarioType(), $entity);

        return $this->render('BackendBundle:TrenHorario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new TrenHorario entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new TrenHorario();
        $form = $this->createForm(new TrenHorarioType(), $entity);
        $form->bind($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              'Se ha creado el horario.'
            );

            return $this->redirect($this->generateUrl('backend_trenhorario_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:TrenHorario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TrenHorario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenHorario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el horario solicitado.');
        }

        $editForm = $this->createForm(new TrenHorarioType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:TrenHorario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing TrenHorario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TrenBundle:TrenHorario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el horario solicitado.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TrenHorarioType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              'Se ha actualizado el horario.'
            );

            return $this->redirect($this->generateUrl('backend_trenhorario_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:TrenHorario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TrenHorario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TrenBundle:TrenHorario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se ha encontrado el horario solicitado.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_trenhorario'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
