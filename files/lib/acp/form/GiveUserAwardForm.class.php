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

    /**
     * Whether the user has confirmed extraordinary changes
     * @var bool
     */
    public $confirm = false;

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'action' => 'add',
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
        if (isset($_POST['confirm'])) $this->confirm = StringUtil::trim($_POST['confirm']);
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

        if ($this->userHasTierAlready()) {
            throw new UserInputException('tierID', 'existing');
        }

        if (($tierError = $this->tierDoesNotMatch()) && !$this->confirm) {
            WCF::getTPL()->assign('confirm', true);
            throw new UserInputException('tierID', $tierError);
        }
    }

    protected function tierDoesNotMatch()
    {
        $givenAward = $this->tier->awardID;
        $givenLevel = $this->tier->level;

        $tiers = IssuedAward::getHighestAwardedTiersForUser($this->user);
        $tiers = array_map(function ($issued) { return $issued->getTier(); }, $tiers);

        // If user doesn't have any tier of the award, return
        if (!isset($tiers[$givenAward]) && $givenLevel == 1) return false;

        // User doesn't have the award, but high level is to be given
        if (!isset($tiers[$givenAward]) && $givenLevel > 1) {
            return 'skip.null';
        }

        $receivedLevel = $tiers[$givenAward]->level;

        // Already has a higher tier
        if ($receivedLevel > $givenLevel) {
            return 'higher';
        }

        // Highest existing tier is more than one smaller
        if ($givenLevel > $receivedLevel && abs($givenLevel - $receivedLevel) > 1) {
            return 'skip';
        }

        return false;
    }

    protected function userHasTierAlready()
    {
        $tiers = IssuedAward::getAllAwardedTiersForUser($this->user);
        foreach ($tiers as $tier) {
            if ($tier->tierID == $this->tierID) {
                return true;
            }
        }

        return false;
    }

    public function save()
    {
        parent::save();

        $user = $this->user;
        $tier = $this->tier;

        IssuedAward::giveToUser($user, $tier, $this->description, $this->date, $this->notify);
        $this->saved();

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