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
        $this->rankTable($sm);
        $this->rankSchemaTable($sm);
        $this->rankSchemaMapTable($sm);
        $this->equipmentTable($sm);

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
        $sm->dropTable("xf_terrasphere_core_rank");
        $sm->dropTable("xf_terrasphere_core_rank_schema");
        $sm->dropTable('xf_terrasphere_core_rank_schema_map');
        $sm->dropTable('xf_terrasphere_core_equipment');
        // etc...
    }


    /** ----- Table creation methods ----- */
    /** __________________________________ */

    // a defined schema to install the "enum" tables that the mastery needs since they all follow the same
    private function masteryEnumTable(SchemaManager $sm, string $tableName)
    {
        $sm->createTable(
            "xf_terrasphere_core_mastery_" . $tableName, function (create $table) use ($tableName) {
            $table->addColumn($tableName . "_id", "int")->autoIncrement();
            $table->addColumn("name", "varchar", 50)->setDefault('');
            $table->addColumn("icon_url", "varchar", 999)->setDefault('');
        }
        );
    }

    private function masteryTypeTable(SchemaManager $sm)
    {
        $sm->createTable(
            "xf_terrasphere_core_mastery_type", function (create $table) {
            $table->addColumn("mastery_type_id", "int")->autoIncrement();
            $table->addColumn("name", "varchar", 50)->setDefault('');
            $table->addColumn("cap_per_character", "int")->setDefault(9999);
            $table->addColumn("icon_url", "varchar", 999)->setDefault('');
            $table->addColumn("system_type", "tinyint")->setDefault('0'); //boolean
            $table->addColumn('cost_modifier', "float")->setDefault('1');
            $table->addColumn('rank_schema_id', "int")->setDefault('1');
        }
        );
    }

    private function rankTable(SchemaManager $sm)
    {
        $sm->createTable(
            "xf_terrasphere_core_rank", function (create $table) {
            $table->addColumn("rank_id", "int")->autoIncrement();
            $table->addColumn('name', 'varchar', 10);
            $table->addColumn('color', 'varchar', 20);
            $table->addColumn('tier', 'int');
        }
        );
    }

    private function rankSchemaTable(SchemaManager $sm)
    {
        $sm->createTable(
            "xf_terrasphere_core_rank_schema", function (create $table) {
            $table->addColumn("rank_schema_id", "int")->autoIncrement();
            $table->addColumn('name', 'varchar', 50)->setDefault('');
            $table->addColumn("currency_id", "int");
        }
        );
    }

    private function rankSchemaMapTable(SchemaManager $sm)
    {
        $sm->createTable(
            "xf_terrasphere_core_rank_schema_map", function (create $table) {
            $table->addColumn("rank_schema_id", "int");
            $table->addColumn('rank_id', 'int');
            $table->addColumn('cost','int')->setDefault(0);
            $table->addPrimaryKey(['rank_schema_id', 'rank_id']);
        }
        );
    }

    private function masteryTable(SchemaManager $sm)
    {
        $sm->createTable(
            "xf_terrasphere_core_mastery", function (create $table) {
            $table->addColumn("mastery_id", "int")->autoIncrement();
            $table->addColumn("save_id", "int");
            $table->addColumn("role_id", "int");
            $table->addColumn("expertise_id", "int");
            $table->addColumn("mastery_type_id", "int");
            $table->addColumn("display_name", "varchar", 50)->setDefault('');
            $table->addColumn("icon_url", "varchar", 999)->setDefault('');
            $table->addColumn("thumbnail_url", "varchar", 999)->setDefault('');
            $table->addColumn("wiki_url","varchar",999)->setDefault('');
            $table->addColumn("color", "varchar", 10)->setDefault('#FFFFFFFF');
        }
        );
    }

    protected function equipmentTable(SchemaManager $sm){
        $sm->createTable(
            "xf_terrasphere_core_equipment", function (create $table) {
                $table->addColumn('equipment_id', 'int')->autoIncrement();
                $table->addColumn('display_name', 'varchar', 50)->setDefault('');
                $table->addColumn('icon_url', 'varchar',999)->setDefault('');
                $table->addColumn('equip_group', 'varchar', 50)->setDefault('');
                $table->addColumn('rank_schema_id', 'int');
        }
        );
    }
}