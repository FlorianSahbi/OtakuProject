<?php
// src/OC/userBundle/Entity/User.php

namespace otakuProject\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use otakuProject\nendoroidBundle\Entity\Nendoroid;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="otakuProject\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

    /**
   * @ORM\OneToOne(targetEntity="otakuProject\nendoroidBundle\Entity\Nendoroid", cascade={"persist"})
   */
  private $firstNendo;

  /**
   * @ORM\ManyToMany(targetEntity="otakuProject\nendoroidBundle\Entity\Nendoroid", cascade={"persist"})
     @ORM\JoinTable(name="user_nendoroids_like")
   */
  private $nendoroidsLike;

  public function __constructLike()
  {
      $this->nendoroidsLike = new ArrayCollection();
  }

  public function addNendoroidLike(Nendoroid $nendoroid)
  {
      $this->nendoroidsLike[] = $nendoroid;
  }

  public function removeNendoroidLike(Nendoroid $nendoroid)
  {
      $this->nendoroidsLike->removeElement($nendoroid);
  }

  public function getNendoroidsLike()
  {
      return $this->nendoroidsLike;
  }

  /**
   * @ORM\ManyToMany(targetEntity="otakuProject\nendoroidBundle\Entity\Nendoroid", cascade={"persist"})
     @ORM\JoinTable(name="user_nendoroids_collection")
   */
  private $nendoroidsCollection;

  public function __constructCollection()
  {
      $this->nendoroidsCollection = new ArrayCollection();
  }

  public function addNendoroidCollection(Nendoroid $nendoroid)
  {
      $this->nendoroidsCollection[] = $nendoroid;
  }

  public function removeNendoroidCollection(Nendoroid $nendoroid)
  {
      $this->nendoroidsCollection->removeElement($nendoroid);
  }

  public function getNendoroidsCollection()
  {
      return $this->nendoroidsCollection;
  }

  /**
   * @ORM\ManyToMany(targetEntity="otakuProject\nendoroidBundle\Entity\Nendoroid", cascade={"persist"})
     @ORM\JoinTable(name="user_nendoroids_love")
   */
  private $nendoroidsLove;

  public function __constructLove()
  {
      $this->nendoroidsLove = new ArrayCollection();
  }

  public function addNendoroidLove(Nendoroid $nendoroid)
  {
      $this->nendoroidsLove[] = $nendoroid;
  }

  public function removeNendoroidLove(Nendoroid $nendoroid)
  {
      $this->nendoroidsLove->removeElement($nendoroid);
  }

  public function getNendoroidsLove()
  {
      return $this->nendoroidsLove;
  }

    /**
     * Set firstNendo
     *
     * @param \otakuProject\nendoroidBundle\Entity\Nendoroid $firstNendo
     *
     * @return User
     */
    public function setFirstNendo(\otakuProject\nendoroidBundle\Entity\Nendoroid $firstNendo = null)
    {
        $this->firstNendo = $firstNendo;

        return $this;
    }

    /**
     * Get firstNendo
     *
     * @return \otakuProject\nendoroidBundle\Entity\Nendoroid
     */
    public function getFirstNendo()
    {
        return $this->firstNendo;
    }

    /**
     * Add nendoroidsLike
     *
     * @param \otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsLike
     *
     * @return User
     */
    public function addNendoroidsLike(\otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsLike)
    {
        $this->nendoroidsLike[] = $nendoroidsLike;

        return $this;
    }

    /**
     * Remove nendoroidsLike
     *
     * @param \otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsLike
     */
    public function removeNendoroidsLike(\otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsLike)
    {
        $this->nendoroidsLike->removeElement($nendoroidsLike);
    }

    /**
     * Add nendoroidsCollection
     *
     * @param \otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsCollection
     *
     * @return User
     */
    public function addNendoroidsCollection(\otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsCollection)
    {
        $this->nendoroidsCollection[] = $nendoroidsCollection;

        return $this;
    }

    /**
     * Remove nendoroidsCollection
     *
     * @param \otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsCollection
     */
    public function removeNendoroidsCollection(\otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsCollection)
    {
        $this->nendoroidsCollection->removeElement($nendoroidsCollection);
    }

    /**
     * Add nendoroidsLove
     *
     * @param \otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsLove
     *
     * @return User
     */
    public function addNendoroidsLove(\otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsLove)
    {
        $this->nendoroidsLove[] = $nendoroidsLove;

        return $this;
    }

    /**
     * Remove nendoroidsLove
     *
     * @param \otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsLove
     */
    public function removeNendoroidsLove(\otakuProject\nendoroidBundle\Entity\Nendoroid $nendoroidsLove)
    {
        $this->nendoroidsLove->removeElement($nendoroidsLove);
    }
}
