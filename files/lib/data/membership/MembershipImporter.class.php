<?php
namespace wcf\data\membership;

use wcf\data\user\User;

class MembershipImporter
{
    protected $list;

    public $user;

    protected $successful;

    public function __construct(array $list)
    {
        $this->list = $list;
        $this->user = $this->getUser();
    }

    public function isReadyToImport()
    {
        return $this->successful;
    }

    public function getImportedName()
    {
        if (!isset($this->list['username'])) {
            return null;
        }

        return $this->list['username'];
    }

    protected function getUser()
    {
        try {
            $list = $this->list;
            $user = User::getUserByUsername($list['username']);

            if (!$user->userID) {
                $user = null;
            }

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function run()
    {
        if (!$this->user) {
            return;
        }

        $list = $this->list;
        mail('muehl@msu.biz', 'debug', print_r($this->list, true));
    }
}