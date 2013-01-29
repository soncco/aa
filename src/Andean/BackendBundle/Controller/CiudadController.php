<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Andean\TrenBundle\Entity\Ciudad;
use Andean\BackendBundle\Form\CiudadType;

/**
 * Ciudad controller.
 *
 */
class CiudadController extends Controller
{
    /**
     * Lists all Ciudad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('TrenBundle:Ciudad')->findAll();

        return $this->render('BackendBundle:Ciudad:index.html.twig', array(
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

        $entity = $em->getRepository('TrenBundle:Ciudad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la ciudad solicitada.');
        }

        return $this->render('BackendBundle:Ciudad:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to create a new Ciudad entity.
     *
     */
    public function newAction()
    {
        $entity = new Ciudad();
        $form   = $this->createForm(new CiudadType(), $entity);

        return $this->render('BackendBundle:Ciudad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Ciudad entity.
     *
     */
    public function createAction()
    {
        $entity  = new Ciudad();
        $request = $this->getRequest();
        $form    = $this->createForm(new CiudadType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha creado la ciudad "%s."', $entity)
            );

            return $this->redirect($this->generateUrl('backend_ciudad_show', array('id' => $entity->getId())));

        }

        return $this->render('BackendBundle:Ciudad:new.html.twig', array(
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

        $entity = $em->getRepository('TrenBundle:Ciudad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la ciudad solicitada.');
        }

        $editForm = $this->createForm(new CiudadType(), $entity);

        return $this->render('BackendBundle:Ciudad:edit.html.twig', array(
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

        $entity = $em->getRepository('TrenBundle:Ciudad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado la ciudad solicitada.');
        }

        $editForm   = $this->createForm(new CiudadType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);
        
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha actualizado la ciudad "%s".', $entity)
            );

            return $this->redirect($this->generateUrl('backend_ciudad_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Ciudad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
}
