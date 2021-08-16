<?php

namespace Terrasphere\Core;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;

///Questions
/// TODO: Each column needs a defaultValue(?) according to the docs, though looking at the dragonByteCurrency it doesn't do that
class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;
	use DBTableInit;
    use DBTableFill;

	//call this to execute all installSteps
	public function installStep1()
    {
        // Initializes all tables for the addon
        $this->installTables($this->schemaManager());
        $this->db();
    }

    public function installStep2(){
        $this->fillMasteryEnumTables($this);
    }



    public function uninstallStep1()
    {
        // Drops all tables from the addon
	    $this->uninstallTables($this->schemaManager());
    }

    ### UPDATE STUFF ###
    public function upgrade1000100Step1(){
	    $this->equipmentTable($this->schemaManager());
        $this->populateEquipStuff($this);
    }

}