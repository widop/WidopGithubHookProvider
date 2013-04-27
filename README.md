# README

[![Build Status](https://secure.travis-ci.org/widop/WidopGithubHookProvider.png)](http://travis-ci.org/widop/WidopGithubHookProvider)

The library provides a [Silex](https://github.com/fabpot/Silex) provider allowing you to execute your job on any
[Github WebHook](https://help.github.com/articles/post-receive-hooks).

## Installation

The library is distributed through [Composer](https://github.com/composer/composer). So, fist,
[install](http://getcomposer.org/doc/00-intro.md#installation-nix) it :)

Create a `composer.json` file at the root directory of you project & put the following inside:

``` json
{
    "require": {
        "widop/github-hook-provider": "*"
    }
}
```

As the library provides optional debugging, you can enable it by installing & registering the build-in Silex
[MonologServiceProvider](http://silex.sensiolabs.org/doc/providers/monolog.html):

``` json
{
    "require": {
        "widop/github-hook-provider": "*",
        "monolog/monolog": "1.*"
    }
}
```

Then, install the libraries:

``` bash
$ composer install
```

## Create your application

Now, we have everything locally, we can create the Silex application. Usually, we follow the following structure:

```
├── composer.json
├── composer.lock
├── src
│   └── ...
├── vendor
│   └── ...
└── web
    └── hook.php
```

The `web/hook.php` looks like:

``` php
<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;

$app = new Application();

// Optional dependencies
$app->register(new Silex\Provider\MonologServiceProvider(), array(/* ... */));

$app->run();
```

In this structure, the `web` directory is the vhost root directory of our application & the `hook.php` script is the
frontend controller managing our Github WebHook. So, if we create a vhost with `my-domain.com` as domain, we can put
`http://my-domain.com/hook.php` as Github Webhook.

The `src` directory should not exist yet. You can create it, we will need it in the next steps :)

## Register the provider

The Silex application (which do nothing...) is up :)

Now, we need to register & configure the Wid'op Github Hook provider which will allow us to play with Github hooks. For
that, simply update the `hook.php`:

``` php
<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use Widop\GithubHook\GithubHookProvider;

$app = new Application();
$app->register(new GithubHookProvider(), array('github_hook.trusted_ips' => array('127.0.0.1', /* ... */)));
$app->run();
```

When you go to the Github WebHook configuration accessible in your Github repo setting, you have a list of IPs which
can be trusted for Github WebHooks. The provider needs this list of IPs in order to secure the entry point. You can
obviously provide an empty array but **it is strongly not recommended!**

## Mount the controller

The Silex application with his provider is now well configured (but still do nothing...) :)

To finish the work, we need to mount the controller. One more time, update the `hook.php`:

``` php
<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use Widop\GithubHook\GithubHookProvider;

$githubHookProvider = new GithubHookProvider();

$app = new Application();
$app->register($githubHookProvider, array('github_hook.trusted_ips' => array('127.0.0.1', /* ... */)));
$app->mount('/', $githubHookProvider);
$app->run();
```

You're done! The set up is finished.

## What next?

Next? It can be interesting to write our custom stuffs which will be executed when a valid hook is received... :)

### How does it work?

As Silex itself, the provider is builded around the event dispatcher. When a hook is received & has been validated
against the IP firewall & the hook configuration, the `github_hook` event is fired & an event wrapping all informations
about the hook are propagated to all listeners/subscribers. So, we just have to write our event listener/subscriber.

You can register as many listener/subscribers you want & archive more complex use cases by playing with priorities or
event propagation...

### Write the Hook Subscriber

We recommend you to put your code, in the `src` directory:

``` php
<?php
// src/Acme/MyHookSubscriber.php

namespace Acme;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Widop\GithubHook\Event\Events;
use Widop\GithubHook\Event\HookEvent;

class MyHookSubscriber implements EventSubscriberInterface
{
    public function onHook(HookEvent $event)
    {
        $hook = $event->getHook();

        // Do your stuff...
    }

    public static function getSubscribedEvents()
    {
        return array(Events::HOOK => 'onHook');
    }
}
```

As we have added the `Acme` namespace, we need update the `composer.json` in order to autoload new classes:

``` json
{
    "autoload": {
        "psr-0": {
            "Acme": "src/"
        }
    },
    // ...
}
```

``` bash
$ composer update
```

### Register the Hook Subscriber

Our hook subscriber is defined & it does our custom stuffs. Now, we need to register it on the event dispatcher. For
that, we have two solutions: Directly in the `hook.php` or through a Silex provider.

#### Direct

Register our hook subscriber in the `hook.php`:

``` php
$app['dispatcher']->addSubscriber(new Acme\MyHookSubscriber());
```

#### Silex Provider

Create our hook provider:

``` php
<?php
// src/Acme/MyHookProvider.php

namespace Acme;

use Silex\Application;
use Silex\ServiceProviderInterface;

class MyHookProvider implements ServiceProviderInterface
{
    public function boot(Application $app)
    {
        $app['dispatcher']->addSubscriber(new MyHookSubscriber(/* Injects your own parameters/services */));
    }

    public function register(Application $app)
    {
        // Register your own services or simply let it empty :)
    }
}
```

Then, register our hook provider in the `hook.php`:

``` php
$app->register(new Acme\MyHookProvider());
```

## Contribute

We love contributors! The library is open source, if you'd like to contribute, feel free to propose a PR!

## License

The Wid'op Github Hook Silex Provider is under the MIT license. For the full copyright and license information, please
read the [LICENSE](https://github.com/widop/WidopGitubHookProvider/blob/master/LICENSE) file that was distributed
with this source code.
