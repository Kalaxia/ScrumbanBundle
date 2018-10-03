<?php

namespace Scrumban\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

use Scrumban\Model\CardInterface;

class ScrumbanExtension extends Extension
{
    const TRELLO_DEFAULT_COLUMNS = [
        'todo' => [
            'name' => 'todo',
            'type' => CardInterface::CARD_TYPE_US,
        ],
        'in_progress' => [
            'name' => 'in_progress',
            'type' => CardInterface::CARD_TYPE_US,
        ],
        'to_validate' => [
            'name' => 'to_validate',
            'type' => CardInterface::CARD_TYPE_US,
        ],
        'to_deploy' => [
            'name' => 'to_deploy',
            'type' => CardInterface::CARD_TYPE_US,
        ],
        'done' => [
            'name' => 'done',
            'type' => CardInterface::CARD_TYPE_US
        ]
    ];
    
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
        $container->setParameter('scrumban.trello.boards', $config['boards']);
        $container->setParameter('scrumban.trello.columns', array_merge(self::TRELLO_DEFAULT_COLUMNS, $config['columns'] ?? []));
        
        $container->getDefinition(\Scrumban\Registry\TrelloRegistry::class)->setPublic(true);
        $container->getDefinition(\Scrumban\Gateway\TrelloGateway::class)->setPublic(true);
    }
}