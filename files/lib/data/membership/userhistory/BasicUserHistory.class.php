<?php
namespace wcf\data\membership\userhistory;

use wcf\data\DatabaseObject;
use wcf\system\WCF;
use wcf\system\template\TemplateScriptingCompiler;
use wcf\system\template\TemplateEngine;
use wcf\data\membership\userhistory\type\UserHistoryType;
use wcf\data\membership\Membership;

class BasicUserHistory extends DatabaseObject
{
	protected static $databaseTableName = 'unkso_user_history';
	
	protected static $databaseTableIndexName = 'historyID';
	
	protected static $identifier = 'a.b';
	
	public $attributes = [];
	
	final protected function getPresetTemplateAttributes()
	{
		return [
			'_username' => $this->getMembership()->getUser()->username,
			'_rank' => $this->getMembership()->getRankAtTime($this->date),
			'_date' => $this->date,
		];
	}
	
	protected function handleData($data)
	{
		parent::handleData($data);
		
		$this->attributes = json_decode($data['metadata'], true);
		
		// If json_decode fails we still want to have an (empty) array.
		if (is_null($this->attributes)) {
			$this->attributes = [];
		}
	}
	
	final protected function verifyAttributePresence()
	{
		$difference = array_diff($this->getAttributeList(), array_keys($this->attributes));
		
		return !count($difference);
	}
	
	protected function getAttributeList() 
	{
		return [];	
	}
	
	public function getHistoryType()
	{
		return new UserHistoryType($this->historyTypeID);
	}
	
	// Used by the template engine
	protected $v = [];
	
	public function getDescription()
	{
		$compiler = new TemplateScriptingCompiler(WCF::getTPL());
		
		$indexName = self::getDatabaseTableIndexName();
		$templateIdentifier = self::getIdentifier() . '.' . $this->$indexName;
		
		$this->v = array_merge(
			$this->getPresetTemplateAttributes(),
			$this->attributes
		);
		
		$template = $this->getHistoryType()->displayTemplate;
		$resultingTemplate = $compiler->compileString($templateIdentifier, $template)['template'];
		
		// Remove opening PHP Tag
		if (substr(trim($resultingTemplate), 0, 5) == '<?php') {
			$resultingTemplate = substr(trim($resultingTemplate), 5);
		}
		
		// This part is disgusting, but there's nothing we can do about it, without
		// using the TemplateCompiler and saving all small bits to their own file.
		// https://community.woltlab.com/thread/248610-templateengine-für-eigene-plugins-verwenden/?postID=1523549
		ob_start();
		eval($resultingTemplate);
		$content = ob_get_contents();
		ob_end_clean();
		
		return $content;
	}
	
	public function getMembership()
	{
		return new Membership($this->membershipID);
	}
	
	public static function getIdentifier()
	{
		return static::$identifier;
	}
	
	public static function getAllUserHistoryEntries()
	{
		
	}
    
    public static function getAllForUser()
    {
        
    }
}