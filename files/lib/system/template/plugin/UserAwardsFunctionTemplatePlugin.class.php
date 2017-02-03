<?php

namespace wcf\system\template\plugin;

use wcf\data\award\issued\IssuedAward;
use wcf\data\user\User;
use wcf\system\template\TemplateEngine;

class UserAwardsFunctionTemplatePlugin implements IFunctionTemplatePlugin
{
    public function execute($tagArgs, TemplateEngine $tplObj)
    {
        $user = new User($tagArgs['userID']);
        $awards = IssuedAward::getAllAwardedTiersForUser($user);

        if ($tagArgs['assign'] !== null) {
            $tplObj->assign($tagArgs['assign'], $awards);
        }

        return '';
    }
}
