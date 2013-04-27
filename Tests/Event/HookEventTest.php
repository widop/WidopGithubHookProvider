<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Tests\Event;

use Widop\GithubHook\Event\Events;
use Widop\GithubHook\Event\HookEvent;

/**
 * Github hook event test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class HookEventTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Widop\GithubHook\Event\HookEvent */
    protected $hookEvent;

    /** @var \Widop\GithubHook\Model\Hook */
    protected $hookMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->hookMock = $this->getMockBuilder('Widop\GithubHook\Model\Hook')
            ->disableOriginalConstructor()
            ->getMock();

        $this->hookEvent = new HookEvent($this->hookMock);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->hookEvent);
        unset($this->hookMock);
    }

    public function testHook()
    {
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\Event', $this->hookEvent);
        $this->assertSame($this->hookMock, $this->hookEvent->getHook());
    }

    public function testName()
    {
        $this->assertSame(Events::HOOK, $this->hookEvent->getName());
    }
}
