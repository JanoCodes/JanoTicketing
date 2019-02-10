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

    'errors_in_form'       => 'Опс! В вашей форме есть некоторые ошибки.',

    'accepted'             => 'Атрибут: должен быть принят.',
    'active_url'           => 'Атрибут: недопустимый URL.',
    'after'                => 'Атрибут: должен быть датой после :date.',
    'after_or_equal'       => 'Атрибут: должен быть датой после или равен :date.',
    'agreement'            => 'Атрибут: должен быть согласован.',
    'alpha'                => 'Атрибут: может содержать только буквы.',
    'alpha_dash'           => 'Атрибут: может содержать только буквы, цифры и дефисы.',
    'alpha_num'            => 'Атрибут: может содержать только буквы и цифры.',
    'array'                => 'Атрибут: должен быть массивом.',
    'before'               => 'Атрибут: должен быть датой до :date.',
    'before_or_equal'      => 'Атрибут: должен быть датой до или равна :date.',
    'between'              => [
        'numeric' => 'Атрибут: должен находиться в диапазоне между: min и :max.',
        'file'    => 'Атрибут: должен находиться в диапазоне от: min до: max килобайт.',
        'string'  => 'Атрибут: должен находиться в диапазоне от: min до: max characters.',
        'array'   => 'Атрибут: должен иметь значение от: min до: max items.',
    ],
    'boolean'              => 'Поле атрибута: должно быть true или false.',
    'confirmed'            => 'Подтверждение атрибута: не совпадает с подтверждением.',
    'date'                 => 'Атрибут: не является допустимой датой.',
    'date_format'          => 'Атрибут: не соответствует формату :format.',
    'different'            => 'Атрибут: и: other должны быть разными.',
    'digits'               => 'Атрибут: должен быть: цифры.',
    'digits_between'       => 'Атрибут: должен находиться в диапазоне между: min и: max digits.',
    'dimensions'           => 'Атрибут: содержит недопустимые измерения изображения.',
    'distinct'             => 'В поле атрибута: есть повторяющееся значение.',
    'email'                => 'Атрибут: должен быть допустимым электронным адресом.',
    'exists'               => 'Выбранный атрибут: недопустимый.',
    'file'                 => 'Атрибут: должен быть файлом.',
    'filled'               => 'В поле атрибута: должно быть значение.',
    'image'                => 'Атрибут: должен быть изображением.',
    'in'                   => 'Выбранный атрибут: недопустимый.',
    'in_array'             => 'Поле атрибута: не существует в: other.',
    'integer'              => 'Атрибут: должен быть целым числом.',
    'ip'                   => 'Атрибут: должен быть допустимым IP-адресом.',
    'ipv4'                 => 'Атрибут: должен быть допустимым адресом IPv4.',
    'ipv6'                 => 'Атрибут: должен быть допустимым адресом IPv6.',
    'json'                 => 'Атрибут: должен быть допустимой строкой JSON.',
    'max'                  => [
        'numeric' => 'Атрибут: не может быть больше :max.',
        'file'    => 'Атрибут: не может быть больше: максимум килобайт.',
        'string'  => 'Атрибут: не может быть больше: max characters.',
        'array'   => 'Атрибут: может содержать не более: максимум элементов.',
    ],
    'mimes'                => 'Атрибут: должен быть файлом типа: :values.',
    'mimetypes'            => 'Атрибут: должен быть файлом типа: :values.',
    'min'                  => [
        'numeric' => 'Атрибут: должен быть не меньше :min.',
        'file'    => 'Атрибут: не должен быть меньше: min килобайт.',
        'string'  => 'Атрибут: не должен быть меньше: min characters.',
        'array'   => 'Атрибут: должен содержать по крайней мере следующие элементы: min.',
    ],
    'not_in'               => 'Выбранный атрибут: недопустимый.',
    'numeric'              => 'Атрибут: должен быть числом.',
    'preferences'          => 'Атрибут: должен быть допустимым списком параметров.',
    'present'              => 'Поле атрибута: должно присутствовать.',
    'pwned'                => 'Пароль, который вы выбрали, является недостаточно защищенным, так как он был обнаружен в известных нарушениях пароля, выберите новый пароль.',
    'regex'                => 'Недопустимый формат атрибута.',
    'required'             => 'Поле атрибута: является обязательным.',
    'required_if'          => 'Поле атрибута: требуется, если: другое значение: :value.',
    'required_unless'      => 'Поле атрибута: требуется, если только в :values не находятся другие поля.',
    'required_with'        => 'Поле атрибута: обязательное, если: значения присутствуют.',
    'required_with_all'    => 'Поле атрибута: обязательное, если: значения присутствуют.',
    'required_without'     => 'Поле атрибута: обязательное, если значения не представлены.',
    'required_without_all' => 'Поле атрибута: обязательное, если ни одно из значений не присутствует.',
    'same'                 => 'Атрибут: и: другие должны совпадать.',
    'size'                 => [
        'numeric' => 'Атрибут: должен быть :size.',
        'file'    => 'Атрибут: size должен быть: size килобайт.',
        'string'  => 'Атрибут: должен быть: размер символов.',
        'array'   => 'Атрибут: должен содержать элементы размера.',
    ],
    'sum_between'          => 'Атрибут: должен находиться в диапазоне между: min и :max.',
    'string'               => 'Атрибут: должен быть строкой.',
    'timezone'             => 'Атрибут: должен быть допустимой зоной.',
    'unique'               => 'Атрибут: уже был взят.',
    'uploaded'             => 'Атрибут: не удалось передать на сервер.',
    'url'                  => 'Недопустимый формат атрибута.',

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
