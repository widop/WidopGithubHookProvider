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
 * Github commit.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Commit
{
    /** @var string */
    protected $id;

    /** @var boolean */
    protected $distinct;

    /** @var string */
    protected $message;

    /** @var string */
    protected $timestamp;

    /** @var string */
    protected $url;

    /** @var array */
    protected $added;

    /** @var array */
    protected $removed;

    /** @var array */
    protected $modified;

    /** @var \Widop\GithubHook\Model\User */
    protected $author;

    /** @var \Widop\GithubHook\Model\User */
    protected $commiter;

    /**
     * Creates a github commit.
     *
     * @param array $commit The commit definition.
     */
    public function __construct(array $commit)
    {
        if (isset($commit['id'])) {
            $this->id = $commit['id'];
        }

        if (isset($commit['distinct'])) {
            $this->distinct = $commit['distinct'];
        }

        if (isset($commit['message'])) {
            $this->message = $commit['message'];
        }

        if (isset($commit['timestamp'])) {
            $this->timestamp = $commit['timestamp'];
        }

        if (isset($commit['url'])) {
            $this->url = $commit['url'];
        }

        if (isset($commit['added'])) {
            $this->added = $commit['added'];
        }

        if (isset($commit['removed'])) {
            $this->removed = $commit['removed'];
        }

        if (isset($commit['modified'])) {
            $this->modified = $commit['modified'];
        }

        if (isset($commit['author'])) {
            $this->author = new User($commit['author']);
        }

        if (isset($commit['committer'])) {
            $this->committer = new User($commit['committer']);
        }
    }

    /**
     * Gets the commit sha1.
     *
     * @return string The commit sha1.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the commit distinct.
     *
     * @return boolean The commit distinct.
     */
    public function getDistinct()
    {
        return $this->distinct;
    }

    /**
     * Gets the commit message.
     *
     * @return string The commit message.
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Gets the commit timestamp.
     *
     * @return string The commit timestamp.
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Gets the commit url.
     *
     * @return string The commit url.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Gets the commit added files.
     *
     * @return array The commit added files.
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * Gets the commit removed files.
     *
     * @return array The commit removed files.
     */
    public function getRemoved()
    {
        return $this->removed;
    }

    /**
     * Gets the commit modified files.
     *
     * @return array The commit modified files.
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Gets the commit author.
     *
     * @return \Widop\GithubHook\Model\User The commit author.
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Gets the commit committer.
     *
     * @return \Widop\GithubHook\Model\User The commit committer.
     */
    public function getCommitter()
    {
        return $this->committer;
    }

    /**
     * Converts the commit to his initial representation.
     *
     * @return array The commit inital representation.
     */
    public function toArray()
    {
        return array(
            'id'        => $this->getId(),
            'distinct'  => $this->getDistinct(),
            'message'   => $this->getMessage(),
            'timestamp' => $this->getTimestamp(),
            'url'       => $this->getUrl(),
            'added'     => $this->getAdded(),
            'removed'   => $this->getRemoved(),
            'modified'  => $this->getModified(),
            'author'    => $this->getAuthor()->toArray(),
            'committer' => $this->getCommitter()->toArray(),
        );
    }
}
