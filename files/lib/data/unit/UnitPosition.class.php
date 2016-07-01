<?php
namespace wcf\data\unit;

use wcf\data\DatabaseObject;

class UnitPosition extends DatabaseObject
{
    protected static $databaseTableName = 'unkso_position';
	
    protected static $databaseTableIndexName = 'unitPositionID';

    public function getUnit()
    {
        return new Unit($this->unitID);
    }
}