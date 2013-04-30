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
 * Github hook.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Hook
{
    /** @var string */
    protected $baseRef;

    /** @var string */
    protected $ref;

    /** @var string */
    protected $after;

    /** @var string */
    protected $before;

    /** @var boolean */
    protected $created;

    /** @var boolean */
    protected $deleted;

    /** @var boolean */
    protected $forced;

    /** @var string */
    protected $compare;

    /** @var array */
    protected $commits;

    /** @var \Widop\GithubHook\Model\Commit */
    protected $headCommit;

    /** @var \Widop\GithubHook\Model\Repository */
    protected $repository;

    /** @var \Widop\GithubHook\Model\User */
    protected $pusher;

    /**
     * Creates a github hook.
     *
     * @param array $hook The hook definition.
     */
    public function __construct(array $hook)
    {
        if (isset($hook['base_ref'])) {
            $this->baseRef = $hook['base_ref'];
        }

        if (isset($hook['ref'])) {
            $this->ref = $hook['ref'];
        }

        if (isset($hook['after'])) {
            $this->after = $hook['after'];
        }

        if (isset($hook['before'])) {
            $this->before = $hook['before'];
        }

        if (isset($hook['created'])) {
            $this->created = $hook['created'];
        }

        if (isset($hook['deleted'])) {
            $this->deleted = $hook['deleted'];
        }

        if (isset($hook['forced'])) {
            $this->forced = $hook['forced'];
        }

        if (isset($hook['compare'])) {
            $this->compare = $hook['compare'];
        }

        $this->commits = array();

        if (isset($hook['commits'])) {
            foreach ($hook['commits'] as $commit) {
                $this->commits[] = new Commit($commit);
            }
        }

        if (isset($hook['head_commit'])) {
            $this->headCommit = new Commit($hook['head_commit']);
        }

        if (isset($hook['repository'])) {
            $this->repository = new Repository($hook['repository']);
        }

        if (isset($hook['pusher'])) {
            $this->pusher = new User($hook['pusher']);
        }
    }

    /**
     * Gets the base ref.
     *
     * @return string The base ref.
     */
    public function getBaseRef()
    {
        return $this->baseRef;
    }

    /**
     * Gets the ref sha1.
     *
     * @return string The ref sha1.
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Gets the sha1 of the commit after this hook commit.
     *
     * @return string The after sha1.
     */
    public function getAfter()
    {
        return $this->after;
    }

    /**
     * Gets the sha1 of the commit before this hook commit.
     *
     * @return string The before sha1.
     */
    public function getBefore()
    {
        return $this->before;
    }

    /**
     * Gets the created flag.
     *
     * @return boolean The created flag.
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Gets the deleted flag.
     *
     * @return boolean The deleted flag.
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Gets the forced flag.
     *
     * @return boolean The forced flag.
     */
    public function getForced()
    {
        return $this->forced;
    }

    /**
     * Gets the compare URL.
     *
     * @return string The compare URL.
     */
    public function getCompare()
    {
        return $this->compare;
    }

    /**
     * Gets the commits.
     *
     * @return array The commits.
     */
    public function getCommits()
    {
        return $this->commits;
    }

    /**
     * Gets the head commit.
     *
     * @return \Widop\GithubHook\Model\Commit The head commit.
     */
    public function getHeadCommit()
    {
        return $this->headCommit;
    }

    /**
     * Gets the repository.
     *
     * @return \Widop\GithubHook\Model\Repository The repository.
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Gets the pusher.
     *
     * @return \Widop\GithubHook\Model\User The pusher.
     */
    public function getPusher()
    {
        return $this->pusher;
    }

    /**
     * Converts the hook to his initial representation.
     *
     * @return array The initial hook representation.
     */
    public function toArray()
    {
        return array(
            'base_ref'    => $this->getBaseRef(),
            'ref'         => $this->getRef(),
            'after'       => $this->getAfter(),
            'before'      => $this->getBefore(),
            'created'     => $this->getCreated(),
            'deleted'     => $this->getDeleted(),
            'forced'      => $this->getForced(),
            'compare'     => $this->getCompare(),
            'commits'     => array_map(function ($commit) { return $commit->toArray(); }, $this->getCommits()),
            'head_commit' => $this->getHeadCommit()->toArray(),
            'repository'  => $this->getRepository()->toArray(),
            'pusher'      => $this->getPusher()->toArray(),
        );
    }
}
