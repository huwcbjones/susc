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
            ->addField('quantity', 'number')
            ->addField('isRemove', 'number')
            ->addField('additionalInfo', 'string');
    }

    protected function _buildValidator(Validator $validator)
    {
        return $validator
            ->add(
                'id',
                'minLength',
                [
                    'rule' => [
                        'minLength',
                        36
                    ],
                    'message' => 'Invalid Item'
                ]
            )
            ->add('id', 'maxLength', [
                'rule' => [
                    'maxLength',
                    36
                ],
                'message' => 'Invalid Item',
            ])
            ->naturalNumber('quantity')
            ->allowEmpty('size')
            ->allowEmpty('isRemove');
    }

    protected function _execute(array $data)
    {
        return true;
    }
}