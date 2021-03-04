<?php

namespace Terrasphere\Core;

// use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class DBTableInit
{
    public static function installTables(Setup $setup)
    {
        self::masteryEnumTable($setup, "save");
        self::masteryEnumTable($setup, "role");
        self::masteryEnumTable($setup, "expertise");
        self::masteryTypeTable($setup);

        self::masteryTable();

        // etc...
    }

    // Drops all tables for the addon
    public static function uninstallTables(Setup $setup)
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
    private static function masteryEnumTable(Setup $setup, string $tableName)
    {
        $setup->schemaManager()->createTable(
            "xf_terrasphere_core_mastery_".$tableName, function (create $table) use ($tableName)
            {
                $table->addColumn($tableName."_id","int")->autoIncrement();
                $table->addColumn("name","varchar",50)->setDefault('');
            }
        );
    }

    private static function masteryTypeTable(Setup $setup)
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

    private static function masteryTable(Setup $setup)
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