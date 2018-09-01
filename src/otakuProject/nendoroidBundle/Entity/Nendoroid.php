<?php

namespace otakuProject\nendoroidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nendoroid
 *
 * @ORM\Table(name="nendoroid")
 * @ORM\Entity(repositoryClass="otakuProject\nendoroidBundle\Repository\NendoroidRepository")
 */
class Nendoroid
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    private $number;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="preview", type="string", length=255, nullable=true)
     */
    private $preview;

    /**
     * @var int
     *
     * @ORM\Column(name="cptLike", type="integer", nullable=true)
     */
    private $cptLike;

    /**
     * @ORM\ManyToOne(targetEntity="otakuProject\nendoroidBundle\Entity\Serie")
     * @ORM\JoinColumn(nullable=true)
     */
    private $serie;

    /**
     * @ORM\ManyToOne(targetEntity="otakuProject\nendoroidBundle\Entity\rangeNumber")
     * @ORM\JoinColumn(nullable=true)
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
     * Set name
     *
     * @param string $name
     *
     * @return Nendoroid
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
     * Set price
     *
     * @param integer $price
     *
     * @return Nendoroid
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set preview
     *
     * @param string $preview
     *
     * @return Nendoroid
     */
    public function setPreview($preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * Get preview
     *
     * @return string
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * Set serie
     *
     * @param \otakuProject\nendoroidBundle\Entity\Serie $serie
     *
     * @return Nendoroid
     */
    public function setSerie(\otakuProject\nendoroidBundle\Entity\Serie $serie = null)
    {
        $this->serie = $serie;

        return $this;
    }

    /**
     * Get serie
     *
     * @return \otakuProject\nendoroidBundle\Entity\Serie
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Set rangeNumber
     *
     * @param \otakuProject\nendoroidBundle\Entity\rangeNumber $rangeNumber
     *
     * @return Nendoroid
     */
    public function setRangeNumber(\otakuProject\nendoroidBundle\Entity\rangeNumber $rangeNumber = null)
    {
        $this->rangeNumber = $rangeNumber;

        return $this;
    }

    /**
     * Get rangeNumber
     *
     * @return \otakuProject\nendoroidBundle\Entity\rangeNumber
     */
    public function getRangeNumber()
    {
        return $this->rangeNumber;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Nendoroid
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set cptLike
     *
     * @param integer $cptLike
     *
     * @return Nendoroid
     */
    public function setCptLike($cptLike)
    {
        $this->cptLike = $cptLike;

        return $this;
    }

    /**
     * Get cptLike
     *
     * @return integer
     */
    public function getCptLike()
    {
        return $this->cptLike;
    }
}
