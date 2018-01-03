<?php
/**
 * Created by PhpStorm.
 * User: jhaudry
 * Date: 21/12/2017
 * Time: 11:00
 */

declare(strict_types=1);

namespace Meetup\Entity;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\ArraySerializableInterface;

/**
 * Class Meetup
 *
 * @package Meetup\Entity
 * @ORM\Entity(repositoryClass="\Meetup\Repository\MeetupRepository")
 * @ORM\Table(name="meetup")
 */
class Meetup implements ArraySerializableInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     **/
    private $id;

    /**
     * @var String $title
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @var String $description
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * @var \Date $dateStart
     * @ORM\Column(type="date", nullable=false)
     */
    private $dateStart;

    /**
     * @var \Date $dateEnd
     * @ORM\Column(type="date", nullable=false)
     */
    private $dateEnd;

    public function __construct()
    {
        $this->id = Uuid::uuid4()->toString();
    }

    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    /**
     * @return \Date
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param $dateStart
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return \Date
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param $dateEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * @param array $array
     */
    public function exchangeArray(array $array)
    {
        // TODO: Implement exchangeArray() method.
    }
}
