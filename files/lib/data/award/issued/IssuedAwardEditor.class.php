<?php

namespace wcf\data\award\issued;

use wcf\data\DatabaseObjectEditor;
use wcf\system\cache\builder\AwardCacheBuilder;

class IssuedAwardEditor extends DatabaseObjectEditor
{
    protected static $baseClass = IssuedAward::class;

    public static function resetCache()
    {
        AwardCacheBuilder::getInstance()->reset();
    }
}