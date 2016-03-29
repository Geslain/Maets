<?php

namespace Acme\StoreBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\StoreBundle\Document\User;
use Acme\StoreBundle\Form\UserType;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Lists all User documents.
     *
     * @Route("/", name="user")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
        $dm = $this->getDocumentManager();

        $documents = $dm->getRepository('AcmeStoreBundle:User')->findAll();

        return array('documents' => $documents);
    }

    /**
     * Displays a form to create a new User document.
     *
     * @Route("/new", name="user_new")
     * @Template()
     *
     * @return array
     */
    public function newAction()
    {
        $document = new User();
        $form = $this->createForm(UserType::class, $document);

        return array(
            'document' => $document,
            'form'     => $form->createView()
        );
    }

    /**
     * Creates a new User document.
     *
     * @Route("/create", name="user_create")
     * @Method("POST")
     * @Template("AcmeStoreBundle:User:new.html.twig")
     *
     *
     * @return array
     */
    public function createAction()
    {
        $document = new User();
        $form     = $this->createForm(UserType::class, $document);
        $request = $this->get("request_stack")->getCurrentRequest();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $dm = $this->get('fos_user.user_manager');
            $dm->updateUser($document);

            return $this->redirect($this->generateUrl('user_show', array('id' => $document->getId())));
        }

        return array(
            'document' => $document,
            'form'     => $form->createView()
        );
    }

    /**
     * Finds and displays a User document.
     *
     * @Route("/{id}/show", name="user_show")
     * @Template()
     *
     * @param string $id The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function showAction($id)
    {
        $dm = $this->getDocumentManager();

        $document = $dm->getRepository('AcmeStoreBundle:User')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find User document.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User document.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Template()
     *
     * @param string $id The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function editAction($id)
    {
        $dm = $this->getDocumentManager();

        $document = $dm->getRepository('AcmeStoreBundle:User')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find User document.');
        }

        $editForm = $this->createForm(UserType::class, $document);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'document'    => $document,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User document.
     *
     * @Route("/{id}/update", name="user_update")
     * @Method("POST")
     * @Template("AcmeStoreBundle:User:edit.html.twig")
     *
     * @param Request $request The request object
     * @param string $id       The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function updateAction(Request $request, $id)
    {
        $dm = $this->get('fos_user.user_manager');

        $document = $dm->getRepository('AcmeStoreBundle:User')->find($id);

        if (!$document) {
            throw $this->createNotFoundException('Unable to find User document.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm   = $this->createForm(UserType::class, $document);
        $request = $this->get("request_stack")->getCurrentRequest();
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $dm->updateUser($document);

            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return array(
            'document'    => $document,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User document.
     *
     * @Route("/{id}/delete", name="user_delete")
     * @Method("POST")
     *
     * @param string $id       The document ID
     *
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException If document doesn't exists
     */
    public function deleteAction($id)
    {
        $request = $this->get("request_stack")->getCurrentRequest();
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $dm = $this->getDocumentManager();
            $document = $dm->getRepository('AcmeStoreBundle:User')->find($id);

            if (!$document) {
                throw $this->createNotFoundException('Unable to find User document.');
            }

            $dm->remove($document);
            $dm->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', HiddenType::class)
            ->getForm()
        ;
    }

    /**
     * Returns the DocumentManager
     *
     * @return DocumentManager
     */
    private function getDocumentManager()
    {
        return $this->get('doctrine.odm.mongodb.document_manager');
    }
}
