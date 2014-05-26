<?php defined('SYSPATH') or die('No direct access allowed!');
  
/**
 * Post Model Unit Test
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class PostTest extends Unittest_Database_TestCase
{
    /**
     * Simple ORM Class Test
     */
    public function test_class()
    {
        $this->assertInstanceOf('Model_Post', ORM::factory('post'));
    }
    
    /**
     * Tests Save rules
     */
    public function test_rules_not_empty()
    {
        // Tries to save a comment that shouldn't validate:
        //    user_id->not_empty
        //    title->not_empty
        //    text->not_empty
        try {
            ORM::factory('post')->values(array(
                'user_id' => '',
                'title' => '',
                'text' => ''
            ))->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors();
        }
        
        // Test if there is a 'not_empty' error in the validation if 'user_id'
        $this->assertTrue(isset($errors['user_id']) && $errors['user_id'][0] === 'not_empty');
        
        // Test if there is a 'not_empty' error in the validation if 'title'
        $this->assertTrue(isset($errors['title']) && $errors['title'][0] === 'not_empty');
        
        // Test if there is a 'not_empty' error in the validation if 'text'
        $this->assertTrue(isset($errors['text']) && $errors['text'][0] === 'not_empty');
    }

    /**
     * Tests Model_Post->add_tags()
     * 
     */
    public function test_add_tags()
    {
        // Clears the database
        $this->clear_database();

        // Gets a $user for the test
        $user = $this->get_user();

        // Generates a $psot that shouldn't fail any test
        $post = ORM::factory('post')->values(array(
            'user_id' => $user->id,
            'title' => 'title',
            'text' => 'text',
        ));

        // Saves the post
        try {
            $post->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors();
        }
        
        // Test if there were errors during the previous save
        $this->assertFalse(isset($errors));

        // Generates an array with tags' info
        $tags = array('tag1', 'tag2');
        
        // Executes Model_Post->add_tags
        $post->add_tags(implode(',', $tags));

        // Tests if the 2 tags were added to the post
        $this->assertCount(2, $post->tags->find_all());
        
        // Iterates the post's tags and remove them from the previously 
        // generated $tags array to ensure all of them were added
        foreach ($post->tags->find_all() as $tag)
        {
            if (FALSE !== ($key = array_search($tag->text, $tags)))// Removes the tags from the $tags array
            {
                unset($tags[$key]);
            }
        }
        
        // Test if the info array is empty, meaning that all the tags were 
        // added to the post
        $this->assertEmpty($tags);
    }

    /**
     * Inserts a $user in the DB and returns the Model
     * 
     * @return \Model_User
     */
    protected function get_user()
    {
        // Generates a $user with valid data to ensure it won't fail the validation
        return ORM::factory('user')->values(array(
                    'email' => "a@example.com",
                    'username' => 'username',
                    'password' => 'password'
                ))->save();
    }

}