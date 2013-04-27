<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Security;

use Symfony\Component\HttpFoundation\Request;

/**
 * Github hook firewall (check if the request IP is trusted).
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Firewall
{
    /** @var array */
    protected $trustedIps;

    /**
     * Creates a Github hook firewall.
     *
     * @param array $trustedIps The trusted IPs.
     */
    public function __construct(array $trustedIps)
    {
        $this->trustedIps = $trustedIps;
    }

    /**
     * Gets the trusted IPs.
     *
     * @return array The trusted IPs.
     */
    public function getTrustedIps()
    {
        return $this->trustedIps;
    }

    /**
     * Checks if the firewall trusts the http request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The http request.
     *
     * @return boolean TRUE if the firewall trusts the http request else FALSE.
     */
    public function trust(Request $request)
    {
        return in_array($request->getClientIp(), $this->trustedIps);
    }
}
