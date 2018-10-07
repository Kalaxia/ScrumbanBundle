<?php

namespace Scrumban\Manager;

use Scrumban\Registry\RegistryInterface;
use Scrumban\Gateway\GatewayInterface;

use Scrumban\Utils\CardHelper;

use Scrumban\Utils\PlusForTrelloHelper;

use Scrumban\Entity\Sprint;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BoardManager
{
    /** @var RegistryInterface **/
    protected $registry;
    /** @var GatewayInterface **/
    protected $gateway;
    /** @var UserStoryManager **/
    protected $userStoryManager;
    /** @var SprintManager **/
    protected $sprintManager;
    /** @var UrlGeneratorInterface **/
    protected $router;
    /** @var string **/
    public $webhookRoute;
    /** @var bool **/
    public $hasPlusForTrello;
    /** @var string **/
    public $apiToken;
    /** @var string **/
    public $apiKey;
    
    public function __construct(
        RegistryInterface $registry,
        GatewayInterface $gateway,
        UserStoryManager $userStoryManager,
        SprintManager $sprintManager,
        UrlGeneratorInterface $router
    )
    {
        $this->registry = $registry;
        $this->gateway = $gateway;
        $this->userStoryManager = $userStoryManager;
        $this->sprintManager = $sprintManager;
        $this->router = $router;
    }
    
    public function createWebhook(string $boardId, string $callbackUrl)
    {
        return $this->gateway->createWebhook($this->apiToken, $this->apiKey, $boardId, $callbackUrl . $this->router->generate($this->webhookRoute));
    }
    
    public function sync($boardName)
    {
        if (($boardData = $this->registry->getBoard($boardName)) === null) {
            throw new \InvalidArgumentException('No board is configured for the given name');
        }
        $this->init();
        $columns = $this->gateway->getBoardColumns($boardData['id']);
        $currentSprint = $this->sprintManager->getCurrentSprint();

        foreach ($columns as $columnData) {
            yield "comment" => "Scanning column {$columnData['name']}...";
            if (($column = $this->registry->getColumn(CardHelper::slugify($columnData['name']))) === null) {
                continue;
            }
            $messages = $this->processColumnCards($columnData['id'], $column, $currentSprint);
            foreach($messages as $type => $message) {
                yield $type => $message;
            }
            yield "info" => "Column {$columnData['name']} has been synchronized";
        }
    }
    
    protected function init()
    {
        $this->registry->storeUserStories($this->userStoryManager->getAll());
    }
    
    protected function processColumnCards(string $columnId, array $column, Sprint $sprint = null)
    {
        $cards = $this->gateway->getColumnCards($columnId);
        yield "info" => count($cards) . " cards to synchronize with status {$column['status']}";
        foreach ($cards as $card) {
            $titleParts = explode('|', $card['name']);
            $extraData = isset($titleParts[1]) ? trim($titleParts[1]): '';
            
            $estimations = $this->getCardEstimations($card, $extraData);
                    
            $method =
                (($userStory = $this->registry->getUserStory($card['id'])) === null)
                ? 'createUserStory'
                : 'updateUserStory'
            ;
            $this->userStoryManager->{$method}(
                $card['id'],
                trim($titleParts[0]),
                $card['desc'],
                (!empty($extraData)) ? CardHelper::extractValue($extraData) : 0,
                $column['status'],
                $estimations['estimated'],
                $estimations['spent'],
                CardHelper::extractCreationDate($card['id']),
                CardHelper::isInCurrentSprint($column['status']) ? $sprint : null,
                $userStory
            );
        }
    }
    
    protected function getCardEstimations(array $card, string $extraData): array
    {
        if ($this->hasPlusForTrello !== true || empty($extraData)) {
            return [
                'estimated' => CardHelper::extractEstimatedTime($extraData),
                'spent' => CardHelper::extractSpentTime($extraData)
            ];
        }
        if ($card['badges']['comments'] === 0) {
            return ['estimated' => 0, 'spent' => 0];
        }
        return PlusForTrelloHelper::extractEstimations($this->gateway->getCardComments($card['id']));
    }
}