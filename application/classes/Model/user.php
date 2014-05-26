<?php defined('SYSPATH') or die('No direct script access.');

/**
 * ORM Comment Model
 * 
 * @author Agustin Vijoditz <vijo.agus@gmail.com>
 * @on May 1st, 2014
 * @package BlogDemoKohana
 * @license http://www.gnu.org/copyleft/gpl.html    GPL v3
 */
class Model_User extends ORM
{

    /**
     * Table name
     * 
     * @var string
     */
    protected $_table_name = 'users';

    /**
     * Has many relationship
     * 
     * @var array
     */
    protected $_has_many = array(
        'posts' => array(),
        'comments' => array(),
    );

    /**
     * Validation Rules
     * 
     * @return array
     */
    public function rules()
    {
        // Since this is a demo, users can't update their credentials and the rules
        // will only apply to new users.
        if (!$this->id)
        {
            return array(
                'email' => array(
                    array('not_empty'),
                    array('email'),
                    array(array($this, 'is_unique'), array(':field', ':value'))
                ),
                'username' => array(
                    array('not_empty'),
                    array('min_length', array(':value', 4)),
                    array(array($this, 'is_unique'), array(':field', ':value'))
                ),
                'password' => array(
                    array('not_empty')
                )
            );
        }
        return array();
    }

    /**
     * Custom made rule to prevent duplication of users with any field. 
     * (currently used only by username and emal)
     * 
     * @todo This rule should be moved to modules/orm/classes/ORM.php
     * @param string $field     User table column
     * @param string $value     
     * @return bool
     */
    public function is_unique($field, $value)
    {
        // Queries the model's table doing a count for each row 
        // with $field=$value and returns a bool to be used by
        // the Validation class
        return !(bool) DB::select(array(DB::expr('COUNT(id)'), 'total'))
                        ->from($this->_table_name)
                        ->where($field, '=', $value)
                        ->execute()
                        ->get('total');
    }
    
    /**
     * User login. If the login is successful, the current object will be set
     * as the logged user.
     * 
     * Includes logic to hash passwords
     * 
     * @chainable
     * @param string $username
     * @param string $password      Raw password
     * @return \Model_User
     */
    public function login($username, $password)
    {
        // Queries the DB with the $username and the hash $password
        $this->where('username', '=', $username)
                ->where('password', '=', self::hash_password($password))
                ->find();

        // If the user exists, generates a new authentication token
        if ($this->id)
        {
            $this->generate_token();
        }
        
        // Since this is a chainable method, return the current object
        return $this;
    }

    /**
     * Clears the user's authentication token
     * 
     */
    public function logout()
    {
        $this->token = null;
        $this->save();
    }

    /**
     * Generates authentication token for the current user
     * 
     */
    public function generate_token()
    {
        // Generates a unique hash as the authentication token
        $token = password_hash(uniqid('', true), PASSWORD_BCRYPT);
        
        // Assigns the token to the current user and saves it
        $this->token = $token;
        $this->save();
    }
    
    /**
     * Finds user by token. If the search is successful, the user's info will 
     * be set to the current user.
     * 
     * @chainable
     * @param string $token
     * @return \Model_User
     */
    public function find_by_token($token)
    {
        // Queries the DB with the sent $token
        $this->where('token', '=', $token)
                ->find();

        // Since this is a chainable method, return the current object
        return $this;
    }

    /**
     * Hash Password helper. All the hash logic will be held in this method.
     * 
     * @param string $password      RAW password
     * @return string               HASH password
     */
    static public function hash_password($password)
    {
        // Generates HASH password
        return password_hash($password, PASSWORD_BCRYPT, array(
            'cost' => 11,
            'salt' => Cookie::$salt
        ));
    }
    
    /**
	 * Returns the values of this object as an array, including any related one-one
	 * models that have already been loaded using with()
     * 
     * This method removes Model_User->password for security purposes.
	 *
	 * @return array
	 */
	public function as_array()
    {
        // Gets array from parent
        $array = parent::as_array();
        
        // Removes the 'password' from array for security purposes.
        unset($array['password']);
        
        // Returns data
        return $array;
    }

}
