<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Tests;

use Silex\WebTestCase;

/**
 * Github hook provider test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class GithubHookProviderTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    public function createApplication()
    {
        return require __DIR__.'/Fixtures/App/app.php';
    }

    /**
     * {@inheritdoc}
     */
    public function getActualOutput()
    {
        // FIXME
    }

    public function testGetRequest()
    {
        $client = $this->createClient();
        $client->request('GET', '/');

        $response = $client->getResponse();

        $this->assertTrue($response->isOk());
        $this->assertSame(json_encode(array('state' => 'Invalid Grant')), $response->getContent());
    }

    public function testPostRequestWithInvalidIp()
    {
        $client = $this->createClient(array('REMOTE_ADDR' => '192.168.0.1'));
        $client->request('POST', '/', array('payload' => json_encode(require __DIR__.'/Fixtures/payload.php')));

        $response = $client->getResponse();

        $this->assertTrue($response->isOk());
        $this->assertSame(json_encode(array('state' => 'Invalid Grant')), $response->getContent());
    }

    public function testPostRequestWithInvalidPayload()
    {
        $payload = require __DIR__.'/Fixtures/payload.php';
        unset($payload['before']);

        $client = $this->createClient(array('REMOTE_ADDR' => '127.0.0.1'));
        $client->request('POST', '/', array('payload' => json_encode($payload)));

        $response = $client->getResponse();

        $this->assertTrue($response->isOk());
        $this->assertSame(json_encode(array('state' => 'Invalid Request')), $response->getContent());
    }

    public function testValidPostRequest()
    {
        $client = $this->createClient(array('REMOTE_ADDR' => '127.0.0.1'));
        $client->request('POST', '/', array('payload' => json_encode(require __DIR__.'/Fixtures/payload.php')));

        $response = $client->getResponse();

        $this->assertTrue($response->isOk());
        $this->assertSame(json_encode(array('state' => 'Ok')), $response->getContent());
    }
}
