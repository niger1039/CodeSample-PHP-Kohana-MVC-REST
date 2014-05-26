<?php defined('SYSPATH') or die('No direct access allowed!');
  
/**
 * Tag Model Unit Test
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class TagTest extends Unittest_Database_TestCase
{
    /**
     * Simple ORM Class Test
     */
    public function test_class()
    {
        $this->assertInstanceOf('Model_Tag', ORM::factory('tag'));
    }

    /**
     * Test simple insert
     */
    public function test_simple_insert()
    {
        // Instanciates a new Model_Tag and sets 'text' attribute.
        $tag = ORM::factory('tag')
                ->values(array('text' => 'tag1'));

        // Tries to save the $tag
        try {
            $tag->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors();
        }
        
        // Test if there were errors during the previous save
        $this->assertFalse(isset($errors));

        // Test if the $tag has an id
        $this->assertInternalType('numeric', $tag->id);
    }

}