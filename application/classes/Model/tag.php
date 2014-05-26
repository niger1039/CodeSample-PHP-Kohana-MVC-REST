<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM Tag Model
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Model_Tag extends ORM
{

    /**
     * Table name
     * 
     * @var string
     */
    protected $_table_name = 'tags';

    /**
     * Has many relationship
     * 
     * @var array
     */
    protected $_has_many = array(
        'posts' => array(
            'through' => 'posts_tags'
        ),
    );
    
}
