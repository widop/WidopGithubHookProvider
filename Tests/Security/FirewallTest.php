<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Tests\Security;

use Widop\GithubHook\Security\Firewall;

/**
 * Github hook firewall test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class FirewallTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\GithubHook\Security\Firewall */
    protected $firewall;

    /** @var \Symfony\Component\HttpFoundation\Request */
    protected $requestMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->firewall = new Firewall(array('127.0.0.1'));
        $this->requestMock = $this->getMock('\Symfony\Component\HttpFoundation\Request');
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->firewall);
        unset($this->requestMock);
    }

    public function testTrustedIps()
    {
        $this->assertSame(array('127.0.0.1'), $this->firewall->getTrustedIps());
    }

    public function testTrustWithValidRequest()
    {
        $this->assertFalse($this->firewall->trust($this->requestMock));
    }

    public function testTrustWithInvalidRequest()
    {
        $this->requestMock
            ->expects($this->once())
            ->method('getClientIp')
            ->will($this->returnValue('127.0.0.1'));

        $this->assertTrue($this->firewall->trust($this->requestMock));
    }
}
