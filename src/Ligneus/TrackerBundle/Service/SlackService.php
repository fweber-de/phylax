<?php

namespace Ligneus\TrackerBundle\Service;

use GuzzleHttp\Client as GuzzleClient;

/**
 * @author Florian Weber <fweber@ligneus.de>
 */
class SlackService
{
    public function sendSlackMessage($url, $message, $username)
    {
        $guzzle = new GuzzleClient([
            'proxy' => 'http://125.122.82.113:3128',
        ]);
        $payload = [
            'text' => $message,
            'username' => $username,
        ];

        $res = $guzzle->request('POST', $url, [
            'body' => $this->sanitizeNewline(json_encode($payload)),
            'verify' => false,
        ]);
    }

    private function sanitizeNewline($str)
    {
        return str_replace('\\\\n', '\n', $str);
    }
}
