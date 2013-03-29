<?php

namespace Success\CategoryBundle\Entity\Repository;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

class CategoryRepository extends NestedTreeRepository
{
  
  public function getTree(){
    $consulta = $this->getTreeQuery();
    return $consulta->getQuery()->getResult();
  }
  
  public function getTreeQuery(){
    $em = $this->getEntityManager();
    $query = $em->createQueryBuilder()
            ->select('c')
            ->from('CategoryBundle:Category', 'c')
            ->addOrderBy('c.root')
            ->addOrderBy('c.lft');

    return $query;
  }

}