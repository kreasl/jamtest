<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    const STATUS_CANCELED = 20;

    /**
     * @dataProvider smokeUrlProvider
     */
    public function testSmokeApi($url)
    {
        $client = self::createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function smokeUrlProvider()
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
        $invitation = [
            'receiverId' => 2,
            'message' => 'Test send invitation ' . $this->hash(),
        ];

        $client = self::createClient();

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
            ['message' => $invitation['message']]
        ));
    }

    public function testReceiveInvitation() {
        $invitation = [
            'receiverId' => 2,
            'message' => 'Test receive invitation ' . $this->hash(),
        ];

        $client = self::createClient();

        $client->request('GET', '/login/1');
        $client->request(
            'POST',
            '/invitations/send',
            [],
            [],
            [],
            json_encode($invitation)
        );
        $client->request('GET', '/logout');
        $client->request('GET', '/login/2');
        $client->request('GET', '/users/2/invitations/received');

        $response = $client->getResponse();
        $invitations = json_decode($response->getContent(), true);

        $this->assertTrue(is_array($invitations));
        $this->assertTrue($this->inArray(
            $invitations,
            ['message' => $invitation['message']]
        ));
    }

    public function testCancelSendingInvitation() {
        $invitation = [
            'receiverId' => 2,
            'message' => 'Test send invitation ' . $this->hash(),
        ];

        $client = self::createClient();

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
            ['message' => $invitation['message']]
        ));

        $savedInvitationId = $this->getFromArray(
            $invitations,
            ['message' => $invitation['message']]
        )['id'];

        $client->request('GET', '/invitations/' . $savedInvitationId . '/cancel');

        var_dump('/invitations/' . $savedInvitationId . '/cancel');

        $client->request('GET', '/users/1/invitations/sent');

        $this->assertTrue(is_array($invitations));
        $this->assertTrue($this->inArray(
            $invitations,
            ['id' => $savedInvitationId]
        ));

        $canceledInvitation = $this->getFromArray(
            $invitations,
            ['id' => $savedInvitationId]
        );

        // I've used an in-place constant here because there's a Symfony recomendation to hardcode constants,
        // instead of load/generate them with Api functionality
        // That allows test to catch refactorings and ensure they went well
        $this->assertTrue($canceledInvitation['status'] == self::STATUS_CANCELED);
    }

    public function testAcceptInvitation() {}

    public function testDeclineInvitation() {}

    private function inArray($arr, $conditions)
    {
        return !is_null(
            array_reduce(
                $arr,
                function($result, $item) use ($conditions) {
                    foreach ($conditions as $attr => $val) {
                        if ($item[$attr] !== $val) {
                            return $result;
                        }
                    }

                    return $item;
                }
            )
        );
    }

    private function getFromArray($arr, $conditions) {
        return array_values(array_filter(
            $arr,
            function($item) use ($conditions) {
                foreach ($conditions as $attr => $val) {
                    if ($item[$attr] !== $val) {
                        return false;
                    }
                }

                return true;
            }
        ))[0];
    }

    private function hash() {
        return substr(hash('sha1', microtime()), 0, 8);
    }
}