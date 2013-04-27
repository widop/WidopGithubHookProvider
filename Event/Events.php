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

/**
 * Github hook events.
 *
 * @codeCoverageIgnore
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Events
{
    /** @const string The Github hook event */
    const HOOK = 'github_hook';

    /*
     * Disabled constructor.
     */
    final private function __construct()
    {

    }
}
