<?php
/**
 * Created by PhpStorm.
 * User: huw
 * Date: 26/08/2017
 * Time: 11:19
 */

namespace SUSC\Form;


use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class LoginForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema
            ->addField('email_address', 'string')
            ->addField('password', 'string')
            ->addField('remember', 'boolean');
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }

}