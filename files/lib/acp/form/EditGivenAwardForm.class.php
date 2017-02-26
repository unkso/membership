<?php

namespace wcf\acp\form;

use wcf\data\award\issued\IssuedAward;
use wcf\data\award\issued\IssuedAwardAction;
use wcf\data\user\User;
use wcf\system\cache\builder\IssuedAwardCacheBuilder;
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

        $this->description = $this->issuedAward->description;
        $this->date = $this->issuedAward->date;
        $this->award = $this->issuedAward->getAward();
        $this->awardName = $this->award->title;
        $this->awardedNumber = $this->issuedAward->awardedNumber;
    }

    public function save()
    {
        $objectAction = new IssuedAwardAction([$this->issuedAward], 'update', [
            'data' => [
                'awardedNumber' => $this->awardedNumber,
                'description' => $this->description,
                'date' => $this->date,
            ],
        ]);
        $objectAction->executeAction();

        $this->givenAward = $this->issuedAward;

        IssuedAwardCacheBuilder::getInstance()->reset();

        WCF::getTPL()->assign([
            'success' => true,
        ]);

        $this->saved();
    }
}