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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Github hook configuration.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class HookConfiguration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder
            ->root('hook')
            ->append($this->getCommitNode('commits', true))
            ->append($this->getCommitNode('head_commit'))
            ->append($this->getRepositoryNode())
            ->append($this->getUserNode('pusher'))
            ->children()
                ->scalarNode('ref')
                    ->isRequired()
                ->end()
                ->scalarNode('after')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('before')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('created')
                    ->isRequired()
                ->end()
                ->booleanNode('deleted')
                    ->isRequired()
                ->end()
                ->booleanNode('forced')
                    ->isRequired()
                ->end()
                ->scalarNode('compare')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end();

        return $treeBuilder;
    }

    /**
     * Gets a hook commit node definition.
     *
     * @param string  $name       The root node name.
     * @param boolean $prototyped TRUE if the node is prototyped else FALSE.
     *
     * @return \Symfony\Component\Config\Definition\NodeInterface A hook commit node definition.
     */
    protected function getCommitNode($name, $prototyped = false)
    {
        $builder = new TreeBuilder();
        $node = $prototypedNode = $builder->root($name);

        if ($prototyped) {
            $prototypedNode = $node
                ->isRequired()
                ->prototype('array');
        }

        $prototypedNode
            ->append($this->getUserNode('author'))
            ->append($this->getUserNode('committer'))
            ->children()
                ->scalarNode('id')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->booleanNode('distinct')
                    ->isRequired()
                ->end()
                ->scalarNode('message')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('timestamp')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('url')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('added')
                    ->isRequired()
                    ->prototype('scalar')
                        ->cannotBeEmpty()
                    ->end()
                ->end()
                ->arrayNode('removed')
                    ->isRequired()
                    ->prototype('scalar')
                        ->cannotBeEmpty()
                    ->end()
                ->end()
                ->arrayNode('modified')
                    ->isRequired()
                    ->prototype('scalar')
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end();

        return $node;
    }

    /**
     * Gets a hook repository node definition.
     *
     * @return \Symfony\Component\Config\Definition\NodeInterface A hook repository node definition.
     */
    protected function getRepositoryNode()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('repository');

        $node
            ->append($this->getUserNode('owner'))
            ->children()
                ->integerNode('id')
                    ->isRequired()
                ->end()
                ->scalarNode('name')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('url')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('description')->end()
                ->scalarNode('homepage')->end()
                ->integerNode('watchers')
                    ->isRequired()
                ->end()
                ->integerNode('stargazers')
                    ->isRequired()
                ->end()
                ->integerNode('forks')
                    ->isRequired()
                ->end()
                ->booleanNode('fork')
                    ->isRequired()
                ->end()
                ->integerNode('size')
                    ->isRequired()
                ->end()
                ->booleanNode('private')
                    ->isRequired()
                ->end()
                ->integerNode('open_issues')
                    ->isRequired()
                ->end()
                ->booleanNode('has_issues')
                    ->isRequired()
                ->end()
                ->booleanNode('has_downloads')
                    ->isRequired()
                ->end()
                ->booleanNode('has_wiki')
                    ->isRequired()
                ->end()
                ->scalarNode('language')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->integerNode('created_at')
                    ->isRequired()
                ->end()
                ->integerNode('pushed_at')
                    ->isRequired()
                ->end()
                ->scalarNode('master_branch')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('organization')->end()
            ->end();

        return $node;
    }

    /**
     * Gets a hook user node definition.
     *
     * @param string $name The root node name.
     *
     * @return \Symfony\Component\Config\Definition\NodeInterface A hook user node definition.
     */
    protected function getUserNode($name)
    {
        $builder = new TreeBuilder();
        $node = $builder->root($name);

        $node
            ->isRequired()
            ->children()
                ->scalarNode('name')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('email')->end()
                ->scalarNode('username')->end()
            ->end();

        return $node;
    }
}
