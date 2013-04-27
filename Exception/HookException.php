<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Exception;

/**
 * Github hook exception.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class HookException extends Exception
{
    /**
     * Gets the "INVALID REQUEST" exception.
     *
     * @return \Widop\GithubHook\Exception\HookException The "INVALID REQUEST" exception.
     */
    public static function invalidRequest()
    {
        return new self('The Github hook request is not valid.');
    }
}
