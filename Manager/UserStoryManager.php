<?php

namespace Scrumban\Manager;

use Scrumban\Entity\UserStory;
use Scrumban\Entity\Sprint;

use Doctrine\Common\Persistence\ObjectManager;

use Scrumban\Event\UserStoryCreationEvent;
use Scrumban\Event\UserStoryUpdateEvent;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class UserStoryManager
{
    /** @var ObjectManager **/
    private $om;
    /** @var EventDispatcherInterface **/
    private $eventDispatcher;
    
    public function __construct(ObjectManager $om, EventDispatcherInterface $eventDispatcher)
    {
        $this->om = $om;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    public function createUserStory(string $id, string $title, string $description, string $value, string $status, float $estimatedTime, float $spentTime, Sprint $sprint = null): UserStory
    {
        $userStory =
            (new UserStory())
            ->setId($id)
            ->setTitle($title)
            ->setDescription($description)
            ->setValue($value)
            ->setStatus($status)
            ->setEstimatedTime($estimatedTime)
            ->setSpentTime($spentTime)
        ;
        if ($sprint !== null) {
            $userStory->setSprint($sprint);
        }
        $this->om->persist($userStory);
        $this->om->flush();
        $this->eventDispatcher->dispatch(UserStoryCreationEvent::NAME, new UserStoryCreationEvent($userStory));
        return $userStory;
    }
    
    public function updateUserStory(string $id, string $title, string $description, string $value, string $status, float $estimatedTime, float $spentTime, Sprint $sprint = null, UserStory $userStory = null)
    {
        $userStory
            ->setTitle($title)
            ->setDescription($description)
            ->setValue($value)
            ->setStatus($status)
            ->setEstimatedTime($estimatedTime)
            ->setSpentTime($spentTime)
        ;
        if ($sprint !== null) {
            $userStory->setSprint($sprint);
        }
        $this->om->flush();
        $this->eventDispatcher->dispatch(UserStoryUpdateEvent::NAME, new UserStoryUpdateEvent($userStory));
    }
    
    public function getAll(): array
    {
        return $this->om->getRepository(UserStory::class)->findAll();
    }
}