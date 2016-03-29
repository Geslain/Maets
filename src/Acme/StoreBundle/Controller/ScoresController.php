<?php
/**
 * Created by PhpStorm.
 * User: Gess
 * Date: 29/03/2016
 * Time: 21:10
 */

namespace Acme\StoreBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Tests\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Controller\Annotations\Put;

/**
 * @Route("/stats")
 */
class StatController extends FOSRestController
{

    /**
     * @Put("/{game}")
     */
    public function putIndexAction($game) {

        $handler = $this->get("request_stack")->getCurrentRequest();
        return new JsonResponse( $handler->request->all());
    }
}