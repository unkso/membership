<?php

namespace wcf\data\membership\userhistory;

use wcf\data\award\Award;

class AwardReceivedHistory extends BasicUserHistory
{
	protected static $identifier = 'unkso.award';
        
    protected function getAttributeList()
    {
        return [
            'award',        // Which award was awarded? (ID)
            'description',  // Why has this person received this award?
        ];
    }
    
    public function setAward(Award $award)
    {
        $indexName = Award::getDatabaseTableIndexName(); // Should be 'awardID'
        $this->attributes['award'] = $award->$indexName;
    }
    
    public function setAwardDescription($description)
    {
        $this->attributes['description'] = $description;
    }
    
    public function getAward()
    {
        if (!isset($this->attributes['award'])) {
            return null;
        }
        
        return new Award($this->attributes['award']);
    }
    
    public function getAwardDescription()
    {
        if (!isset($this->attributes['description'])) {
            return null;
        }
        
        return $this->attributes['description'];
    }
}