<?php

namespace Scrumban\Event;

use Scrumban\Entity\Sprint;

use Symfony\Component\EventDispatcher\Event;

class SprintCreationEvent extends Event
{
    /** @var Sprint **/
    protected $sprint;
    
    const NAME = 'scrumban.sprint_creation';
    
    public function __construct(Sprint $sprint)
    {
        $this->sprint = $sprint;
    }
    
    public function getSprint(): Sprint
    {
        return $this->sprint;
    }
}
