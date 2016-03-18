<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('AcmeStoreBundle:Default:index.html.twig');
    }

    /**
     * @Route("/create")
     */
    public function createAction()
    {
        $product = new User();
        $product->setName('A Foo Bar');

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($product);
        $dm->flush();

        return new Response('Created product id '.$product->getId());
    }


    /**
     * @Route("/get/{id}")
     */
    public function showAction(User $user = null)
    {
        $dm = $this->get('doctrine_mongodb')->getRepository('AcmeStoreBundle:User');
        dump($dm->findAll());
        dump($user);
        return new Response('Get product id ' . $user->getId(). ' , Name :' . $user->getName());
    }
}
