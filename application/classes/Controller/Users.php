<?php defined('SYSPATH') or die('No direct script access.');

/**
 * API Users Controller
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Controller_Users extends Controller
{
    /**
     * Sign Up Action.
     * It also signs up the user after a successful registration.
     * 
     * @url POST /api/users
     * @output JSON response
     */
    public function action_post()
    {
        // Hashes password if sent
        $password = $this->request->post('password');
        if ($this->request->post('password'))
        {
            $password = Model_User::hash_password($this->request->post('password'));
        }

        // Creates user and sets sent data 
        $user = ORM::factory('user')->values(array(
            'email' => $this->request->post('email'),
            'username' => $this->request->post('username'),
            'password' => $password
        ));

        // Tries to save the new user and validates the input data
        try
        {
            // Saves user and internally executes validation
            $user->save();
            
            // Generates new token
            $user->generate_token();
            
            // Saves user in Session
            Session::instance()->set('user', $user);
            
            // Build successful response array
            $response = array(
                'status' => 'success',
                'user' => $user->as_array()
            );
        }
        // Catches exception when Validation fails 
        catch (ORM_Validation_Exception $e)
        {
            // Build failed response array
            $response = array(
                'status' => 'error',
                'errors' => $e->errors('models')
            );
        }

        // Outputs json response
        $this->output_json($response);
    }
}
