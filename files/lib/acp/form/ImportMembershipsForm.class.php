<?php
namespace wcf\acp\form;
use wcf\data\membership\MembershipImporter;
use wcf\form\AbstractForm;
use wcf\system\WCF;

class ImportMembershipsForm extends AbstractForm
{
    public $activeMenuItem = 'wcf.acp.menu.link.clan.membership.import';

    public $templateName = 'importMemberships';

    protected $json = '';

    protected $parsedJSON = [];

    protected $jsonError = null;

    protected $success = null;

    public function readParameters()
    {
        parent::readParameters();

        if (isset($_REQUEST['json'])) {
            $this->json = $_REQUEST['json'];
            $this->parsedJSON = json_decode($this->json, true);

            if (json_last_error() != JSON_ERROR_NONE) {
                $this->jsonError = json_last_error_msg();
                $this->parsedJSON = [];
            }
        }

        if (isset($_REQUEST['username']) && isset($_REQUEST['run-import'])) {
            foreach ($_REQUEST['username'] as $k => $name) {
                $this->parsedJSON[$k]['username'] = $name;
            }

            $count = count($this->parsedJSON);
            $this->runImport();

            // Reset values
            $this->json = '';
            $this->jsonError = null;
            $this->parsedJSON = [];

            $this->success = 'Successfully imported ' . $count . ' entries.';
        }
    }

    public function assignVariables()
    {
        parent::assignVariables();

        WCF::getTPL()->assign([
            'importers' => $this->buildImporters(),
            'json' => $this->json,
            'jsonError' => $this->jsonError,
            'success' => $this->success,
        ]);
    }

    protected function runImport()
    {
        $importers = $this->buildImporters();
        foreach ($importers as $importer) {
            $importer->run();
        }
    }

    protected function buildImporters()
    {
        $importers = [];

        foreach ($this->parsedJSON as $importer) {
            $importers[] = new MembershipImporter($importer);
        }

        return $importers;
    }
}
