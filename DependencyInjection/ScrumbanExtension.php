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
        'ready' => [
            'name' => 'ready',
            'type' => CardInterface::CARD_TYPE_US,
            'status' => CardInterface::STATUS_READY,
        ],
        'todo' => [
            'name' => 'todo',
            'type' => CardInterface::CARD_TYPE_US,
            'status' => CardInterface::STATUS_TODO,
        ],
        'in_progress' => [
            'name' => 'in_progress',
            'type' => CardInterface::CARD_TYPE_US,
            'status' => CardInterface::STATUS_IN_PROGRESS,
        ],
        'review' => [
            'name' => 'review',
            'type' => CardInterface::CARD_TYPE_US,
            'status' => CardInterface::STATUS_REVIEW,
        ],
        'to_release' => [
            'name' => 'to_release',
            'type' => CardInterface::CARD_TYPE_US,
            'status' => CardInterface::STATUS_TO_RELEASE,
        ],
        'done' => [
            'name' => 'done',
            'type' => CardInterface::CARD_TYPE_US,
            'status' => CardInterface::STATUS_DONE,
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
        $boardManagerDefinition = $container->getDefinition('scrumban.trello_manager');
        $boardManagerDefinition->setProperty('webhookRoute', 'scrumban_trello_webhook');
        
        if (isset($config['has_plus_for_trello'])) {
            $boardManagerDefinition->setProperty('hasPlusForTrello', $config['has_plus_for_trello']);
        }
        if (isset($config['api_key'])) {
            $boardManagerDefinition->setProperty('apiKey', $config['api_key']);
        }
        if (isset($config['api_token'])) {
            $boardManagerDefinition->setProperty('apiToken', $config['api_token']);
        }
    }
}