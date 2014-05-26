<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM Comment Model
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Model_Comment extends ORM
{

    /**
     * Table name
     * 
     * @var string
     */
    protected $_table_name = 'comments';

    /**
     * Belongs to relationship
     * 
     * @var array
     */
    protected $_belongs_to = array(
        'post' => array(),
        'user' => array()
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
            'user_id' => array(
                array('not_empty'),
            ),
            'post_id' => array(
                array('not_empty'),
            ),
            'text' => array(
                array('not_empty'),
            )
        );
    }

}
