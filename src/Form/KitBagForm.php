<?php

namespace SUSC\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class KitBagForm extends Form
{

    protected function _buildSchema(Schema $schema)
    {
        return $schema
            ->addField('id', 'string')
            ->addField('size', 'string')
            ->addField('isRemove', 'number');
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator;/*
            ->add(
                'id',
                'length',
                [
                    'minLength' => [
                        'rule' => [
                            'minLength',
                            36
                        ],
                        'message' => 'Item ID format is 36 characters long'
                    ],
                    'maxLength' => [
                        'rule' => [
                            'maxLength',
                            36
                        ],
                        'message' => 'Item ID format is 36 characters long'
                    ],
                    'message' => 'An item ID is required'
                ]
            )
            ->allowEmpty('size')
            ->allowEmpty('isRemove');*/
    }

    protected function _execute(array $data)
    {
        return true;
    }
}