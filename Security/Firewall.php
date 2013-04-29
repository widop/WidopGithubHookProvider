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

    /** @var array */
    protected $trustedCidrs;

    /**
     * Creates a Github hook firewall.
     *
     * @param array $trustedIps   The trusted IPs.
     * @param array $trustedCidrs The trusted CIDRs.
     */
    public function __construct(array $trustedIps = array(), array $trustedCidrs = array())
    {
        $this->trustedIps = $trustedIps;
        $this->trustedCidrs = $trustedCidrs;
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
     * Gets the trusted CIDRs.
     *
     * @return array The trusted CIDRs.
     */
    public function getTrustedCidrs()
    {
        return $this->trustedCidrs;
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
        $clientIp = $request->getClientIp();

        if (in_array($clientIp, $this->getTrustedIps())) {
            return true;
        }

        foreach ($this->getTrustedCidrs() as $trustedCidr) {
            if ($this->matchCidr($clientIp, $trustedCidr)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the IP matcheds the CIDR.
     *
     * @param string $ip   The IP.
     * @param string $cidr The CIDR.
     *
     * @return boolean TRUE if the IP matches the CIDR else FALSE.
     */
    protected function matchCidr($ip, $cidr)
    {
        list ($subnet, $bits) = explode('/', $cidr);

        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;

        return ($ip & $mask) == $subnet;
    }
}
