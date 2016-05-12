<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Seld\JsonLint\JsonParser;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class ErrorController extends Controller
{
    public function createAction(Request $request)
    {
        $json = $request->getContent();

        $parser = new JsonParser();
        $parsed = $parser->parse($json);

        /* @var $app \DataBundle\Entity\Application */
        $app = $this->getDoctrine()->getRepository('DataBundle:Application')->findOneByAppkey($parsed->appkey);

        if (!$app) {
            throw new \Exception(sprintf(
                'No Application found for AppKey %s', $parsed->appkey
            ));
        }

        try {
            $this->get('exc.tracker')->trackError($app, $parsed, 'EXCEPTION');
        } catch (\Exception $exc) {
            return new Response(json_encode(['error' => $exc->getMessage()]), 500);
        }

        return new Response(json_encode($parsed));
    }
}
