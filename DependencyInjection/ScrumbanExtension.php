<?php

namespace Scrumban\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ScrumbanExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.yaml');
        
        $configuration = new TrelloConfiguration();

        $config = $this->processConfiguration($configuration, $configs);
        if (!empty($config['trello'])) {
            $this->loadTrelloConfiguration($config['trello'], $container);
        }
    }
    
    public function loadTrelloConfiguration(array $config, ContainerBuilder $container)
    {
        $container->setParameter("scrumban.trello.boards", $config['boards']);
        
        $container->getDefinition(\Scrumban\Registry\TrelloRegistry::class)->setPublic(true);
        $container->getDefinition(\Scrumban\Gateway\TrelloGateway::class)->setPublic(true);
    }
}