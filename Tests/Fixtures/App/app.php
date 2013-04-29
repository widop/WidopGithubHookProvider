<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__.'/../../../vendor/autoload.php';

use Silex\Application;
use Widop\GithubHook\GithubHookProvider;

$githubHookProvider = new GithubHookProvider();
$githubHookConfiguration = array(
    'github_hook.trusted_ips'   => array('127.0.0.1'),
    'github_hook.trusted_cidrs' => array(),
);

$app = new Application();
$app->register($githubHookProvider, $githubHookConfiguration);
$app->mount('/', $githubHookProvider);
$app->run();

return $app;
