<?php

namespace Scrumban\Event;

use Symfony\Component\EventDispatcher\Event;

use Scrumban\Entity\UserStory;

class UserStoryCreationEvent extends Event
{
    /** @var UserStory **/
    protected $userStory;
    
    const NAME = 'scrumban.user_story_creation';
    
    public function __construct(UserStory $userStory)
    {
        $this->userStory = $userStory;
    }
    
    public function getUserStory(): UserStory
    {
        return $this->userStory;
    }
}