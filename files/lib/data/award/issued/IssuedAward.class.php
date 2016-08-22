<?php namespace wcf\data\award\issued;

use wcf\data\DatabaseObject;

class IssuedAward extends DatabaseObject
{
    protected static $databaseTableName = 'unkso_issued_award';

    protected static $databaseTableIndexName = 'awardID';
}