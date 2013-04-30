<?php

/*
 * This file is part of the Wid'op package.
 *
 * (c) Wid'op <contact@widop.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Widop\GithubHook\Model;

/**
 * Github user.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class User
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $email;

    /** @var string */
    protected $username;

    /**
     * Creates a github user.
     *
     * @param array $user The user definition.
     */
    public function __construct(array $user)
    {
        if (isset($user['name'])) {
            $this->name = $user['name'];
        }

        if (isset($user['email'])) {
            $this->email = $user['email'];
        }

        if (isset($user['username'])) {
            $this->username = $user['username'];
        }
    }

    /**
     * Gets the user name.
     *
     * @return string The user name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the user email.
     *
     * @return string The user email.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Gets the user username.
     *
     * @return string The user username.
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Converts the user to his initial representation.
     *
     * @return array The user initial representation.
     */
    public function toArray()
    {
        return array(
            'name'     => $this->getName(),
            'email'    => $this->getEmail(),
            'username' => $this->getUsername(),
        );
    }
}
