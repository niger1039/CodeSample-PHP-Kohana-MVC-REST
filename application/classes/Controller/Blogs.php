<?php defined('SYSPATH') or die('No direct script access.');

/**
 * API Blogs Controller
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Controller_Blogs extends Controller_Template
{
    /**
     * Main template layout (Used by Controller_Template)
     * 
     * @var string
     */
    public $template = 'layout/default';

    /**
     * Simple index action that loads the JS templates file
     */
    public function action_index()
    {
        $this->template->templates = View::factory('blogs/templates');
    }
}