<?php

namespace wcf\data\unit;

use wcf\data\DatabaseObject;

class Unit extends DatabaseObject
{
    protected static $databaseTableName = 'unkso_unit';

    protected static $databaseTableIndexName = 'unitID';

    public function __construct($id, array $row = null, DatabaseObject $object = null)
    {
        parent::__construct($id, $row, $object);

        $this->extraData = json_decode($this->extraData, true);
    }

    public function supportedTypes()
    {
        return [
            'command' => 'Command',
            'branch' => 'Branch',
            'department' => 'Department',
            'mos' => 'MOS',
            'platoon' => 'Platoon',
            'squad' => 'Squad',
            'fireteam' => 'Fire Team',
        ];
    }

    public function getParent()
    {
        if (!$this->parentID) {
            return null;
        }

        $cache = UnitCache::getInstance()->getUnits();
        if ($cache[$this->parentID]) {
            return $cache[$this->parentID];
        }

        return new self($this->parentID);
    }

    public function getPositions()
    {
        $cached = UnitCache::getInstance()->getPositions();
        $objects = [];
        foreach ($cached as $position) {
            if ($position->unitID == $this->unitID) {
                $objects[] = $position;
            }
        }

        return $objects;
    }

    public function getTypeDisplayName()
    {
        $supported = $this->supportedTypes();

        return isset($supported[$this->type]) ? $supported[$this->type] : $this->type;
    }

    public function getHierarchy()
    {
        $list = [$this];
        $listIDs = [$this->unitID];

        $object = $this;
        while ($parent = $object->getParent()) {
            // Avoid units being their own parent
            if ($parent->parentID == $parent->unitID) {
                break;
            }

            // Avoid infinite loops
            if (in_array($parent->unitID, $listIDs)) {
                break;
            }

            $list[] = $parent;
            $listIDs[] = $parent->unitID;
            $object = $parent;
        }

        return array_reverse($list);
    }
}