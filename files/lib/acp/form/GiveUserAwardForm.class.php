<?php

namespace wcf\acp\form;

use wcf\data\award\action\AwardTierAction;
use wcf\data\award\Award;
use wcf\data\award\AwardTier;
use wcf\data\award\category\AwardCategory;
use wcf\data\award\issued\IssuedAward;
use wcf\data\award\issued\IssuedAwardAction;
use wcf\data\award\issued\IssuedAwardCache;
use wcf\data\category\Category;
use wcf\data\category\CategoryNodeTree;
use wcf\data\user\User;
use wcf\form\AbstractForm;
use wcf\form\FormBuilder;
use wcf\data\award\action\AwardAction;
use wcf\system\cache\builder\AwardCacheBuilder;
use wcf\system\cache\builder\IssuedAwardCacheBuilder;
use wcf\system\exception\IllegalLinkException;
use wcf\system\exception\UserInputException;
use wcf\system\WCF;
use wcf\util\StringUtil;

class GiveUserAwardForm extends AbstractForm
{
    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.clan.award.canIssueAwards'];

    /**
     * The ID of the award being given
     * @var int
     */
    public $userID = 0;

    /**
     * The user being given an award
     * @var User
     */
    public $user = null;

    public $awardName = '';

    /**
     * @var Award
     */
    public $award = null;

    /**
     * The description for why this award is given
     * @var string
     */
    public $description = '';

    /**
     * The date when the award is given
     * @var string
     */
    public $date = '';

    /**
     * Whether the user should be notified of this award
     * @var bool
     */
    public $notify = false;

    public $awardedNumber = 1;

    /**
     * @var IssuedAward
     */
    public $givenAward = null;

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'action' => 'add',
            'user' => $this->user,
            'awardName' => $this->awardName,
            'award' => $this->award,
            'description' => $this->description,
            'date' => $this->date,
            'notify' => $this->notify,
            'awardedNumber' => $this->awardedNumber,
        ]);
    }

    public function readParameters()
    {
        parent::readParameters();

        if (isset($_REQUEST['id'])) $this->userID = intval($_REQUEST['id']);
        $this->user = new User($this->userID);
        if (!$this->user->getUserID()) {
            throw new IllegalLinkException();
        }
    }

    public function readFormParameters()
    {
        parent::readFormParameters();

        if (isset($_POST['awardName'])) $this->awardName = StringUtil::trim($_POST['awardName']);
        if (isset($_POST['description'])) $this->description = StringUtil::trim($_POST['description']);
        if (isset($_POST['date'])) $this->date = StringUtil::trim($_POST['date']);
        if (isset($_POST['notify'])) $this->notify = StringUtil::trim($_POST['notify']);
        if (isset($_POST['confirm'])) $this->confirm = StringUtil::trim($_POST['confirm']);
        if (isset($_POST['awardedNumber'])) $this->awardedNumber = intval($_POST['awardedNumber']);

        $this->award = Award::getAwardByName($this->awardName);
    }

    public function validate()
    {
        parent::validate();

        if (empty($this->awardName) || !$this->award->awardID) {
            throw new UserInputException('award');
        }

        if (empty($this->awardedNumber) && $this->awardedNumber !== 0) {
            throw new UserInputException('awardedNumber');
        }
        if ($this->awardedNumber < 1 || $this->awardedNumber > 9) {
            throw new UserInputException('awardedNumber', 'outofrange');
        }

        if (empty($this->description)) {
            throw new UserInputException('description');
        }

        if (empty($this->date)) {
            throw new UserInputException('date');
        }
    }

    public function save()
    {
        parent::save();

        $this->givenAward = IssuedAward::giveToUser($this->user, $this->award, $this->description, $this->date, $this->awardedNumber, $this->notify);
        $this->saved();

        // Reset values
        $this->award = null;
        $this->awardName = '';
        $this->awardedNumber = 1;
        $this->description = '';
        $this->date = '';
        $this->notify = false;

        IssuedAwardCacheBuilder::getInstance()->reset();

        WCF::getTPL()->assign([
            'success' => true,
        ]);
    }
}