<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * Event
 *
 * @ORM\Table(name="events")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, unique=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="datetime")
     */
    private $postDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_date", type="date")
     */
    private $eventDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_time", type="time")
     */
    private $eventTime;

    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="events")
     * @JoinColumn(name="$author_id", referencedColumnName="id", nullable=false)
     */
    private $author;

    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\Place", inversedBy="events")
     * @JoinColumn(name="place_id", referencedColumnName="id", nullable=false)
     */
    private $place;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User")
     *@ORM\JoinTable(name="events_participants",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")})
     */
    private $participants;

    /**
     * @ManyToOne(targetEntity="AppBundle\Entity\EventCategory", inversedBy="events")
     * @JoinColumn(name="event_category_id", referencedColumnName="id")
     */
    private $eventCategory;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getEventCategory()
    {
        return $this->eventCategory;
    }

    /**
     * @param mixed $eventCategory
     */
    public function setEventCategory($eventCategory)
    {
        $this->eventCategory = $eventCategory;
    }


    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     * @return $this
     */
    public function setParticipants($participants)
    {
        $participantsArr = [];
        foreach ($this->participants as $participant){
            $participantsArr[] = $participant;
        }
        $participantsArr[] = $participants;

        $this->participants = $participantsArr;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param mixed $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
     * Set name
     *
     * @param string $name
     *
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     *
     * @return Event
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Set eventDate
     *
     * @param \DateTime $eventDate
     *
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set eventTime
     *
     * @param \DateTime $eventTime
     *
     * @return Event
     */
    public function setEventTime($eventTime)
    {
        $this->eventTime = $eventTime;

        return $this;
    }

    /**
     * Get eventTime
     *
     * @return \DateTime
     */
    public function getEventTime()
    {
        return $this->eventTime;
    }
}

