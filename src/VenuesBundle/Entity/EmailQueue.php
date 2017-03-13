<?php

namespace VenuesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmailQueue
 *
 * @ORM\Table(name="email_queue")
 * @ORM\Entity(repositoryClass="VenuesBundle\Repository\EmailQueueRepository")
 */
class EmailQueue
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="process_date", type="datetime")
     */
    private $processDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sent_date", type="datetime")
     */
    private $sentDate;


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
     * Set email
     *
     * @param string $email
     *
     * @return EmailQueue
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set processDate
     *
     * @param \DateTime $processDate
     *
     * @return EmailQueue
     */
    public function setProcessDate($processDate)
    {
        $this->processDate = $processDate;

        return $this;
    }

    /**
     * Get processDate
     *
     * @return \DateTime
     */
    public function getProcessDate()
    {
        return $this->processDate;
    }

    /**
     * Set sentDate
     *
     * @param \DateTime $sentDate
     *
     * @return EmailQueue
     */
    public function setSentDate($sentDate)
    {
        $this->sentDate = $sentDate;

        return $this;
    }

    /**
     * Get sentDate
     *
     * @return \DateTime
     */
    public function getSentDate()
    {
        return $this->sentDate;
    }

}

