<?php

namespace Terrasphere\Core;

use FG\ASN1\Universal\Integer;
use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use Terrasphere\Core\DBTableInit;

///Questions
/// TODO: Each column needs a defaultValue(?) according to the docs, though looking at the dragonByteCurrency it doesn't do that
class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	//call this to execute all installSteps
	public function installStep1()
    {
        // Initializes all tables for the addon
        DBTableInit::installTables($this);
    }

    public function uninstallStep1()
    {
        // Drops all tables from the addon
	    DBTableInit::uninstallTables($this);
    }
}