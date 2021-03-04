<?php

namespace Terrasphere\Core;

// use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

trait DBTableInit
{
    protected function installTables(Setup $setup)
    {
        $this->masteryEnumTable($setup, "save");
        $this->masteryEnumTable($setup, "role");
        $this->masteryEnumTable($setup, "expertise");
        $this->masteryTypeTable($setup);

        $this->masteryTable($setup);

        // etc...
    }

    // Drops all tables for the addon
    protected  function uninstallTables(Setup $setup)
    {
        $setup->schemaManager()->dropTable("xf_terrasphere_core_mastery_save");
        $setup->schemaManager()->dropTable("xf_terrasphere_core_mastery_role");
        $setup->schemaManager()->dropTable("xf_terrasphere_core_mastery_expertise");
        $setup->schemaManager()->dropTable("xf_terrasphere_core_mastery_type");

        $setup->schemaManager()->dropTable("xf_terrasphere_core_mastery");

        // etc...
    }


    /** ----- Table creation methods ----- */
    /** __________________________________ */

    // a defined schema to install the "enum" tables that the mastery needs since they all follow the same
    private  function masteryEnumTable(Setup $setup, string $tableName)
    {
        $setup->schemaManager()->createTable(
            "xf_terrasphere_core_mastery_".$tableName, function (create $table) use ($tableName)
            {
                $table->addColumn($tableName."_id","int")->autoIncrement();
                $table->addColumn("name","varchar",50)->setDefault('');
            }
        );
    }

    private  function masteryTypeTable(Setup $setup)
    {
        $setup->schemaManager()->createTable(
            "xf_terrasphere_core_mastery_type", function (create $table)
            {
                $table->addColumn("mastery_type_id","int")->autoIncrement();
                $table->addColumn("name","varchar",50)->setDefault('');
                $table->addColumn("cap_per_character","int")->setDefault(9999);
            }
        );
    }

    private  function masteryTable(Setup $setup)
    {
        $setup->schemaManager()->createTable(
            "xf_terrasphere_core_mastery", function(create $table) {
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
}