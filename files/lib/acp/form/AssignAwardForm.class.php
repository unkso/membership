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

class AssignAwardForm extends AbstractForm
{
    /**
     * @inheritDoc
     */
    public $activeMenuItem = 'wcf.acp.menu.link.clan.award.list';

    /**
     * @inheritDoc
     */
    public $neededPermissions = ['admin.clan.award.canIssueAwards'];

    /**
     * The ID of the award being given
     * @var int
     */
    public $awardID = 0;

    /**
     * The award being given
     * @var Award
     */
    public $award = null;

    /**
     * The username of the user to receive this award
     * @var string
     */
    public $username = '';

    /**
     * The ID of the tier that's being given
     * @var int
     */
    public $tierID = 0;

    /**
     * The tier that's being received
     * @var int
     */
    public $tier = null;

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
            'username' => $this->username,
            'award' => $this->award,
            'tierID' => $this->tierID,
            'description' => $this->description,
            'date' => $this->date,
            'notify' => $this->notify,
        ]);
    }

    public function readParameters()
    {
        parent::readParameters();

        if (isset($_REQUEST['id'])) $this->awardID = intval($_REQUEST['id']);
        $this->award = new Award($this->awardID);
        if (!$this->award->awardID) {
            throw new IllegalLinkException();
        }
    }

    public function readFormParameters()
    {
        parent::readFormParameters();

        if (isset($_POST['username'])) $this->username = StringUtil::trim($_POST['username']);
        if (isset($_POST['tierID'])) $this->tierID = intval(StringUtil::trim($_POST['tierID']));
        if (isset($_POST['description'])) $this->description = StringUtil::trim($_POST['description']);
        if (isset($_POST['date'])) $this->date = StringUtil::trim($_POST['date']);
        if (isset($_POST['notify'])) $this->notify = StringUtil::trim($_POST['notify']);
    }

    public function validate()
    {
        parent::validate();

        if (empty($this->username)) {
            throw new UserInputException('username');
        }
        if (!User::getUserByUsername($this->username)->getUserID()) {
            throw new UserInputException('username', 'invalid');
        }

        if (empty($this->tierID)) {
            throw new UserInputException('tierID');
        }
        if (!AwardTier::getTierByID($this->tierID)) {
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

        $user = User::getUserByUsername($this->username);
        $tier = AwardTier::getTierByID($this->tierID);

        IssuedAward::giveToUser($user, $tier, $this->description, $this->date, $this->notify);
    }
}