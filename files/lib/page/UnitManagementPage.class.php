<?php

namespace wcf\page;

use wcf\data\unit\Unit;
use wcf\data\unit\UnitCache;
use wcf\data\unit\UnitEditor;
use wcf\data\unit\UnitList;
use wcf\system\breadcrumb\Breadcrumb;
use wcf\system\cache\builder\RankCacheBuilder;
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
                'extraData' => $this->getExtraData(),
            ];
        }
    }

    protected function getExtraData()
    {
        if ($_REQUEST['type'] == 'branch' || $_REQUEST['type'] == 'command') {
            $data = ['rankscheme' => $_REQUEST['rankscheme']];
            return json_encode($data);
        }

        return '';
    }

    protected function submit()
    {
        // Validate
        $this->save();

        $this->performAdditionalActions();
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

    protected function performAdditionalActions()
    {
        // Create a new Unit
        if (isset($_REQUEST['action-new'])) {
            $unit = UnitEditor::create([
                'name' => strtoupper(date('dMY hiA')),
                'type' => 'fireteam',
            ]);

            $this->unitID = $unit->unitID;
            return;
        }

        // Delete an existing unit
        if (isset($_REQUEST['action-delete'])) {
            $editor = new UnitEditor(new Unit($this->unitID));

            $editor->delete();

            WCF::getTPL()->assign([
                'deleted' => true,
            ]);
        }
    }

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'allUnits' => UnitCache::getInstance()->getUnits(),
            'activeAccordionID' => $this->unitID,
            'rankBranches' => RankCacheBuilder::getInstance()->getData([], 'branches'),
        ]);
    }
}