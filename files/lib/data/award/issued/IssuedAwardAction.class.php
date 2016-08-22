<?php namespace wcf\data\award\issued;

use wcf\data\AbstractDatabaseObjectAction;

class IssuedAwardAction extends AbstractDatabaseObjectAction
{
    protected $className = '';

    protected $allowGuestAccess = ['getUserAwards'];

    public function __construct(array $objects, $action, array $parameters)
    {
        var_dump($objects);
        die();
        parent::__construct($objects, $action, $parameters);
    }

    public function validateGetUserAwards()
    {
        return true;
    }

    public function getUserAwards()
    {
        print_r($this->objectIDs);
        die();
        return 'Hey ' . $userID;
    }
}