<?php
namespace wcf\page;

use wcf\data\unit\Unit;
use wcf\data\unit\UnitCache;
use wcf\data\unit\UnitEditor;
use wcf\data\unit\UnitList;
use wcf\system\breadcrumb\Breadcrumb;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

class UnitManagementPage extends SortablePage
{
    public $activeMenuItem = 'wcf.page.personnel.management.unit';

    public $objectListClassName = UnitList::class;

    protected $unitID;

    protected $savedValues = [];

    public function readData()
    {
        if ($this->activeMenuItem != 'wcf.page.personnel') {
            WCF::getBreadcrumbs()->add(new Breadcrumb(WCF::getLanguage()->get('wcf.page.personnel'), LinkHandler::getInstance()->getLink('Personnel')));
        }

        $this->submit();

        parent::readData();
    }

    public function readParameters()
    {
        parent::readParameters();

        if (isset($_REQUEST['unitID'])) {
            $this->unitID = $_REQUEST['unitID'];

            $this->savedValues = [
                'name' => $_REQUEST['name'],
                'parentID' => $_REQUEST['parentID'],
                'type' => $_REQUEST['type'],
            ];
        }
    }

    protected function submit()
    {
        // Validate
        $this->save();
    }

    protected function save()
    {
        $unit = new Unit($this->unitID);

        if (!$unit->unitID) {
            return;
        }

        $editor = new UnitEditor($unit);
        $editor->update($this->savedValues);

        WCF::getTPL()->assign([
            'success' => true,
        ]);
    }

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'allUnits' => UnitCache::getInstance()->getUnits(),
            'activeAccordionID' => $this->unitID,
        ]);
    }
}