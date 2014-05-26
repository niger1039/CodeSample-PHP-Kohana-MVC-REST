<?php defined('SYSPATH') or die('No direct access allowed!');
  
/**
 * Comment Model Unit Test
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class CommentTest extends Unittest_Database_TestCase
{
    /**
     * Simple ORM Class Test
     */
    public function test_class()
    {
        $this->assertInstanceOf('Model_Comment', ORM::factory('comment'));
    }

    /**
     * Tests Save rules
     */
    public function test_rules_not_empty()
    {
        // Tries to save a comment that shouldn't validate:
        //    user_id->not_empty
        //    post_id->not_empty
        //    text->not_empty
        try {
            ORM::factory('comment')->values(array(
                'user_id' => '',
                'post_id' => '',
                'text' => ''
            ))->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors();
        }

        // Test if there is a 'not_empty' error in the validation if 'user_id'
        $this->assertTrue(isset($errors['user_id']) && $errors['user_id'][0] === 'not_empty');
        
        // Test if there is a 'not_empty' error in the validation if 'post_id'
        $this->assertTrue(isset($errors['post_id']) && $errors['post_id'][0] === 'not_empty');
        
        // Test if there is a 'not_empty' error in the validation if 'text'
        $this->assertTrue(isset($errors['text']) && $errors['text'][0] === 'not_empty');
    }

}
