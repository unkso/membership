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
use wcf\form\FormBuilder;
use wcf\data\award\action\AwardAction;
use wcf\system\cache\builder\AwardCacheBuilder;
use wcf\system\exception\IllegalLinkException;
use wcf\system\WCF;

class AssignAwardForm extends FormBuilder
{
    public $activeMenuItem = 'wcf.acp.menu.link.clan.award.list';

    public $neededPermissions = ['admin.clan.award.canIssueAwards'];

    public $requiresValidObject = false;

    protected $award;

    public function getAttributes()
    {
        return [
            'tierID' => [
                'type' => 'int',
                'rule' => 'custom:verifyTier',// class:wcf\\data\\award\\AwardTier',
            ],
            'userID' => [
                'type' => 'int',
                'rule' => 'class:wcf\\data\\user\\User',
            ],
            'date' => [
                'type' => 'string',
                'rule' => 'date',
            ],
            'description' => 'string',
            'sendMessage' => [
                'type' => 'bool',
                'required' => false,
            ]
        ];
    }

    protected function verifyTier($value)
    {
        $tier = new AwardTier($value);

        echo "<pre>";
        var_dump($tier);
        echo "</pre>";
        die();
    }

    protected function getObjectActionType()
    {
        return IssuedAwardAction::class;
    }

    protected function getObjectTypeName()
    {
        return IssuedAward::class;
    }

    public function readParameters()
    {
        parent::readParameters();

        $user = WCF::getUser();
        IssuedAward::getAwardsForUser($user);

        $this->award = new Award(intval($_REQUEST['id']));

        if (!$this->award->awardID) {
            throw new IllegalLinkException();
        }
    }

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'award' => $this->award,
        ]);
    }
}