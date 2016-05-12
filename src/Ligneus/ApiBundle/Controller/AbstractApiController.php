<?php

namespace Ligneus\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
abstract class AbstractApiController extends Controller
{
    protected function getApiResponse($data, $statusCode = 200)
    {
        $serializer = $this->get('jms_serializer');
        $data = $serializer->serialize($data, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
