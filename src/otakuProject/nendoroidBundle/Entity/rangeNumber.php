<?php

namespace otakuProject\nendoroidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * rangeNumber
 *
 * @ORM\Table(name="range_number")
 * @ORM\Entity(repositoryClass="otakuProject\nendoroidBundle\Repository\rangeNumberRepository")
 */
class rangeNumber
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
     * @ORM\Column(name="rangeNumber", type="string", length=255)
     */
    private $rangeNumber;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rangeNumber
     *
     * @param string $rangeNumber
     *
     * @return rangeNumber
     */
    public function setRangeNumber($rangeNumber)
    {
        $this->rangeNumber = $rangeNumber;

        return $this;
    }

    /**
     * Get rangeNumber
     *
     * @return string
     */
    public function getRangeNumber()
    {
        return $this->rangeNumber;
    }
}
