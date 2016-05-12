<?php

namespace TrackerBundle\Service;

use GuzzleHttp\Client as GuzzleClient;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class SlackService
{
    public function sendSlackMessage($url, $message, $username)
    {
        $guzzle = new GuzzleClient();
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
