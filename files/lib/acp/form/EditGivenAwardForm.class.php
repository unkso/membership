<?php

namespace wcf\acp\form;

use wcf\data\award\issued\IssuedAward;
use wcf\data\award\issued\IssuedAwardAction;
use wcf\data\user\User;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class EditGivenAwardForm extends GiveUserAwardForm
{
    public $templateName = 'giveUserAward';

    protected $issuedAwardID;

    protected $issuedAward;

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'action' => 'edit',
            'issuedID' => $this->issuedAwardID,
            'user' => $this->user,
            'tier' => $this->tier,
            'tierID' => $this->tierID,
            'description' => $this->description,
            'date' => $this->date,
        ]);
    }

    public function readParameters()
    {
        if (isset($_REQUEST['id'])) $this->issuedAwardID = intval($_REQUEST['id']);
        $this->issuedAward = new IssuedAward($this->issuedAwardID);
        if (!$this->issuedAward->issuedAwardID) {
            throw new IllegalLinkException();
        }

        $this->userID = $this->issuedAward->userID;
        $this->user = new User($this->userID);

        $this->tierID = $this->issuedAward->tierID;
        $this->tier = $this->issuedAward->getTier();
        $this->description = $this->issuedAward->description;
        $this->date = $this->issuedAward->date;
    }

    public function validate()
    {
        if (empty($this->description)) {
            throw new UserInputException('description');
        }

        if (empty($this->date)) {
            throw new UserInputException('date');
        }
    }

    public function save()
    {
        $objectAction = new IssuedAwardAction([$this->issuedAward], 'update', [
            'data' => [
                'description' => $this->description,
                'date' => $this->date,
            ],
        ]);
        $objectAction->executeAction();
        $this->saved();

        WCF::getTPL()->assign([
            'success' => true,
        ]);
    }
}