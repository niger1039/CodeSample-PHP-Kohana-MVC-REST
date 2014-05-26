<?php defined('SYSPATH') or die('No direct script access.');

/**
 * API Posts Controller
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Controller_Posts extends Controller
{

    /**
     * Gets all Posts and comments linked to them
     * 
     * @url GET /api/posts
     * @output JSON response
     */
    public function action_get()
    {
        // Generates base array for successful response
        $response = array(
            'status' => 'success',
            'posts' => array()
        );

        // Gets all posts ordered by creation
        $posts = ORM::factory('post')
                ->order_by('created_at', 'DESC')
                ->find_all();

        // Iterate all posts
        if (count($posts))
        {
            foreach ($posts as $post)
            {
                // Add post to successful response array
                $response['posts'][] = $this->format_post_response($post);
            }
        }

        // Outputs json response
        $this->output_json($response);
    }

    /**
     * Creates a new Model_Post
     * 
     * @url POST /api/posts
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
            // Creates post and sets sent data 
            $post = ORM::factory('post')->values(array(
                'user_id' => $user->id,
                'title' => $this->request->post('title'),
                'text' => $this->request->post('text'),
                'created_at' => DB::expr('NOW()')
            ));

            // Tries to save the new post and validates the input data
            try
            {
                // Saves post and internally executes validation
                $post->save();

                // Add tags to post
                $post->add_tags($this->request->post('tags'));

                // Build successful response array
                $response = array_merge(
                        $this->format_post_response($post),
                        array('status' => 'success')
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

    /**
     * Formats a Model_Post into a response array
     * 
     * @param \Model_Post $post
     * @return array
     */
    protected function format_post_response($post)
    {
        // Creates $tags and $commens array
        $tags = array();
        $comments = array();

        // Begins building post data array 
        $response = array(
            'post' => $post->as_array(),
            'tags' => &$tags,
            'comments' => &$comments
        );

        // Gets tags and fills array with texts for output
        foreach ($post->tags->find_all() as $tag)
        {
            $tags[] = $tag->text;
        }

        // Iterates comments
        foreach ($post->comments->find_all() as $comment)
        {
            // Add comment to post data array
            $comments[] = $comment->as_array();
        }

        return $response;
    }

}
