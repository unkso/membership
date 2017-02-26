<?php
namespace wcf\system\cache\builder;

use wcf\data\award\issued\IssuedAward;
use wcf\system\WCF;

class IssuedAwardCacheBuilder extends AbstractCacheBuilder
{
    protected function rebuild(array $parameters)
    {
        $data = [
            'awards' => $this->getAwards(),
        ];

        return $data;
    }

    protected function getAwards()
    {
        $data = [];
        $sql = 'SELECT * FROM ' . IssuedAward::getDatabaseTableName() . ' ORDER BY issuedAwardID ASC';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute();
        while ($object = $statement->fetchObject(IssuedAward::class)) {
            $data[$object->issuedAwardID] = $object;
        }

        return $data;
    }
}