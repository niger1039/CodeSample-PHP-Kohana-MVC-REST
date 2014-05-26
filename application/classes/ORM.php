<?php defined('SYSPATH') OR die('No direct script access.');

class ORM extends Kohana_ORM
{

    /**
     * Updates or Creates the record depending on loaded()
     *
     * @chainable
     * @param  Validation $validation Validation object
     * @return ORM
     */
    public function save(\Validation $validation = NULL)
    {
        $return = parent::save($validation);

        $this->after_save();

        return $return;
    }

    /**
     * Executes after save()
     *
     */
    protected function after_save()
    {
        
    }

}
