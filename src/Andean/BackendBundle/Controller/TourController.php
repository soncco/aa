<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Andean\BackendBundle\Entity\Tour;
use Andean\BackendBundle\Form\TourType;

/**
 * Tour controller.
 *
 */
class TourController extends Controller
{
    /**
     * Lists all Tour entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('BackendBundle:Tour')->findAll();

        return $this->render('BackendBundle:Tour:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Tour entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Tour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tour solicitado.');
        }

        return $this->render('BackendBundle:Tour:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to create a new Tour entity.
     *
     */
    public function newAction()
    {
        $entity = new Tour();
        $form   = $this->createForm(new TourType(), $entity);

        return $this->render('BackendBundle:Tour:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Tour entity.
     *
     */
    public function createAction()
    {
        $entity  = new Tour();
        $request = $this->getRequest();
        $form    = $this->createForm(new TourType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha creado el tour "%s."', $entity)
            );

            return $this->redirect($this->generateUrl('backend_tour_show', array('id' => $entity->getId())));

        }

        return $this->render('BackendBundle:Tour:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Tour entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Tour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tour solicitado.');
        }

        $editForm = $this->createForm(new TourType(), $entity);

        return $this->render('BackendBundle:Tour:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Tour entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Tour')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el tour solicitado.');
        }

        $editForm   = $this->createForm(new TourType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);
        
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha actualizado el tour "%s".', $entity)
            );

            return $this->redirect($this->generateUrl('backend_tour_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Tour:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
}
