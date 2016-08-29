<?php
namespace wcf\data\unit;

use wcf\data\DatabaseObjectEditor;
use wcf\data\IEditableCachedObject;
use wcf\system\cache\builder\UnitCacheBuilder;

class UnitEditor extends DatabaseObjectEditor implements IEditableCachedObject
{
    protected static $baseClass = Unit::class;

    public static function resetCache()
    {
        UnitCacheBuilder::getInstance()->reset();
    }

    public function delete()
    {
        // TODO: Delete references to this unit!
        parent::delete();
    }
}
