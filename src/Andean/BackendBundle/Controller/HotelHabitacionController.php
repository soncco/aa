<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\HotelBundle\Entity\HotelHabitacion;
use Andean\BackendBundle\Form\HotelHabitacionType;

/**
 * HotelHabitacion controller.
 *
 */
class HotelHabitacionController extends Controller
{
    /**
     * Lists all HotelHabitacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HotelBundle:HotelHabitacion')->findAll();

        return $this->render('BackendBundle:HotelHabitacion:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a HotelHabitacion entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBundle:HotelHabitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra la habitación.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:HotelHabitacion:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new HotelHabitacion entity.
     *
     */
    public function newAction()
    {
        $entity = new HotelHabitacion();
        $form   = $this->createForm(new HotelHabitacionType(), $entity);

        return $this->render('BackendBundle:HotelHabitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new HotelHabitacion entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new HotelHabitacion();
        $form = $this->createForm(new HotelHabitacionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              'Se ha creado la habitación.'
            );

            return $this->redirect($this->generateUrl('backend_hotelhabitacion_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:HotelHabitacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing HotelHabitacion entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBundle:HotelHabitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra la habitación.');
        }

        $editForm = $this->createForm(new HotelHabitacionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:HotelHabitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing HotelHabitacion entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBundle:HotelHabitacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra la habitación.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new HotelHabitacionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              'Se ha modificado la habitación.'
            );

            return $this->redirect($this->generateUrl('backend_hotelhabitacion_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:HotelHabitacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a HotelHabitacion entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HotelBundle:HotelHabitacion')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se encuentra la habitación.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_hotelhabitacion'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
