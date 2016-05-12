<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class MiscController extends AbstractApiController
{
    public function testSlackAction(Request $request)
    {
        $url = $request->get('url');

        if (!$url) {
            throw new \Exception('No Slack Url provided!');
        }

        $client = new Client();
        $payload = [
            'text' => '[EXCEPTION][Test] Test\n*URI*: <http://test.de>\n*Incident*: <Test>',
            'username' => 'Exception Tracker',
        ];

        $res = $client->request('POST', $url, [
            'body' => $this->sanitizeNewline(json_encode($payload)),
            'verify' => false,
        ]);

        return $this->getApiResponse([
            'status' => 'success',
            'payload' => $this->sanitizeNewline(json_encode($payload)),
        ]);
    }

    private function sanitizeNewline($str)
    {
        return str_replace('\\\\n', '\n', $str);
    }
}
