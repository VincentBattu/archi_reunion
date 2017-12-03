<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Point
 *
 * @ORM\Table(name="point")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PointRepository")
 */
class Point
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
     * @var Meeting
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Meeting", inversedBy="points")
     * @ORM\JoinColumn(nullable=true)
     */
    private $meeting;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     *
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="report", type="text", nullable=true)
     */
    private $report;


    /**
     * @var string
     *
     * @ORM\Column(name="official_report", type="text", nullable=true)
     */
    private $officialReport;

    public function __construct()
    {
        $this->date = new \DateTime();
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
     * Set meeting
     *
     * @param \AppBundle\Entity\Meeting $meeting
     *
     * @return Point
     */
    public function setMeeting(\AppBundle\Entity\Meeting $meeting = null)
    {
        $this->meeting = $meeting;

        return $this;
    }

    /**
     * Get meeting
     *
     * @return \AppBundle\Entity\Meeting
     */
    public function getMeeting()
    {
        return $this->meeting;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Point
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

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Point
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set report
     *
     * @param string $report
     *
     * @return Point
     */
    public function setReport($report)
    {
        $this->report = $report;

        return $this;
    }

    /**
     * Get report
     *
     * @return string
     */
    public function getReport()
    {
        return $this->report;
    }

    public function setOfficialReport($officialReport)
    {
        $this->officialReport = $officialReport;

        return $this;
    }

    /**
     * Get report
     *
     * @return string
     */
    public function getOfficialReport()
    {
        return $this->officialReport;
    }
}
