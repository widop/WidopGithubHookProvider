<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Event;

use Widop\GithubHook\Model\Hook;
use Symfony\Component\EventDispatcher\Event;

/**
 * Github hook event.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class HookEvent extends Event
{
    /** @var \Widop\GithubHook\Model\Hook */
    protected $hook;

    /**
     * Creates a github hook event.
     *
     * @param \Widop\GithubHook\Model\Hook $hook The github hook.
     */
    public function __construct(Hook $hook)
    {
        $this->setName(Events::HOOK);

        $this->hook = $hook;
    }

    /**
     * Gets the github hook.
     *
     * @return \Widop\GithubHook\Model\Hook The github hook.
     */
    public function getHook()
    {
        return $this->hook;
    }
}
