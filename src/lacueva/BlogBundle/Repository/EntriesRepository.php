<?php

namespace lacueva\BlogBundle\Repository;
use lacueva\BlogBundle\Entity\Entries;
use lacueva\BlogBundle\Entity\Categories;

class EntriesRepository  extends \Doctrine\ORM\EntityRepository
{
	
	public function nombreDeClase()
	{
		return $this->getClassName();
	}
	
	public function getPaginateEntries($pageSize=5, $currentPage)
	{
		$this->getEntityManager();
		
		$dql = "SELECT e FROM BlogBundle\Entity\Entries e ORDER BY e.id";
		
		
	}
	
}
