<?php
namespace wcf\action;

use wcf\data\IDatabaseObjectAction;
use wcf\system\exception\PermissionDeniedException;
use wcf\system\exception\SystemException;
use wcf\util\JSON;
use wcf\util\StringUtil;

class UserManagementAction extends AJAXProxyAction
{
    public $loginRequired = true;

    public $neededPermissions = ['mod.clan.general.accessUserManagement'];

    public $actionName;

    protected $userID;

    protected function invoke()
    {
        
    }
    public function readParameters()
    {
        if (isset($_POST['actionName'])) $this->actionName = StringUtil::trim($_POST['actionName']);
        if (isset($_POST['userID'])) $this->userID = intval($_POST['userID']);

        switch ($this->actionName) {
            case 'getResult':
                if (!$this->poll->canSeeResult()) {
                    throw new PermissionDeniedException();
                }
                break;

            case 'getVote':
            case 'vote':
                if (!$this->poll->canVote()) {
                    throw new PermissionDeniedException();
                }
                break;

            default:
                throw new SystemException("Unknown action '".$this->actionName."'");
                break;
        }
    }

    public function getUserManagementTemplate()
    {
        header('Content-type: application/json');
        echo JSON::encode(['hi' => 'yo']);
        exit;
    }
}