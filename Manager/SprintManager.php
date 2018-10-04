<?php

namespace Scrumban\Manager;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Scrumban\Event\SprintCreationEvent;

use Scrumban\Entity\Sprint;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

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
    
    public function createSprint(\DateTime $beginAt, \DateTime $endedAt): Sprint
    {
        if ($beginAt >= $endedAt) {
            throw new BadRequestHttpException('The begin date must preceed the end date');
        }
        if (count($existingSprints = $this->om->getRepository(Sprint::class)->getSprintByPeriod($beginAt, $endedAt)) > 0) {
            throw new ConflictHttpException(
                "The given dates conflict with sprint {$existingSprints[0]->getId()} [{$existingSprints[0]->getBeginAt()->format('Y-m-d H:i:s')} - {$existingSprints[0]->getEndedAt()->format('Y-m-d H:i:s')}]"
            );
        }
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