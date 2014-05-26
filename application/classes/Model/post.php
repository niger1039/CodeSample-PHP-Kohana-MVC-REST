<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM Post Model
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Model_Post extends ORM
{

    /**
     * Table name
     * 
     * @var string
     */
    protected $_table_name = 'posts';

    /**
     * Belongs to relationship
     * 
     * @var array
     */
    protected $_belongs_to = array(
        'user' => array()
    );

    /**
     * Has many relationship
     * 
     * @var array
     */
    protected $_has_many = array(
        'comments' => array(),
        'tags' => array(
            'through' => 'posts_tags'
        )
    );
    
    /**
     * 'Load with' will include the relationships in the find query 
     * 
     */
    protected $_load_with = array(
        'user'
    );
    
    /**
     * Validation Rules
     * 
     * @return array
     */
    public function rules()
    {
        return array(
            'title' => array(
                array('not_empty'),
            ),
            'user_id' => array(
                array('not_empty'),
            ),
            'text' => array(
                array('not_empty'),
            )
        );
    }
    
    public function add_tags($raw_tags)
    {
        if ($raw_tags)
        {
            $raw_tags = explode(',',$raw_tags);
            foreach ($raw_tags as $text)
            {
                $text = trim($text);
                
                $tag = ORM::factory('tag',array('text'=>$text));
                if (!$tag->id)
                {
                    $tag->text = $text;
                    $tag->save();
                }
                $this->add('tags',$tag);
            }
        }
    }

}
