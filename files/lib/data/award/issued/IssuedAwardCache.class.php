<?php
namespace wcf\data\award\issued;

use wcf\system\cache\builder\IssuedAwardCacheBuilder;
use wcf\system\SingletonFactory;

class IssuedAwardCache extends SingletonFactory
{
    protected $cachedAwards = [];

    protected function init()
    {
        $this->cachedAwards = IssuedAwardCacheBuilder::getInstance()->getData(array(), 'awards');
    }

    public function getAwards()
    {
        return $this->cachedAwards;
    }
}