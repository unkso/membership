<?php

namespace wcf\data\award\issued;

use wcf\data\AbstractDatabaseObjectAction;

class IssuedAwardAction extends AbstractDatabaseObjectAction
{
    protected $className = IssuedAwardEditor::class;

    protected $allowGuestAccess = ['getUserAwards'];

    protected $requireACP = ['delete'];

    protected $permissionsDelete = ['admin.clan.award.canDeleteIssuedAwards'];
}