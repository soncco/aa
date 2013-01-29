<?php

namespace Andean\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Andean\BackendBundle\Entity\Usuario;
use Andean\BackendBundle\Form\UsuarioType;
use Andean\BackendBundle\Form\UsuarioEditType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{
    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction()
    {
        $paginador = $this->get('ideup.simple_paginator');
        
        $paginador->setItemsPerPage(5);
        
        $em = $this->getDoctrine()->getManager();

        $entities = $paginador->paginate($em->getRepository('BackendBundle:Usuario')->queryUsuarios())->getResult();        

        return $this->render('BackendBundle:Usuario:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra el usuario.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createForm(new UsuarioType(), $entity);

        return $this->render('BackendBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction(Request $request)
    {
        $peticion = $this->getRequest();
        $em = $this->getDoctrine()->getEntityManager();

        $usuario = new Usuario();

        $formulario = $this->createForm(new UsuarioEditType(), $usuario);

        if ($peticion->getMethod() == 'POST') {
            $formulario->bind($peticion);

            if ($formulario->isValid()) {
                // Completar las propiedades que el usuario no rellena en el formulario
                $usuario->setSalt(md5(time()));

                $encoder = $this->get('security.encoder_factory')->getEncoder($usuario);
                $passwordCodificado = $encoder->encodePassword(
                    $usuario->getPassword(),
                    $usuario->getSalt()
                );
                $usuario->setPassword($passwordCodificado);

                // Guardar el nuevo usuario en la base de datos
                $em->persist($usuario);
                $em->flush();

                // Crear un mensaje flash para notificar al usuario que se ha registrado correctamente
                $this->get('session')->setFlash('info',
                    'Se ha creado el usuario.'
                );
            }
        }

        return $this->render('BackendBundle:Usuario:show.html.twig', array(
            'entity'      => $usuario,
            'formulario' => $formulario->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra el usuario.');
        }

        $editForm = $this->createForm(new UsuarioEditType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BackendBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BackendBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra el usuario.');
        }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new UsuarioEditType(), $entity);

        $originalPassword = $editForm->getData()->getPassword();

        $editForm->bind($request);

        if ($editForm->isValid()) {
            if (null == $entity->getPassword()) {
                $entity->setPassword($originalPassword);
            }
            else {
                $encoder = $this->get('security.encoder_factory')->getEncoder($entity);
                $codedPassword = $encoder->encodePassword(
                    $entity->getPassword(),
                    $entity->getSalt()
                );
                $entity->setPassword($codedPassword);
            }
            $em->persist($entity);
            $em->flush();

            $this->get('session')->setFlash('info',
                sprintf('Se ha modificado el usuario "%s".', $entity->getUsuario())
            );

            return $this->redirect($this->generateUrl('backend_usuario_edit', array('id' => $id)));
        }

        return $this->render('BackendBundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BackendBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se encuentra el usuario.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_usuario'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
