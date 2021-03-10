<?php

namespace Terrasphere\Core;

// use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;
use XF\Db\SchemaManager;

trait DBTableInit
{
    protected function installTables(SchemaManager $sm)
    {
        $this->masteryEnumTable($sm, "save");
        $this->masteryEnumTable($sm, "role");
        $this->masteryEnumTable($sm, "expertise");
        $this->masteryTypeTable($sm);

        $this->masteryTable($sm);

        // etc...
    }

    // Drops all tables for the addon
    protected function uninstallTables(SchemaManager $sm)
    {
        $sm->dropTable("xf_terrasphere_core_mastery_save");
        $sm->dropTable("xf_terrasphere_core_mastery_role");
        $sm->dropTable("xf_terrasphere_core_mastery_expertise");
        $sm->dropTable("xf_terrasphere_core_mastery_type");

        $sm->dropTable("xf_terrasphere_core_mastery");

        // etc...
    }


    /** ----- Table creation methods ----- */
    /** __________________________________ */

    // a defined schema to install the "enum" tables that the mastery needs since they all follow the same
    private function masteryEnumTable(SchemaManager $sm, string $tableName)
    {
        $sm->createTable(
            "xf_terrasphere_core_mastery_".$tableName, function (create $table) use ($tableName)
            {
                $table->addColumn($tableName."_id","int")->autoIncrement();
                $table->addColumn("name","varchar",50)->setDefault('');
            }
        );
    }

    private function masteryTypeTable(SchemaManager $sm)
    {
        $sm->createTable(
            "xf_terrasphere_core_mastery_type", function (create $table)
            {
                $table->addColumn("mastery_type_id","int")->autoIncrement();
                $table->addColumn("name","varchar",50)->setDefault('');
                $table->addColumn("cap_per_character","int")->setDefault(9999);
            }
        );
    }

    private function masteryTable(SchemaManager $sm)
    {
        $sm->createTable(
            "xf_terrasphere_core_mastery", function(create $table) {
                $table->addColumn("mastery_id","int")->autoIncrement();
                $table->addColumn("save_id","int");
                $table->addColumn("role_id","int");
                $table->addColumn("expertise_id","int");
                $table->addColumn("mastery_type_id","int");
                $table->addColumn("display_name","varchar",50)->setDefault('');;
                $table->addColumn("icon_url","varchar",200)->setDefault('');
                $table->addColumn("thumbnail_url","varchar",200)->setDefault('');
            }
        );
    }
}