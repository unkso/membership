<?php
namespace wcf\system\package\plugin;
use wcf\system\WCF;
use wcf\system\exception\SystemException;

class UserHistoryTypePackageInstallationPlugin extends AbstractXMLPackageInstallationPlugin 
{
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::$className
	 */
	public $className = 'wcf\data\membership\userhistory\type\UserHistoryTypeEditor';
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::$tagName
	 */
	public $tagName = 'userhistorytype';
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::handleDelete()
	 */
	protected function handleDelete(array $items) 
    {
	}
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::prepareImport()
	 */
	protected function prepareImport(array $data) 
    {
		mail('debug@padarom.io', 'debug', print_r($data, true));
		throw new SystemException("It works! We can now add our own user history types!");
	}
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::findExistingItem()
	 */
	protected function findExistingItem(array $data) 
    {
        return array();
	}
}
