<?php defined('SYSPATH') or die('No direct access allowed!');
  
/**
 * User Model Unit Test
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class UserTest extends Unittest_Database_TestCase
{
    /**
     * Simple ORM Class Test
     */
    public function test_class()
    {
        $this->assertInstanceOf('Model_User', ORM::factory('user'));
    }

    /**
     * Tests not_empty Save rules
     */
    public function test_rules_not_empty()
    {
        // Tries to save a user that shouldn't validate:
        //    email->not_empty
        //    username->not_empty
        //    password->not_empty
        try {
            ORM::factory('user')->values(array(
                'email' => '',
                'username' => '',
                'password' => ''
            ))->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors();
        }
        
        // Test if there is a 'not_empty' error in the validation if 'email'
        $this->assertTrue(isset($errors['email']) && $errors['email'][0] === 'not_empty');
        
        // Test if there is a 'not_empty' error in the validation if 'username'
        $this->assertTrue(isset($errors['username']) && $errors['username'][0] === 'not_empty');
        
        // Test if there is a 'not_empty' error in the validation if 'password'
        $this->assertTrue(isset($errors['password']) && $errors['password'][0] === 'not_empty');
    }

    /**
     * Tests not_empty Save rules
     */
    public function test_rules_other()
    {
        // Tries to save a user that shouldn't validate:
        //    email->email
        //    username->min_length
        try {
            ORM::factory('user')->values(array(
                'email' => 'not-an-email',
                'username' => 'a',
                'password' => 'password'
            ))->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors();
        }

        // Test if there is a 'email' error in the validation if 'email'
        $this->assertTrue(isset($errors['email']) && $errors['email'][0] === 'email');
        
        // Test if there is a 'min_length' error in the validation if 'username'
        $this->assertTrue(isset($errors['username']) && $errors['username'][0] === 'min_length');
        
        // Test if there wasn't a password error
        $this->assertNotContains('password', $errors);
    }

    /**
     * Tests not_empty Save rules
     */
    public function test_rules_is_unique()
    {
        // Clears the database
        $this->clear_database();

        // Generates a test data $array to create users in this test
        $test_data = array(
            'email' => 'a@example.com',
            'username' => 'username',
            'password' => 'password'
        );
        
        // Tries to create a user with the test data
        try {
            ORM::factory('user')
                    ->values($test_data)
                    ->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
        }
        
        // Test if there were errors during the previous save
        $this->assertFalse(isset($errors));

        // Tries to create a second user with the same test data expecting to fail
        try {
            ORM::factory('user')
                    ->values($test_data)
                    ->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors();
        }

        // Test if there is a 'is_unique' error in the validation if 'email'
        $this->assertTrue(isset($errors['email']) && $errors['email'][0] === 'is_unique');
        
        // Test if there is a 'is_unique' error in the validation if 'username'
        $this->assertTrue(isset($errors['username']) && $errors['username'][0] === 'is_unique');
        
        // Test if the tested 2 errors were the only 2 errors
        $this->assertCount(2, $errors);
    }

    /**
     * Tests Model_User->login() and Model_User->logout()
     */
    public function test_login_logout()
    {
        // Clears the database
        $this->clear_database();

        // Generates a password to use in this test
        $password = 'password';
        
        // Generates a test data $array to create users in this test
        $test_data = array(
            'email' => 'a@example.com',
            'username' => 'username',
            'password' => Model_User::hash_password($password)
        );

        // Tries to create an initial user with the test data
        try {
            $initial_user = ORM::factory('user')
                    ->values($test_data)
                    ->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
        }
        
        // Test if there were errors during the previous save
        $this->assertFalse(isset($errors));

        // Generates a new user by login in with the test data
        $user = ORM::factory('user')
                ->login($test_data['username'], $password);
        
        // Tests if the new user is the same than the initial one
        $this->assertEquals($initial_user->id, $user->id);
        
        // Tests if the token is not empty (meaning that 
        // Model_User->generate_token() was successfully executed) 
        $this->assertNotEmpty($user->token);

        // Executes Model_User->logout()
        $user->logout();
        
        // Tests if Model_User->token was successfully cleared
        $this->assertEmpty($user->token);
    }

    /**
     * Tests Model_User->find_by_token()
     */
    public function test_find_by_token()
    {
        // Clears the database
        $this->clear_database();

        // Generates an initial user with valid data
        $initial_user = ORM::factory('user')->values(array(
            'email' => 'a@example.com',
            'username' => 'username',
            'password' => Model_User::hash_password('password')
        ));
        
        // Tries to save the initial user
        try {
            $initial_user->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
        }
        
        // Test if there were errors during the previous save
        $this->assertFalse(isset($errors));
        
        // Generates a token in the initial user
        $initial_user->generate_token();

        // Finds a new user with the generated token expecting to be the same one
        $new_user = ORM::factory('user')
                ->find_by_token($initial_user->token);

        // Tests if the initial user is the same than the new user
        $this->assertEquals($initial_user->id, $new_user->id);
    }

    /**
     * Tests Model_User->as_array() that will execute its parent ORM::as_array()
     */
    public function test_as_array()
    {
        // Clears the database
        $this->clear_database();

        // Generates a user with test data
        $user = ORM::factory('user')->values(array(
            'email' => 'a@example.com',
            'username' => 'username',
            'password' => Model_User::hash_password('password')
        ));
        
        // Tries to save the user
        try {
            $user->save();
        } catch (ORM_Validation_Exception $e) {
            $errors = $e->errors('models');
        }
        
        // Test if there were errors during the previous save
        $this->assertFalse(isset($errors));

        // Executes Model_User->as_array()
        $array = $user->as_array();

        // Tests if the 'password' is not included in the array
        $this->assertNotContains('password', $array);
    }

}
