<?php

namespace Terrasphere\Core;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\SchemaManager;

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

    ### UPDATE STUFF  VERSION 1.0.1###
    public function upgrade1000100Step1(){
	    $this->equipmentTable($this->schemaManager());
        $this->populateEquipStuff($this);
    }

    ### UPDATE STUFF  VERSION 1.0.2###
    public function upgrade1000200Step1(){
	    $sm = $this->schemaManager();
        $this->alterTypeTable($sm,"save");
        $this->alterTypeTable($sm,"role");
        $this->alterTypeTable($sm,"expertise");

    }

    public function upgrade1000300Step1() {
        $this->bannerButtonTable($this->schemaManager());
        $this->populateBannerButtons($this);
    }

    private function alterTypeTable(SchemaManager $sm, string $name){
        $sm->alterTable("xf_terrasphere_core_mastery_" . $name, function (Alter $table){
            $table->dropColumns("icon_url");
            $table->addColumn("css_classes","varchar",999)->setDefault('');
            $table->addColumn("hex_color","varchar",7)->setDefault('#fff');
        });
    }

}