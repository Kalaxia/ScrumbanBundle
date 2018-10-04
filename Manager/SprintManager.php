<?php

namespace Scrumban\Manager;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Scrumban\Event\SprintCreationEvent;

use Scrumban\Entity\Sprint;

class SprintManager
{
    /** @var ObjectManager **/
    protected $om;
    /** @var EventDispatcherInterface **/
    protected $eventDispatcher;
    
    public function __construct(ObjectManager $om, EventDispatcherInterface $eventDispatcher)
    {
        $this->om = $om;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    public function getCurrentSprint(): ?Sprint
    {
        return $this->om->getRepository(Sprint::class)->getCurrentSprint();
    }
    
    public function createSprint($beginAt, $endedAt): Sprint
    {
        $sprint =
            (new Sprint())
            ->setBeginAt($beginAt)
            ->setEndedAt($endedAt)
        ;
        $this->om->persist($sprint);
        $this->om->flush();
        $this->eventDispatcher->dispatch(SprintCreationEvent::NAME, new SprintCreationEvent($sprint));
        return $sprint;
    }
}