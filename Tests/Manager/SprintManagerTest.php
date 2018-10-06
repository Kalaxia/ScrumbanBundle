<?php

namespace Scrumban\Tests\Manager;

use Scrumban\Manager\SprintManager;

use Scrumban\Entity\Sprint;

class SprintManagerTest extends \PHPUnit\Framework\TestCase
{
    /** @var SprintManager **/
    protected $manager;
    
    public function setUp()
    {
        $this->manager = new SprintManager($this->getObjectManagerMock(), $this->getEventDispatcherMock());
    }
    
    public function testGet()
    {
        $sprint = $this->manager->get(4);
        
        $this->assertInstanceOf(Sprint::class, $sprint);
        $this->assertEquals(4, $sprint->getId());
    }
    
    public function testCurrentSprint()
    {
        $this->assertInstanceOf(Sprint::class, $this->manager->getCurrentSprint());
    }
    
    public function testPreviousSprint()
    {
        $this->assertInstanceOf(Sprint::class, $this->manager->getPreviousSprint());
    }
    
    public function testCreate()
    {
        $beginAt = new \DateTime('+12 days');
        $endedAt = new \DateTime('+26 days');
        $sprint = $this->manager->createSprint($beginAt, $endedAt);
        
        $this->assertInstanceOf(Sprint::class, $sprint);
        $this->assertEquals($beginAt, $sprint->getBeginAt());
        $this->assertEquals($endedAt, $sprint->getEndedAt());
    }
    
    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     * @expectedExceptionMessage The begin date must preceed the end date
     */
    public function testCreateWithInvalidDates()
    {
        $this->manager->createSprint(new \DateTime('+5 days'), new \DateTime('+3 days'));
    }
    
    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\ConflictHttpException
     */
    public function testCreateWithConflict()
    {
        $this->manager->createSprint(new \DateTime('+2 days'), new \DateTime('+16 days'));
    }
    
    public function getObjectManagerMock()
    {
        $objectManagerMock = $this->createMock(\Doctrine\Common\Persistence\ObjectManager::class);
        $objectManagerMock
            ->expects($this->any())
            ->method('persist')
            ->willReturn(true)
        ;
        $objectManagerMock
            ->expects($this->any())
            ->method('flush')
            ->willReturn(true)
        ;
        $objectManagerMock
            ->expects($this->any())
            ->method('getRepository')
            ->willReturnCallback([$this, 'getRepositoryMock'])
        ;
        return $objectManagerMock;
    }
    
    public function getRepositoryMock()
    {
        $repositoryMock = $this
            ->getMockBuilder(\Scrumban\Repository\SprintRepository::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $repositoryMock
            ->expects($this->any())
            ->method('getCurrentSprint')
            ->willReturnCallback([$this, 'getSprintMock'])
        ;
        $repositoryMock
            ->expects($this->any())
            ->method('getPreviousSprint')
            ->willReturnCallback([$this, 'getSprintMock'])
        ;
        $repositoryMock
            ->expects($this->any())
            ->method('find')
            ->willReturnCallback([$this, 'getSprintMock'])
        ;
        $repositoryMock
            ->expects($this->any())
            ->method('getSprintByPeriod')
            ->willReturnCallback(function($beginDate) {
                $sprint = $this->getSprintMock(3);
                
                return ($beginDate < $sprint->getEndedAt()) ? [$sprint]: [];
            });
        return $repositoryMock;
    }
    
    public function getSprintMock($id = null)
    {
        $sprint =
            (new Sprint())
            ->setDemoUrl('http://example.org/demo.flv')
            ->setBeginAt(new \DateTime('-3 days'))
            ->setEndedAt(new \DateTime('+11 days'))
        ;
        if($id !== null) {
            $sprint->setId($id);
        }
        return $sprint;
    }
    
    public function getEventDispatcherMock()
    {
        $dispatcherMock = $this->createMock(\Symfony\Component\EventDispatcher\EventDispatcherInterface::class);
        $dispatcherMock
            ->expects($this->any())
            ->method('dispatch')
            ->willReturn(true)
        ;
        return $dispatcherMock;
    }
}