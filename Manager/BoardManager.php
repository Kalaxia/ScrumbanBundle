<?php

namespace Scrumban\Manager;

use Scrumban\Registry\RegistryInterface;
use Scrumban\Gateway\GatewayInterface;

use Scrumban\Utils\CardHelper;

use Scrumban\Utils\PlusForTrelloHelper;

use Scrumban\Entity\Sprint;

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
    /** @var bool **/
    public $hasPlusForTrello;
    
    public function __construct(RegistryInterface $registry, GatewayInterface $gateway, UserStoryManager $userStoryManager, SprintManager $sprintManager)
    {
        $this->registry = $registry;
        $this->gateway = $gateway;
        $this->userStoryManager = $userStoryManager;
        $this->sprintManager = $sprintManager;
    }
    
    public function sync($boardName)
    {
        if (($boardData = $this->registry->getBoard($boardName)) === null) {
            throw new \InvalidArgumentException('No board is configured for the given name');
        }
        $columns = $this->gateway->getBoardColumns($boardData['id']);
        $currentSprint = $this->sprintManager->getCurrentSprint();

        foreach ($columns as $columnData) {
            if (($column = $this->registry->getColumn(CardHelper::slugify($columnData['name']))) === null) {
                continue;
            }
            $this->processColumnCards($columnData['id'], $column, $currentSprint);
        }
    }
    
    protected function processColumnCards(string $columnId, array $column, Sprint $sprint = null)
    {
        foreach ($this->gateway->getColumnCards($columnId) as $card) {
            $titleParts = explode('|', $card['name']);
            $extraData = isset($titleParts[1]) ? trim($titleParts[1]): '';
            
            $estimations = $this->getCardEstimations($card, $extraData);
            $this->userStoryManager->createUserStory(
                $card['id'],
                trim($titleParts[0]),
                $card['desc'],
                (!empty($extraData)) ? CardHelper::extractValue($extraData) : 0,
                $column['status'],
                $estimations['estimated'],
                $estimations['spent'],
                CardHelper::isInCurrentSprint($column['status']) ? $sprint : null
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