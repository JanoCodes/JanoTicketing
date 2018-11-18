<?php

return [
    'defaults'      => [
        'wrapper_class'       => 'form-group row',
        'wrapper_error_class' => '',
        'label_class'         => 'col-sm-4 col-form-label',
        'field_class'         => 'form-control',
        'field_error_class'   => 'is-invalid',
        'help_block_class'    => 'help-block',
        'error_class'         => 'invalid-feedback',
        'required_class'      => 'required',

        'checkbox'            => [
            'label_class'     => 'custom-control-label',
            'field_class'     => 'custom-control-input'
        ],
        'select'              => [
            'field_class'     => 'custom-select'
        ]

        // Override a class from a field.
        //'text'                => [
        //    'wrapper_class'   => 'form-field-text',
        //    'label_class'     => 'form-field-text-label',
        //    'field_class'     => 'form-field-text-field',
        //]
        //'radio'               => [
        //    'choice_options'  => [
        //        'wrapper'     => ['class' => 'form-radio'],
        //        'label'       => ['class' => 'form-radio-label'],
        //        'field'       => ['class' => 'form-radio-field'],
        //],
    ],
    // Templates
    'form'          => 'form.form',
    'text'          => 'form.text',
    'textarea'      => 'form.textarea',
    'button'        => 'form.button',
    'buttongroup'   => 'form.buttongroup',
    'radio'         => 'form.radio',
    'checkbox'      => 'form.checkbox',
    'select'        => 'form.select',
    'choice'        => 'form.choice',
    'repeated'      => 'form.repeated',
    'child_form'    => 'form.child_form',
    'collection'    => 'form.collection',
    'static'        => 'form.static',

    // Remove the form. prefix above when using template_prefix
    'template_prefix'   => '',

    'default_namespace' => '',

    'custom_fields' => [
//        'datetime' => App\Forms\Fields\Datetime::class
    ]
];
