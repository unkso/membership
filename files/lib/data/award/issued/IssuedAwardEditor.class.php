<?php namespace wcf\data\award\issued;

use wcf\data\DatabaseObjectEditor;

class IssuedAwardEditor extends DatabaseObjectEditor
{
    protected static $baseClass = IssuedAward::class;

    public static function resetCache()
    {
        AwardCacheBuilder::getInstance()->reset();
    }
}