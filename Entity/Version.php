<?php

namespace Scrumban\Entity;

use Doctrine\ORM\Mapping as ORM;

use Scrumban\Model\Version as VersionModel;

/**
 * @ORM\Entity()
 * @ORM\Table(name="scrumban__versions")
 */
class Version extends VersionModel
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=15)
     */
    protected $id;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $plannedAt;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $releasedAt;
}