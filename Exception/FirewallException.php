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
 * Github hook firewall exception.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class FirewallException extends Exception
{
    /**
     * Gets the "INVALID IP" exception.
     *
     * @param string $clientIp   The client IP.
     * @param array  $trustedIps The trusted IPs.
     *
     * @return \Widop\GithubHook\Exception\FirewallException The "INVALID IP" exception.
     */
    public static function invalidIp($clientIp, array $trustedIps)
    {
        return new self(sprintf(
            'The HTTP request IP is not allowed. (IP: %s, Trusted IP(s): %s)',
            $clientIp,
            implode(', ', $trustedIps)
        ));
    }
}
