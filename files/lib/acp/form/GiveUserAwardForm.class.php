<?php

namespace wcf\acp\form;

use wcf\data\award\action\AwardTierAction;
use wcf\data\award\Award;
use wcf\data\award\AwardTier;
use wcf\data\award\category\AwardCategory;
use wcf\data\award\issued\IssuedAward;
use wcf\data\award\issued\IssuedAwardAction;
use wcf\data\category\Category;
use wcf\data\category\CategoryNodeTree;
use wcf\data\user\User;
use wcf\form\AbstractForm;
use wcf\form\FormBuilder;
use wcf\data\award\action\AwardAction;
use wcf\system\cache\builder\AwardCacheBuilder;
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

    /**
     * The tier being given
     * @var AwardTier
     */
    public $tier = null;

    /**
     * The ID of the tier that's being given
     * @var int
     */
    public $tierID = 0;

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

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'user' => $this->user,
            'tier' => $this->tier,
            'tierID' => $this->tierID,
            'description' => $this->description,
            'date' => $this->date,
            'notify' => $this->notify,
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

        if (isset($_POST['tierID'])) $this->tierID = intval(StringUtil::trim($_POST['tierID']));
        if (isset($_POST['description'])) $this->description = StringUtil::trim($_POST['description']);
        if (isset($_POST['date'])) $this->date = StringUtil::trim($_POST['date']);
        if (isset($_POST['notify'])) $this->notify = StringUtil::trim($_POST['notify']);
    }

    public function validate()
    {
        parent::validate();

        if (empty($this->tierID)) {
            throw new UserInputException('tierID');
        }
        if (!$this->tier = AwardTier::getTierByID($this->tierID)) {
            throw new UserInputException('tierID', 'invalid');
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

        $user = $this->user;
        $tier = $this->tier;

        IssuedAward::giveToUser($user, $tier, $this->description, $this->date, $this->notify);

        // Reset values
        $this->tier = null;
        $this->tierID = 0;
        $this->description = '';
        $this->date = '';
        $this->notify = false;

        WCF::getTPL()->assign([
            'success' => true,
        ]);
    }
}