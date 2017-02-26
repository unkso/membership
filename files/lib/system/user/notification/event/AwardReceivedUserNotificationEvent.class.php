<?php namespace wcf\system\user\notification\event;

use wcf\data\award\issued\IssuedAward;
use wcf\system\request\LinkHandler;

class AwardReceivedUserNotificationEvent extends AbstractSharedUserNotificationEvent
{
    /**
     * @var IssuedAward
     */
    protected $issuedAward;

    public function getTitle()
    {
        return $this->getLanguage()->getDynamicVariable('wcf.unkso.award.notification.title');
    }

    public function getMessage()
    {
        $award = $this->issuedAward->getAward();

        // Replace normal " " and "-" with non-breaking versions
        $title = str_replace(' ', '&nbsp;', $award->title);
        $title = str_replace('-', '&#8209;', $title);

        return $this->getLanguage()->getDynamicVariable('wcf.unkso.award.notification.message', [
            'award' => $this->issuedAward,
            'awardTitle' => $title,
            'author' => $this->author,
        ]);
    }

    public function getEmailMessage($notificationType = 'instant')
    {
        return parent::getEmailMessage($notificationType);
    }

    public function getLink()
    {
        return LinkHandler::getInstance()->getLink('User', [
            'object' => $this->author->getUserID(),
        ], '#awards');
    }

    /**
     * Provide specialized handlers with object ids, these ids will be collected and should be
     * read once the first time data is requested from the notification event.
     */
    protected function prepare()
    {
        $issuedAwardID = $this->userNotificationObject->getObjectID();
        $this->issuedAward = new IssuedAward($issuedAwardID);
    }
}