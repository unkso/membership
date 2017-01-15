<?php

namespace wcf\data\award\issued;

use wcf\data\AbstractDatabaseObjectAction;

class IssuedAwardAction extends AbstractDatabaseObjectAction
{
    protected $className = '';

    protected $allowGuestAccess = ['getUserAwards'];
}