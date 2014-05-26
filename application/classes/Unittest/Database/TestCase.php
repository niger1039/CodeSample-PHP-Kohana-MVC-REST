<?php

abstract class Unittest_Database_TestCase extends Kohana_Unittest_Database_TestCase
{
    // Test database configuration
    protected $_database_connection = 'unit_testing';

    /**
     * Reset the default database configuration.
     */
    public function setUp()
    {
        Database::$default = $this->_database_connection;
        parent::setUp();
    }

    /**
     * Load all test data from tests/data/*.xml
     */
    protected function getDataSet()
    {
        $all_data_set = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet(array());

        $files = Kohana::list_files('tests/data');
        foreach ($files as $file)
        {
            if (substr($file, -4) != '.xml')
                continue;

            $all_data_set->addDataSet($this->createXMLDataSet($file));
        }

        return $all_data_set;
    }
    
    protected function clear_database()
    {
        DB::query(Database::DELETE, "DELETE FROM `users`")->execute();
        DB::query(Database::DELETE, "DELETE FROM `tags`")->execute();
    }
}
