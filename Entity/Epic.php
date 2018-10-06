<?php

namespace Scrumban\Entity;

use Doctrine\ORM\Mapping as ORM;

use Scrumban\Model\Epic as EpicModel;

/**
 * @ORM\Entity()
 * @ORM\Table(name="scrumban__epics")
 */
class Epic extends EpicModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;
    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $status;
    /**
     * @ORM\Column(type="integer")
     */
    protected $estimatedTime;
    /**
     * @ORM\Column(type="integer")
     */
    protected $spentTime;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;
}