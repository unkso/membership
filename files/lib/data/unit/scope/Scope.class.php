<?php
namespace wcf\data\unit\scope;

use wcf\data\DatabaseObject;
use wcf\data\unit\UnitPosition;
use wcf\data\unit\Unit;
use wcf\system\WCF;

class Scope extends DatabaseObject
{
    protected static $databaseTableName = 'unkso_unit_scope';

    protected static $databaseTableIndexName = 'unitScopeID';

    protected $tails = null;

    protected $units = null;

    public function unitsInScope($clear = false)
    {
        if ($this->units && !$clear) {
            return $this->units;
        }

        $head = $this->getHeadUnit();
        $tails = $this->getTailUnits();

        $unitIDs = []; // For convenience / faster comparison
        $units = [];

        foreach ($tails as $tail) {
            $unitsInBetween = $this->moveToHead($tail, $head);
            foreach ($unitsInBetween as $unit) {
                if (in_array($unit->unitID, $unitIDs)) {
                    continue;
                }

                $unitIDs[] = $unit->unitID;
                $units[] = $unit;
            }
        }

        return $this->units = $units;
    }

    /**
     * @param Unit $tail
     * @param Unit $head
     * @param Unit[] $unitsInBetween
     * @return Unit[]
     */
    protected function moveToHead(Unit $tail, Unit $head, &$unitsInBetween = [])
    {
        $unitsInBetween[] = $tail;

        $parent = $tail->getParent();
        if ($parent && $tail->unitID != $head->unitID) {
            return $this->moveToHead($parent, $head, $unitsInBetween);
        }

        return $unitsInBetween;
    }

    /**
     * @return Unit|UnitPosition
     */
    public function getHead()
    {
        if ($this->headUnitID) {
            return new Unit($this->headUnitID);
        }

        return new UnitPosition($this->headUnitPositionID);
    }

    /**
     * @return Unit
     */
    public function getHeadUnit()
    {
        $head = $this->getHead();
        if (is_a($head, UnitPosition::class)) {
            $head = $head->getUnit();
        }

        return $head;
    }

    /**
     * @return Unit[]
     */
    public function getTailUnits()
    {
        $tails = $this->getTails();
        foreach ($tails as &$tail) {
            if (is_a($tail, UnitPosition::class)) {
                $tail = $tail->getUnit();
            }
        }

        return $tails;
    }

    /**
     * @return (Unit\UnitPosition)[]
     * @throws \wcf\system\database\DatabaseException
     */
    public function getTails()
    {
        if ($this->tails) {
            return $this->tails;
        }

        $tableName = self::getDatabaseTableName() . '_tail';

        $sql = "SELECT  *
                FROM    $tableName
                WHERE   unitScopeID = ?";
        $statement = WCF::getDB()->prepareStatement($sql);

        $statement->execute([$this->unitScopeID]);

        $results = [];
        while ($result = $statement->fetchArray()) {
            // It could be either a Unit or a Position within a unit.
            // Decide which one it is and return the correct object.

            if (isset($result['tailUnitID']) && $result['tailUnitID']) {
                $results[] = new Unit($result['tailUnitID']);
                continue;
            }

            if (isset($result['tailUnitPositionID']) && $result['tailUnitID']) {
                $results[] = new UnitPosition($result['tailUnitPositionID']);
                continue;
            }

            // Realistically, an Exception should be thrown here, as at least one of those has to be set.
        }

        return $this->tails = $results;
    }
}