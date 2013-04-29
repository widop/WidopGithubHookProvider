<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook;

use Psr\Log\LogLevel;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Widop\GithubHook\Event\Events;
use Widop\GithubHook\Event\HookEvent;
use Widop\GithubHook\Exception\FirewallException;
use Widop\GithubHook\Exception\HookException;
use Widop\GithubHook\Factory\HookFactory;
use Widop\GithubHook\Security\Firewall;

/**
 * Github hook silex provider.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class GithubHookProvider implements ControllerProviderInterface, ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $provider = $this;

        $controllers->get('/', function (Application $app) use ($provider) {
            return $provider->createResponse('Invalid Grant');
        });

        $controllers->post('/', function (Application $app) use ($provider) {
            try {
                $hook = $app['github_hook.factory']->create($app['request']);

                $provider->log($app, 'Hook trigger', LogLevel::INFO, array('hook' => $hook->toArray()));
                $app['dispatcher']->dispatch(Events::HOOK, new HookEvent($hook));

                return $provider->createResponse('Ok');
            } catch (FirewallException $e) {
                return $provider->failure('Invalid Grant', $e, $app);
            } catch (HookException $e) {
                return $provider->failure('Invalid Request', $e, $app);
            } catch (\Exception $e) {
                return $provider->failure('Error...', $e, $app);
            }
        });

        return $controllers;
    }

    /**
     * {@inheritdoc}
     */
    public function register(Application $app)
    {
        $app['github_hook.firewall'] = $app->share(function () use ($app) {
            return new Firewall($app['github_hook.trusted_ips'], $app['github_hook.trusted_cidrs']);
        });

        $app['github_hook.factory'] = $app->share(function () use ($app) {
            return new HookFactory($app['github_hook.firewall']);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Application $app)
    {

    }

    /**
     * Github hook failure (logs the hook error & create the JSON reponse).
     *
     * @param string             $state The error state.
     * @param \Exception         $e     The exception.
     * @param \Silex\Application $app   The silex application.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse The JSON response.
     */
    public function failure($state, \Exception $e, Application $app)
    {
        $this->log($app, sprintf('%s - %s', $state, $e->getMessage()), LogLevel::ERROR);

        return $this->createResponse($state);
    }

    /**
     * Logs the message/context on the given level only if the logger exists.
     *
     * @param \Silex\Application $app     The silex application.
     * @param string             $message The log message.
     * @param string             $level   The log level.
     * @param array              $context The log context.
     */
    public function log(Application $app, $message, $level, array $context = array())
    {
        if ($app->offsetExists('monolog')) {
            $app['monolog']->log($level, sprintf('%s - %s', 'Github Hook', $message), $context);
        }
    }

    /**
     * Creates a JSON response according to a state.
     *
     * @param string $state The state.
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse The JSON response.
     */
    public function createResponse($state)
    {
        return new JsonResponse(array('state' => $state));
    }
}
