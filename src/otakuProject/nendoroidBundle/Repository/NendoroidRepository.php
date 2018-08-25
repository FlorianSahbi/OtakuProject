<?php

namespace otakuProject\nendoroidBundle\Repository;

/**
 * NendoroidRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NendoroidRepository extends \Doctrine\ORM\EntityRepository
{
	public function likeSearch($name)
	{
	  	$query = $this->_em->createQuery('SELECT a FROM otakuProjectnendoroidBundle:Nendoroid a WHERE a.name LIKE :name ');
	  	$query->setParameter('name', '%'.$name.'%');
	  	$results = $query->getResult();

  		return $results;
	}
}