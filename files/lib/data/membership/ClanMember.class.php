<?php namespace wcf\data\membership;

use wcf\data\DatabaseObjectDecorator;
use wcf\data\user\User;

class ClanMember extends DatabaseObjectDecorator
{
    protected static $baseClass = User::class;
}