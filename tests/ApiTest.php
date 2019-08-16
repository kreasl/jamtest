<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function testSmokeApi($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider()
    {
        yield ['/'];
        yield ['/login/1'];
        yield ['/users'];
        yield ['/users/1'];
        yield ['/users/1/invitations'];
        yield ['/users/1/invitations/sent'];
        yield ['/users/1/invitations/received'];
        yield ['/logout'];
    }

    public function testSendInvitation() {
        $client = self::createClient();

        $invitation = [
            'receiverId' => 2,
            'message' => 'Test send invitation ' . $this->hash(),
        ];

        $client->request('GET', '/login/1');
        $client->request(
            'POST',
            '/invitations/send',
            [],
            [],
            [],
            json_encode($invitation)
        );
        $client->request('GET', '/users/1/invitations');
        $response = $client->getResponse();
        $invitations = json_decode($response->getContent(), true);

        $this->assertTrue(is_array($invitations));
        $this->assertTrue($this->inArray(
            $invitations,
            $invitation['message'],
            'message'
        ));
    }

    private function inArray($arr, $val, $attrName)
    {
        return !is_null(
            array_reduce(
                $arr,
                function($result, $item) use ($val, $attrName) {
                    return $item[$attrName] === $val ? $item : $result;
                }
            )
        );
    }

    private function hash() {
        return substr(hash('sha1', microtime()), 0, 8);
    }
}