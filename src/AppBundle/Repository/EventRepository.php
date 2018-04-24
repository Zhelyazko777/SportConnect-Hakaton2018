<?php

namespace AppBundle\Repository;
use PDO;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCountOfEvents()
    {
        $connection = $this->getEntityManager()->getConnection();
        $statement = $connection->prepare("SELECT COUNT(id)FROM events;");
        $statement->execute();
        return $result = $statement->fetchAll(PDO::FETCH_COLUMN);
    }
}
