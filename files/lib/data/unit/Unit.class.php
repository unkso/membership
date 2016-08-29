<?php
namespace wcf\data\unit;

use wcf\data\DatabaseObject;
use wcf\system\WCF;

class Unit extends DatabaseObject
{
    protected static $databaseTableName = 'unkso_unit';

    protected static $databaseTableIndexName = 'unitID';

    public function supportedTypes()
    {
        return [
            'clan' => 'Clan',
            'thingy' => 'Something that I don\'t know the name for',
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

        return new self($this->parentID);
    }

    public function getPositions()
    {
        $sql = 'SELECT * FROM ' . UnitPosition::getDatabaseTableName() . ' WHERE unitID = ? ORDER BY unitPositionID ASC';
        $statement = WCF::getDB()->prepareStatement($sql);
        $statement->execute([$this->unitID]);

        return $statement->fetchObjects(UnitPosition::class);
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