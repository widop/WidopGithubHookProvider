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
 * Github repository.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class Repository
{
    /** @var integer */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $url;

    /** @var string */
    protected $description;

    /** @var string */
    protected $homepage;

    /** @var integer */
    protected $watchers;

    /** @var integer */
    protected $stargazers;

    /** @var integer */
    protected $forks;

    /** @var boolean */
    protected $fork;

    /** @var integer */
    protected $size;

    /** @var boolean */
    protected $private;

    /** @var \Widop\GithubHook\Model\User */
    protected $owner;

    /** @var integer */
    protected $openIssues;

    /** @var boolean */
    protected $hasIssues;

    /** @vra boolean */
    protected $hasDownloads;

    /** @var boolean */
    protected $hasWiki;

    /** @var string */
    protected $language;

    /** @var integer */
    protected $createdAt;

    /** @var integer */
    protected $pushedAt;

    /** @var string */
    protected $masterBranch;

    /** @var string */
    protected $organization;

    /**
     * Creates a github repository.
     *
     * @param array $repository The repository definition.
     */
    public function __construct(array $repository)
    {
        if (isset($repository['id'])) {
            $this->id = $repository['id'];
        }

        if (isset($repository['name'])) {
            $this->name = $repository['name'];
        }

        if (isset($repository['url'])) {
            $this->url = $repository['url'];
        }

        if (isset($repository['description'])) {
            $this->description = $repository['description'];
        }

        if (isset($repository['homepage'])) {
            $this->homepage = $repository['homepage'];
        }

        if (isset($repository['watchers'])) {
            $this->watchers = $repository['watchers'];
        }

        if (isset($repository['stargazers'])) {
            $this->stargazers = $repository['stargazers'];
        }

        if (isset($repository['forks'])) {
            $this->forks = $repository['forks'];
        }

        if (isset($repository['fork'])) {
            $this->fork = $repository['fork'];
        }

        if (isset($repository['size'])) {
            $this->size = $repository['size'];
        }

        if (isset($repository['private'])) {
            $this->private = $repository['private'];
        }

        if (isset($repository['open_issues'])) {
            $this->openIssues = $repository['open_issues'];
        }

        if (isset($repository['has_issues'])) {
            $this->hasIssues = $repository['has_issues'];
        }

        if (isset($repository['has_downloads'])) {
            $this->hasDownloads = $repository['has_downloads'];
        }

        if (isset($repository['has_wiki'])) {
            $this->hasWiki = $repository['has_wiki'];
        }

        if (isset($repository['language'])) {
            $this->language = $repository['language'];
        }

        if (isset($repository['created_at'])) {
            $this->createdAt = $repository['created_at'];
        }

        if (isset($repository['pushed_at'])) {
            $this->pushedAt = $repository['pushed_at'];
        }

        if (isset($repository['master_branch'])) {
            $this->masterBranch = $repository['master_branch'];
        }

        if (isset($repository['organization'])) {
            $this->organization = $repository['organization'];
        }

        if (isset($repository['owner'])) {
            $this->owner = new User($repository['owner']);
        }
    }

    /**
     * Gets the repository identifier.
     *
     * @return integer The repository identifier.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the repository name.
     *
     * @return string The repository name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the repository url.
     *
     * @return string The repository url.
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Gets the repository description.
     *
     * @return string The repository description.
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Gets the repository homepage.
     *
     * @return string The repository homepage.
     */
    public function getHomepage()
    {
        return $this->homepage;
    }

    /**
     * Gets the number of watchers of the repository.
     *
     * @return integer The number of watchers of the repository.
     */
    public function getWatchers()
    {
        return $this->watchers;
    }

    /**
     * Gets the number of stargazers of the repository.
     *
     * @return string The number of stargazers of the repository.
     */
    public function getStargazers()
    {
        return $this->stargazers;
    }

    /**
     * Gets the number of forks of the repository.
     *
     * @return integer The number of forks of the repository.
     */
    public function getForks()
    {
        return $this->forks;
    }

    /**
     * Gets the repository fork flag.
     *
     * @return boolean The repository fork flag.
     */
    public function getFork()
    {
        return $this->fork;
    }

    /**
     * Gets the repository size.
     *
     * @return integer The repository size.
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Wether or not the repository is private.
     *
     * @return boolean TRUE if the repository is private else FALSE.
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Gets the repository owner.
     *
     * @return \Widop\GithubHook\Model\User The repository owner.
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Gets the number of open issues of the repository.
     *
     * @return integer The number of open issues of the repository.
     */
    public function getOpenIssues()
    {
        return $this->openIssues;
    }

    /**
     * Gets the issue flag.
     *
     * @return boolean The issue flag.
     */
    public function getHasIssues()
    {
        return $this->hasIssues;
    }

    /**
     * Gets the download flag.
     *
     * @return boolean The download flag.
     */
    public function getHasDownloads()
    {
        return $this->hasDownloads;
    }

    /**
     * Gets the wiki flag.
     *
     * @return boolean The wiki flag.
     */
    public function getHasWiki()
    {
        return $this->hasWiki;
    }

    /**
     * Gets the repository language.
     *
     * @return string The repository language.
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Gets the repository date creation (timestamp).
     *
     * @return integer The repository date creation (timestamp).
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Gets the repository pushed date (timestamp).
     *
     * @return integer The repository pushed date.
     */
    public function getPushedAt()
    {
        return $this->pushedAt;
    }

    /**
     * Gets the master branch name.
     *
     * @return string The master branch name.
     */
    public function getMasterBranch()
    {
        return $this->masterBranch;
    }

    /**
     * Gets the organization.
     *
     * @return string The organization.
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Converts the repository to his initial representation.
     *
     * @return array The repository initial representation.
     */
    public function toArray()
    {
        return array(
            'id'            => $this->getId(),
            'name'          => $this->getName(),
            'url'           => $this->getUrl(),
            'description'   => $this->getDescription(),
            'homepage'      => $this->getHomepage(),
            'watchers'      => $this->getWatchers(),
            'stargazers'    => $this->getStargazers(),
            'forks'         => $this->getForks(),
            'fork'          => $this->getFork(),
            'size'          => $this->getSize(),
            'private'       => $this->getPrivate(),
            'open_issues'   => $this->getOpenIssues(),
            'has_issues'    => $this->getHasIssues(),
            'has_downloads' => $this->getHasDownloads(),
            'has_wiki'      => $this->getHasWiki(),
            'language'      => $this->getLanguage(),
            'created_at'    => $this->getCreatedAt(),
            'pushed_at'     => $this->getPushedAt(),
            'master_branch' => $this->getMasterBranch(),
            'organization'  => $this->getOrganization(),
            'owner'         => $this->getOwner()->toArray(),
        );
    }
}
