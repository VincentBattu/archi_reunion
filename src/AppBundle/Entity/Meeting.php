<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Meeting
 *
 * @ORM\Table(name="meeting")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MeetingRepository")
 * @UniqueEntity(fields={"date"}, message="Une réunion existe déjà à cette date donnée")
 */
class Meeting
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Point", mappedBy="meeting", cascade={"all"})
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $points;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name = "date", type="date", unique=true)
     * @Assert\Date()
     */
    private $date;


    public function __construct()
    {
        $this->points = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add point
     *
     * @param \AppBundle\Entity\Point $point
     *
     * @return Meeting
     */
    public function addPoint(\AppBundle\Entity\Point $point)
    {
        $this->points->add($point);
        $point->setMeeting($this);
        return $this;
    }

    /**
     * Remove point
     *
     * @param \AppBundle\Entity\Point $point
     */
    public function removePoint(\AppBundle\Entity\Point $point)
    {
        $this->points->removeElement($point);
        $point->setMeeting(null);
    }

    /**
     * Get points
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPoints()
    {
        return $this->points;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Meeting
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}

