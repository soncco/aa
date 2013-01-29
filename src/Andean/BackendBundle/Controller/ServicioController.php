<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Andean\BackendBundle\Entity\Servicio;
use Andean\BackendBundle\Form\ServicioType;

/**
 * Servicio controller.
 *
 */
class ServicioController extends Controller
{
    /**
     * Lists all Servicio entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('BackendBundle:Servicio')->findAll();

        return $this->render('BackendBundle:Servicio:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Servicio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el servicio solicitado.');
        }

        return $this->render('BackendBundle:Servicio:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to create a new Servicio entity.
     *
     */
    public function newAction()
    {
        $entity = new Servicio();
        $form   = $this->createForm(new ServicioType(), $entity);

        return $this->render('BackendBundle:Servicio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Servicio entity.
     *
     */
    public function createAction()
    {
        $entity  = new Servicio();
        $request = $this->getRequest();
        $form    = $this->createForm(new ServicioType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha creado el servicio "%s."', $entity)
            );

            return $this->redirect($this->generateUrl('backend_servicio_show', array('id' => $entity->getId())));

        }

        return $this->render('BackendBundle:Servicio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el servicio solicitado.');
        }

        $editForm = $this->createForm(new ServicioType(), $entity);

        return $this->render('BackendBundle:Servicio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Servicio entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el servicio solicitado.');
        }

        $editForm   = $this->createForm(new ServicioType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);
        
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha actualizado el servicio "%s".', $entity)
            );

            return $this->redirect($this->generateUrl('backend_servicio_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Servicio:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
}
