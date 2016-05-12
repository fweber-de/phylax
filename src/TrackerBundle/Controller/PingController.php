<?php

namespace TrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Seld\JsonLint\JsonParser;
use \DataBundle\Entity\Heartbeat;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class PingController extends Controller
{
    public function heartbeatAction(Request $request)
    {
        //handle pre flight
        $method = $request->getRealMethod();
        if ('OPTIONS' == $method) {
            $response = new Response();
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');

            return $response;
        }

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

        //check if heartbeat exists
        $heartbeat = $this->getDoctrine()->getRepository('DataBundle:Heartbeat')->getOneByIpAndApp($parsed->ip, $app);
        $persist = false;

        if (!$heartbeat) {
            $heartbeat = new Heartbeat();
            $heartbeat->setIp($parsed->ip)
                        ->setApplication($app)
                        ->setLastPing(new \DateTime('now'));

            $persist = true;
        } else {
            $heartbeat->setLastPing(new \DateTime('now'));
        }

        $heartbeat->setNotified(false);

        //validate
        $validator = $this->get('validator');
        $errors = $validator->validate($heartbeat);

        if (count($errors) > 0) {
            return new Response(json_encode($errors));
        }

        $em = $this->getDoctrine()->getManager();

        if ($persist) {
            $em->persist($heartbeat);
        }

        $em->flush();

        $response = new Response(json_encode(true));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
