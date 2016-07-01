<?php
namespace wcf\data\unit;

use wcf\data\DatabaseObject;

class Unit extends DatabaseObject
{
    protected static $databaseTableName = 'unkso_unit';
	
    protected static $databaseTableIndexName = 'unitID';

    public function getParent()
    {
        if (!$this->parentID) {
            return null;
        }

        return new self($this->parentID);
    }
}