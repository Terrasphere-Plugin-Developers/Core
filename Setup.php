<?php

namespace Terrasphere\Core;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;

use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

///Questions
/// TODO: Each column needs a defaultValue(?) according to the docs, though looking at the dragonByteCurrency it doesn't do that
/// TODO: what does "addKey" even do? Neither primary nor foreign???
class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

	//call this to execute all installSteps
	public function installStep1(){
        $this->installEnumMasteryTables();
        $this->installMasteryTable();
    }


    //calls a bunch of installEnumMasteryTable
    //TODO type has a max field and Normal or Enhance?
    public function installEnumMasteryTables(){
	    $this->installEnumMasteryTable("save");
        $this->installEnumMasteryTable("role");
        $this->installEnumMasteryTable("expertise");
        $this->installEnumMasteryTable("type");
    }


    /// a defined schema to install the "enum" tables that the mastery needs since they all follow the same
    private function installEnumMasteryTable(string $tableName){
	    $this->schemaManager()->createTable(
	        "xf_terrasphere_core_mastery_".$tableName, function (create $table) use ($tableName)
            {
                $table->addColumn($tableName."_id","int")->autoIncrement();
                $table->addColumn("name","varchar",50)->setDefault('');
            }
        );
    }

    //creates the Mastery table
    private function installMasteryTable(){
	    $this->schemaManager()->createTable(
	        "xf_terrasphere_core_mastery", function(create $table){
	            $table->addColumn("mastery_id","int")->autoIncrement();
	            $table->addColumn("save_id","int");
                $table->addColumn("role_id","int");
                $table->addColumn("expertise_id","int");
                $table->addColumn("type_id","int");
                $table->addColumn("display_name","varchar",50)->setDefault('');;
                $table->addColumn("icon_url","varchar",200)->setDefault('');
                $table->addColumn("thumbnail_url","varchar",200)->setDefault('');
            }
        );
    }


    //just drops all the tables we created
    public function uninstallStep1(){
	    $this->schemaManager()->dropTable("xf_terrasphere_core_mastery");
        $this->schemaManager()->dropTable("xf_terrasphere_core_mastery_save");
        $this->schemaManager()->dropTable("xf_terrasphere_core_mastery_role");
        $this->schemaManager()->dropTable("xf_terrasphere_core_mastery_expertise");
        $this->schemaManager()->dropTable("xf_terrasphere_core_mastery_type");

    }
}