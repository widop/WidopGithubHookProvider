<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Factory;

use Widop\GithubHook\Exception\FirewallException;
use Widop\GithubHook\Exception\HookException;
use Widop\GithubHook\Model\Hook;
use Widop\GithubHook\Security\Firewall;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Hook factory.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class HookFactory
{
    /** @var \Widop\GithubHook\Security\Firewall */
    protected $firewall;

    /** @var \Symfony\Component\Config\Definition\Processor */
    protected $configProcessor;

    /** @var \Widop\GithubHook\Factory\HookConfiguration */
    protected $hookConfiguration;

    /**
     * Creates a Github hook factory.
     *
     * @param \Widop\GithubHook\Security\Firewall $firewall The configured Github hook firewall.
     */
    public function __construct(Firewall $firewall)
    {
        $this->firewall = $firewall;
        $this->configProcessor = new Processor();
        $this->hookConfiguration = new HookConfiguration();
    }

    /**
     * Tries to create a Github hook according to an http request.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request The http request.
     *
     * @throws \Widop\GithubHook\Exception\FirewallException If the request IP is not trusted.
     * @throws \Widop\GithubHook\Exception\HookException     If the hook is not valid.
     *
     * @return \Fridge\GithubHookBundle\Model\Hook The Github hook.
     */
    public function create(Request $request)
    {
        if (!$this->firewall->trust($request)) {
            throw FirewallException::invalidIp($request->getClientIp(), $this->firewall->getTrustedIps());
        }

        $payload = json_decode($request->request->get('payload'), true);

        try {
            $hook = $this->configProcessor->processConfiguration($this->hookConfiguration, array($payload));
        } catch (InvalidConfigurationException $e) {
            throw HookException::invalidRequest($e->getMessage());
        }

        return new Hook($hook);
    }
}
