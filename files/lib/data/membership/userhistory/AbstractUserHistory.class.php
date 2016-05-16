<?php
namespace wcf\data\membership\userhistory;
use wcf\data\DatabaseObject;

abstract class AbstractUserHistory extends DatabaseObject
{
	protected static $databaseTableName = 'unkso_user_history';
	
	protected static $databaseTableIndexName = 'historyID';
}