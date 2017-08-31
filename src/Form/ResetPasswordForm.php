<?php
/**
 * Author: Huw
 * Since: 31/08/2017
 */

namespace SUSC\Form;


use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ResetPasswordForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema
            ->addField('new_password', 'string')
            ->addField('conf_password', 'string');
    }

    protected function _buildValidator(Validator $validator)
    {
        $validator
            ->add('new_password', [
                'length' => [
                    'rule' => ['minLength', 6],
                    'message' => 'Passwords have to be at least 6 characters.',
                ]
            ])
            ->notEmpty('new_password');
        $validator
            ->add('conf_password', [
                'match' => [
                    'rule' => ['compareWith', 'new_password'],
                    'message' => 'Passwords do not match!',
                ]
            ]);

        return $validator;
    }

    protected function _execute(array $data)
    {
        return true;
    }

}