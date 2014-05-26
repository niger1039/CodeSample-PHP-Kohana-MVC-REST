<?php defined('SYSPATH') or die('No direct script access.');

/**
 * API Authentication Controller
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Controller_Auth extends Controller
{
    /**
     * Sign In Action
     * 
     * @url POST /api/auth
     * @output JSON response
     */
    public function action_post()
    {
        // Find user with sent username and password
        // (Password will be hashed inside Model_User
        $user = ORM::factory('user')->login(
            $this->request->post('username'), 
            $this->request->post('password')
        );

        // If user exists
        if ($user->id)
        {
            // Generate new token
            $user->generate_token();
            
            // Saves user in Session
            Session::instance()->set('user', $user);
            
            // Build successful response array
            $response = array(
                            'status' => 'success',
                            'user' => array(
                                'id' => $user->id,
                                'username' => $user->username,
                                'token' => $user->token,
                            )
                        );
        }
        else
        {
            // Build failed response array
            $response =  array(
                            'status' => 'error',
                            'errors' => array(
                                        'password' => 'Invalid credentials'
                                        )
                            );
        }

        // Outputs json response
        $this->output_json($response);
    }
    
    /**
     * User action to check if there's a current session open
     * 
     */
    public function action_get()
    {
        // Check session for active user
        if (($user = Session::instance()->get('user')))
        {
            // Build successful response array
            $response = array(
                            'status' => 'success',
                            'user' => array(
                                'id' => $user->id,
                                'username' => $user->username,
                                'token' => $user->token,
                            )
                        );
        }
        else
        {
            // Build failed response array
            $response =  array(
                            'status' => 'error'
                            );
        }
        
        // Outputs json response
        $this->output_json($response);
    }
    
    /**
     * User Logout
     * 
     * Clears the token in the DB and destroys the session
     */
    public function action_delete()
    {
        // If the User exists, logs him out
        if (Session::instance()->get('user'))
        {
            Session::instance()->get('user')->logout();
        }
        
        // Destroys session
        Session::instance()->destroy();
        
        // Outputs successful json response
        $this->output_json(array('status' => 'success'));
    }
}
