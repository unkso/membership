<?php

namespace wcf\data\unit;

use wcf\system\cache\builder\UnitCacheBuilder;
use wcf\system\SingletonFactory;

class UnitCache extends SingletonFactory
{
    protected $units = [];

    protected $scopes = [];

    protected $positions = [];

    protected function init()
    {
        $this->units = UnitCacheBuilder::getInstance()->getData([], 'units');
        $this->scopes = UnitCacheBuilder::getInstance()->getData([], 'scopes');
        $this->positions = UnitCacheBuilder::getInstance()->getData([], 'positions');
    }

    public function getUnits()
    {
        return $this->units;
    }

    public function getUnitScopes()
    {
        return $this->scopes;
    }

    public function getPositions()
    {
        return $this->positions;
    }
}