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

use Monolog\Logger;
use Silex\WebTestCase;

/**
 * Github hook logger provider test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class GithubHookLoggerProviderTest extends WebTestCase
{
    /**
     * {@inheritdoc}
     */
    public function createApplication()
    {
        return require __DIR__.'/Fixtures/App/logger.php';
    }

    /**
     * {@inheritdoc}
     */
    public function getActualOutput()
    {
        // FIXME
    }

    public function testPostRequestWithInvalidIp()
    {
        $client = $this->createClient(array('REMOTE_ADDR' => '192.168.0.1'));
        $client->request('POST', '/', array('payload' => json_encode(require __DIR__.'/Fixtures/payload.php')));

        $records = $this->app['monolog.handler']->getRecords();

        $this->assertCount(5, $records);

        $this->assertSame('> POST /', $records[2]['message']);
        $this->assertSame(
            'Github Hook - Invalid Grant - The HTTP request IP is not allowed. (IP: 192.168.0.1, Trusted IP(s): 127.0.0.1)',
            $records[3]['message']
        );
        $this->assertSame(Logger::ERROR, $records[3]['level']);
        $this->assertEmpty($records[3]['context']);
        $this->assertSame('< 200', $records[4]['message']);
    }

    public function testPostRequestWithInvalidPayload()
    {
        $payload = require __DIR__.'/Fixtures/payload.php';
        unset($payload['before']);

        $client = $this->createClient(array('REMOTE_ADDR' => '127.0.0.1'));
        $client->request('POST', '/', array('payload' => json_encode($payload)));

        $records = $this->app['monolog.handler']->getRecords();

        $this->assertCount(5, $records);

        $this->assertSame('> POST /', $records[2]['message']);
        $this->assertSame(
            'Github Hook - Invalid Request - The Github hook request is not valid.',
            $records[3]['message']
        );
        $this->assertSame(Logger::ERROR, $records[3]['level']);
        $this->assertEmpty($records[3]['context']);
        $this->assertSame('< 200', $records[4]['message']);
    }

    public function testValidPostRequest()
    {
        $payload = require __DIR__.'/Fixtures/payload.php';

        $client = $this->createClient(array('REMOTE_ADDR' => '127.0.0.1'));
        $client->request('POST', '/', array('payload' => json_encode($payload)));

        $records = $this->app['monolog.handler']->getRecords();

        $this->assertCount(5, $records);

        $this->assertSame('> POST /', $records[2]['message']);
        $this->assertSame(
            'Github Hook - Hook trigger',
            $records[3]['message']
        );
        $this->assertSame(Logger::INFO, $records[3]['level']);
        $this->assertSame(array('hook' => $payload), $records[3]['context']);
        $this->assertSame('< 200', $records[4]['message']);
    }
}
