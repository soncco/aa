<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Andean\HotelBundle\Entity\Acomodacion;
use Andean\BackendBundle\Form\AcomodacionType;

/**
 * Acomodacion controller.
 *
 */
class AcomodacionController extends Controller
{
    /**
     * Lists all Acomodacion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('HotelBundle:Acomodacion')->findAll();

        return $this->render('BackendBundle:Acomodacion:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Ciudad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HotelBundle:Acomodacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la acomodación solicitada.');
        }

        return $this->render('BackendBundle:Acomodacion:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to create a new Acomodacion entity.
     *
     */
    public function newAction()
    {
        $entity = new Acomodacion();
        $form   = $this->createForm(new AcomodacionType(), $entity);

        return $this->render('BackendBundle:Acomodacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Acomodacion entity.
     *
     */
    public function createAction()
    {
        $entity  = new Acomodacion();
        $request = $this->getRequest();
        $form    = $this->createForm(new AcomodacionType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha creado la acomodación "%s".', $entity)
            );

            return $this->redirect($this->generateUrl('backend_acomodacion_show', array('id' => $entity->getId())));

        }

        return $this->render('BackendBundle:Acomodacion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Ciudad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HotelBundle:Acomodacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la acomodación solicitada.');
        }

        $editForm = $this->createForm(new AcomodacionType(), $entity);

        return $this->render('BackendBundle:Acomodacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Ciudad entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('HotelBundle:Acomodacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la acomodación solicitada.');
        }

        $editForm   = $this->createForm(new AcomodacionType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha actualizado la acomodación "%s".', $entity)
            );

            return $this->redirect($this->generateUrl('backend_acomodacion_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Acomodacion:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
}
