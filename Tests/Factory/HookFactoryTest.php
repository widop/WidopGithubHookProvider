<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Tests\Model;

use Symfony\Component\HttpFoundation\Request;
use Widop\GithubHook\Factory\HookFactory;
use Widop\GithubHook\Security\Firewall;

/**
 * Hook factory test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class HookFactoryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\GithubHook\Model\HookFactory */
    protected $hookFactory;

    /** @var \Widop\GithubHook\Security\Firewall */
    protected $firewall;

    /** @var \Symfony\Component\HttpFoundation\Request */
    protected $request;

    /** @var array */
    protected $payload;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->firewall = new Firewall(array('127.0.0.1'));
        $this->hookFactory = new HookFactory($this->firewall);

        $this->request = new Request();
        $this->request->server->set('REMOTE_ADDR', '127.0.0.1');
        $this->payload = require __DIR__.'/../Fixtures/payload.php';
        $this->request->request->set('payload', json_encode($this->payload));
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->hookFactory);
        unset($this->firewall);
        unset($this->request);
        unset($this->payload);
    }

    public function testCreateWithValidIp()
    {
        $hook = $this->hookFactory->create($this->request);

        $this->assertInstanceOf('Widop\GithubHook\Model\Hook', $hook);
        $this->assertSame($this->payload, $hook->toArray());
    }

    /**
     * @expectedException \Widop\GithubHook\Exception\FirewallException
     */
    public function testCreateWithInvalidIp()
    {
        $this->request->server->set('REMOTE_ADDR', '192.168.0.1');

        $this->hookFactory->create($this->request);
    }

    /**
     * @expectedException \Widop\GithubHook\Exception\HookException
     */
    public function testCreateWithoutPayload()
    {
        $this->request->request->remove('payload');

        $this->hookFactory->create($this->request);
    }

    /**
     * @expectedException \Widop\GithubHook\Exception\HookException
     */
    public function testCreateWithInvalidPayload()
    {
        $payload = $this->payload;
        unset($payload['before']);

        $this->request->request->set('payload', json_encode($payload));

        $this->hookFactory->create($this->request);
    }

    public function testCreateWithNullCommitHeader()
    {
        $payload = $this->payload;
        $payload['head_commit'] = null;

        $this->request->request->set('payload', json_encode($payload));

        $hook = $this->hookFactory->create($this->request);

        $payload['head_commit'] = Array (
            'id'        => null,
            'distinct'  => true,
            'message'   => null,
            'timestamp' => null,
            'url'       => null,
            'added'     => array(),
            'removed'   => array(),
            'modified'  => array(),
            'author'    => array(
                'name'     => null,
                'email'    => null,
                'username' => null,
            ),
            'committer' => array(
                'name'     => null,
                'email'    => null,
                'username' => null,
            ),
        );

        $this->assertSame($payload, $hook->toArray());
    }
}
