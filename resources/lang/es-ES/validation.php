<?php
/**
 * Jano Ticketing System
 * Copyright (C) 2016-2018 Andrew Ying and other contributors.
 *
 * This file is part of Jano Ticketing System.
 *
 * Jano Ticketing System is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v3.0 as
 * published by the Free Software Foundation. You must preserve all legal
 * notices and author attributions present.
 *
 * Jano Ticketing System is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'errors_in_form'       => '¡ Opps! Hay algunos errores en el formulario.',

    'accepted'             => 'El atributo: debe ser aceptado.',
    'active_url'           => 'El atributo: no es un URL válido.',
    'after'                => 'El atributo: debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El atributo: debe ser una fecha posterior o igual a :date.',
    'agreement'            => 'El atributo: debe estar de acuerdo con.',
    'alpha'                => 'El atributo: sólo puede contener letras.',
    'alpha_dash'           => 'El atributo: sólo puede contener letras, números y guiones.',
    'alpha_num'            => 'El atributo: sólo puede contener letras y números.',
    'array'                => 'El atributo: debe ser una matriz.',
    'before'               => 'El atributo: debe ser una fecha anterior :fecha.',
    'before_or_equal'      => 'El atributo: debe ser una fecha anterior o igual a :date.',
    'between'              => [
        'numeric' => 'El atributo: debe estar entre: min y :max.',
        'file'    => 'El atributo: debe estar entre: min y: max kilobytes.',
        'string'  => 'El atributo: debe estar entre: min y: max caracteres.',
        'array'   => 'El atributo: debe tener entre: min y: max items.',
    ],
    'boolean'              => 'El campo de atributo: debe ser true o false.',
    'confirmed'            => 'La confirmación de atributo: no coincide.',
    'date'                 => 'El atributo: no es una fecha válida.',
    'date_format'          => 'El atributo: no coincide con el formato :formato.',
    'different'            => 'El atributo: y: el otro debe ser distinto.',
    'digits'               => 'El atributo: debe ser: dígitos dígitos.',
    'digits_between'       => 'El atributo: debe estar entre: min y: max dígitos.',
    'dimensions'           => 'El atributo: tiene dimensiones de imagen no válidas.',
    'distinct'             => 'El campo de atributo: tiene un valor duplicado.',
    'email'                => 'El atributo: debe ser una dirección de correo electrónico válida.',
    'exists'               => 'El atributo seleccionado: no es válido.',
    'file'                 => 'El atributo: debe ser un archivo.',
    'filled'               => 'El campo de atributo: debe tener un valor.',
    'image'                => 'El atributo: debe ser una imagen.',
    'in'                   => 'El atributo seleccionado: no es válido.',
    'in_array'             => 'El campo de atributo: no existe en: otro.',
    'integer'              => 'El atributo: debe ser un entero.',
    'ip'                   => 'El atributo: debe ser una dirección IP válida.',
    'ipv4'                 => 'El atributo: debe ser una dirección IPv4 válida.',
    'ipv6'                 => 'El atributo: debe ser una dirección IPv6 válida.',
    'json'                 => 'El atributo: debe ser una serie JSON válida.',
    'max'                  => [
        'numeric' => 'El atributo: puede no ser mayor que :max.',
        'file'    => 'El atributo: puede no ser mayor que: max kilobytes.',
        'string'  => 'El atributo: puede no ser mayor que: máx. caracteres.',
        'array'   => 'Es posible que el atributo: no tenga más de: elementos máximos.',
    ],
    'mimes'                => 'El atributo: debe ser un archivo de tipo: :values.',
    'mimetypes'            => 'El atributo: debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El atributo: debe ser al menos :min.',
        'file'    => 'El atributo: debe ser como mínimo: min kilobytes.',
        'string'  => 'El atributo: debe ser como mínimo: min. caracteres.',
        'array'   => 'El atributo: debe tener, como mínimo, elementos mínimos.',
    ],
    'not_in'               => 'El atributo seleccionado: no es válido.',
    'numeric'              => 'El atributo: debe ser un número.',
    'preferences'          => 'El atributo: debe ser una lista válida de preferencias.',
    'present'              => 'El campo de atributo: debe estar presente.',
    'pwned'                => 'La contraseña que ha elegido es insuficientemente segura, ya que se ha encontrado en infracciones de contraseña conocidas, por favor elija una nueva.',
    'regex'                => 'El formato de atributo: no es válido.',
    'required'             => 'El campo de atributo: es obligatorio.',
    'required_if'          => 'El campo de atributo: es obligatorio cuando: otro es :value.',
    'required_unless'      => 'El campo de atributo: es obligatorio a menos que el otro esté en: valores.',
    'required_with'        => 'El campo de atributo: es obligatorio cuando: los valores están presentes.',
    'required_with_all'    => 'El campo de atributo: es obligatorio cuando: los valores están presentes.',
    'required_without'     => 'El campo de atributo: es necesario cuando: los valores no están presentes.',
    'required_without_all' => 'El campo de atributo: es necesario cuando no hay ninguno de los valores presentes.',
    'same'                 => 'El atributo: y: otro debe coincidir.',
    'size'                 => [
        'numeric' => 'El atributo: debe ser :size.',
        'file'    => 'El atributo: debe ser: size kilobytes.',
        'string'  => 'El atributo: debe ser: size caracteres.',
        'array'   => 'El atributo: debe contener: elementos de tamaño.',
    ],
    'sum_between'          => 'El atributo: debe estar entre: min y :max.',
    'string'               => 'El atributo: debe ser una serie.',
    'timezone'             => 'El atributo: debe ser una zona válida.',
    'unique'               => 'El atributo: ya se ha tomado.',
    'uploaded'             => 'El atributo: no se ha podido subir.',
    'url'                  => 'El formato de atributo: no es válido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
