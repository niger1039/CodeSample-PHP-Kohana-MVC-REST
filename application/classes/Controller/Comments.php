<?php defined('SYSPATH') or die('No direct script access.');

/**
 * API Comments Controller
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Controller_Comments extends Controller
{
    /**
     * Creates a new Model_Comment
     * 
     * @url POST /api/comments
     * @output JSON response
     */
    public function action_post()
    {
        // Finds user with sent token
        $user = ORM::factory('user', array(
                    'token' => $this->request->post('token')
        ));
        
        // If user exists
        if ($user->id)
        {
            // Creates comment and sets sent data 
            $comment = ORM::factory('comment')
                        ->values(array(
                            'user_id' => $user->id,
                            'post_id' => $this->request->post('post_id'),
                            'text' => $this->request->post('text')
                        ));

            // Tries to save the new comment and validates the input data
            try
            {
                // Saves comment and internally executes validation
                $comment->save();
                
                // Ensures that the User is going to be in the return from as_array()
                $comment->user;
        
                // Build successful response array
                $response = array(
                    'status' => 'success',
                    'comment' => $comment->as_array()
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
        }
        else
        {
            // Build failed response array
            $response = array(
                'status' => 'error',
                'errors' => array(
                    'invalid_token'
                )
            );
        }

        // Outputs json response
        $this->output_json($response);
    }

}
