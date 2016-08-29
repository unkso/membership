<?php
namespace wcf\system\cache\builder;

use wcf\data\unit\scope\Scope;
use wcf\data\unit\Unit;
use wcf\system\WCF;

class UnitCacheBuilder extends AbstractCacheBuilder
{
    protected function rebuild(array $parameters)
    {
        $data = [
            'units' => $this->getUnits(),
            'scopes' => $this->getScopes(),
        ];

        return $data;
    }

    protected function getUnits()
    {
        $data = [];
        $sql = 'SELECT * FROM ' . Unit::getDatabaseTableName() . ' ORDER BY unitID ASC';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute();
        while ($object = $statement->fetchObject(Unit::class)) {
            $data[$object->unitID] = $object;
        }

        return $data;
    }

    protected function getScopes()
    {
        $data = [];
        $sql = 'SELECT * FROM ' . Scope::getDatabaseTableName() . ' ORDER BY unitScopeID ASC';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute();
        while ($object = $statement->fetchObject(Scope::class)) {
            $data[$object->unitScopeID] = $object;
        }

        return $data;
    }
}