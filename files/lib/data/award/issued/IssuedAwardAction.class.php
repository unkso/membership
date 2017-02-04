<?php

namespace wcf\data\award\issued;

use wcf\data\AbstractDatabaseObjectAction;
use wcf\system\event\EventHandler;

class IssuedAwardAction extends AbstractDatabaseObjectAction
{
    protected $className = IssuedAwardEditor::class;

    protected $allowGuestAccess = ['getUserAwards'];

    protected $requireACP = ['delete'];

    protected $permissionsDelete = ['admin.clan.award.canDeleteIssuedAwards'];

    public function delete()
    {
        EventHandler::getInstance()->fireAction($this, 'delete');

        parent::delete();
    }
}