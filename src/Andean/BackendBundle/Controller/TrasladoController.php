<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Andean\BackendBundle\Entity\Traslado;
use Andean\BackendBundle\Form\TrasladoType;

/**
 * Traslado controller.
 *
 */
class TrasladoController extends Controller
{
    /**
     * Lists all Traslado entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('BackendBundle:Traslado')->findAll();

        return $this->render('BackendBundle:Traslado:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Traslado entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Traslado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el traslado solicitado.');
        }

        return $this->render('BackendBundle:Traslado:show.html.twig', array(
            'entity'      => $entity,
        ));
    }

    /**
     * Displays a form to create a new Traslado entity.
     *
     */
    public function newAction()
    {
        $entity = new Traslado();
        $form   = $this->createForm(new TrasladoType(), $entity);

        return $this->render('BackendBundle:Traslado:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Creates a new Traslado entity.
     *
     */
    public function createAction()
    {
        $entity  = new Traslado();
        $request = $this->getRequest();
        $form    = $this->createForm(new TrasladoType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha creado el traslado "%s."', $entity)
            );

            return $this->redirect($this->generateUrl('backend_traslado_show', array('id' => $entity->getId())));

        }

        return $this->render('BackendBundle:Traslado:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Traslado entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Traslado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el traslado solicitado.');
        }

        $editForm = $this->createForm(new TrasladoType(), $entity);

        return $this->render('BackendBundle:Traslado:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
     * Edits an existing Traslado entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('BackendBundle:Traslado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se ha encontrado el traslado solicitado.');
        }

        $editForm   = $this->createForm(new TrasladoType(), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);
        
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->setFlash('info',
              sprintf('Se ha actualizado el traslado "%s".', $entity)
            );

            return $this->redirect($this->generateUrl('backend_traslado_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Traslado:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
}
