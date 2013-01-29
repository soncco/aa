<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\HotelBundle\Entity\HotelEmpresa;
use Andean\BackendBundle\Form\HotelEmpresaType;

/**
 * HotelEmpresa controller.
 *
 */
class HotelEmpresaController extends Controller
{
    /**
     * Lists all HotelEmpresa entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HotelBundle:HotelEmpresa')->findAll();

        return $this->render('BackendBundle:HotelEmpresa:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a HotelEmpresa entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBundle:HotelEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra la empresa de hotel.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:HotelEmpresa:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new HotelEmpresa entity.
     *
     */
    public function newAction()
    {
        $entity = new HotelEmpresa();
        $form   = $this->createForm(new HotelEmpresaType(), $entity);

        return $this->render('BackendBundle:HotelEmpresa:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new HotelEmpresa entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new HotelEmpresa();
        $form = $this->createForm(new HotelEmpresaType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha creado la empresa de hotel "%s."', $entity)
            );

            return $this->redirect($this->generateUrl('backend_hotelempresa_show', array('id' => $entity->getId())));
        }

        return $this->render('BackendBundle:HotelEmpresa:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing HotelEmpresa entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBundle:HotelEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra la empresa de hotel.');
        }

        $editForm = $this->createForm(new HotelEmpresaType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:HotelEmpresa:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing HotelEmpresa entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HotelBundle:HotelEmpresa')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra la empresa de hotel.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new HotelEmpresaType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha actualizado la empresa de hotel "%s".', $entity)
            );

            return $this->redirect($this->generateUrl('backend_hotelempresa_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:HotelEmpresa:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a HotelEmpresa entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HotelBundle:HotelEmpresa')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se encuentra la empresa de hotel.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_hotelempresa'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
