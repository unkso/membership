<?php

namespace wcf\system\package\plugin;

use wcf\system\WCF;

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
		$sql = "DELETE FROM 	wcf".WCF_N."_".$this->tableName."
				WHERE 			identifier = ?
								AND packageID = ?";
		$statement = WCF::getDB()->prepareStatement($sql);
		foreach ($items as $item) {
			$statement->execute(array(
				$item['attributes']['identifier'],
				$this->installation->getPackageID()
			));
		}
	}
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::prepareImport()
	 */
	protected function prepareImport(array $data) 
    {
		return array(
			'identifier'      => $data['attributes']['identifier'],
			'displayName'     => $data['elements']['name'],	
			'displayTemplate' => $data['elements']['template'],
			'classPath'       => $data['elements']['class'],
		);
	}
	
	/**
	 * @see	\wcf\system\package\plugin\AbstractXMLPackageInstallationPlugin::findExistingItem()
	 */
	protected function findExistingItem(array $data) 
    {
		$sql = "SELECT 	*
				FROM 	wcf".WCF_N."_".$this->tableName."
				WHERE 	identifier = ?
						AND packageID = ?";
		$parameters = array(
			$data['identifier'],
			$this->installation->getPackageID()
		);
		
        return array(
			'sql' => $sql,
			'parameters' => $parameters,
		);
	}
}
