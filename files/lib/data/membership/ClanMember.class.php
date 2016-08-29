<?php namespace wcf\data\membership;

use wcf\data\DatabaseObjectDecorator;
use wcf\data\user\User;
use wcf\system\WCF;

class ClanMember extends DatabaseObjectDecorator
{
    protected static $baseClass = User::class;

    /**
     * @var User
     */
    protected $object;

    public function getCurrentMembership()
    {
        $user = $this->object;

        $tableName = Membership::getDatabaseTableName();

        $sql = "SELECT	*
				FROM	$tableName
				WHERE	userID = ?
				ORDER BY membershipID DESC LIMIT 1";

        $statement = WCF::getDB()->prepareStatement($sql);

        $statement->execute([$user->getUserID()]);
        $row = $statement->fetchObject(Membership::class);

        return $row;
    }
}