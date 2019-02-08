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

    'errors_in_form'       => '奥普 表单中存在一些错误。',

    'accepted'             => '必须接受:属性。',
    'active_url'           => ':属性不是有效的URL。',
    'after'                => ':属性必须是日期之后的日期。',
    'after_or_equal'       => ':属性必须是晚于或等于:date的日期。',
    'agreement'            => '必须同意:属性。',
    'alpha'                => ':属性只能包含字母。',
    'alpha_dash'           => ':属性只能包含字母，数字和短划线。',
    'alpha_num'            => ':属性只能包含字母和数字。',
    'array'                => ':属性必须是数组。',
    'before'               => ':属性必须是日期之前的日期。',
    'before_or_equal'      => ':属性必须是早于或等于:date的日期。',
    'between'              => [
        'numeric' => ':属性必须在:min和:max之间。',
        'file'    => ':属性必须介于:min和:max千字节之间。',
        'string'  => ':属性必须介于:min和:max字符之间。',
        'array'   => ':属性必须介于:min和:max项之间。',
    ],
    'boolean'              => ':属性字段必须为true或false。',
    'confirmed'            => ':属性确认不匹配。',
    'date'                 => ':属性不是有效日期。',
    'date_format'          => ':属性与格式:format不匹配。',
    'different'            => ':属性和:其他必须不同。',
    'digits'               => ':属性必须为:数字位。',
    'digits_between'       => ':属性必须在最小值和最大值之间。',
    'dimensions'           => ':属性具有无效的图像维度。',
    'distinct'             => ':属性字段具有重复值。',
    'email'                => ':属性必须是有效的电子邮件地址。',
    'exists'               => '所选的:属性无效。',
    'file'                 => ':属性必须是文件。',
    'filled'               => ':属性字段必须具有值。',
    'image'                => ':属性必须是图像。',
    'in'                   => '所选的:属性无效。',
    'in_array'             => ':属性字段在另一个字段中不存在。',
    'integer'              => ':属性必须为整数。',
    'ip'                   => ':属性必须是有效的IP地址。',
    'ipv4'                 => ':属性必须是有效的IPv4地址。',
    'ipv6'                 => ':属性必须是有效的IPv6地址。',
    'json'                 => ':属性必须是有效的JSON字符串。',
    'max'                  => [
        'numeric' => ':属性不能大于:max。',
        'file'    => ':属性不能大于最大千字节数。',
        'string'  => ':属性不能大于:最大字符数。',
        'array'   => ':属性不能超过最大项数。',
    ],
    'mimes'                => ':属性必须是类型为: :值的文件。',
    'mimetypes'            => ':属性必须是类型为: :值的文件。',
    'min'                  => [
        'numeric' => ':属性必须至少为:min。',
        'file'    => ':属性必须至少为:min千字节。',
        'string'  => ':属性必须至少为:最小字符。',
        'array'   => ':属性必须至少具有:min项。',
    ],
    'not_in'               => '所选的:属性无效。',
    'numeric'              => ':属性必须是数字。',
    'preferences'          => ':属性必须是首选项的有效列表。',
    'present'              => '必须存在:属性字段。',
    'pwned'                => '您选择的密码不够安全，因为在已知密码违规中找到了密码，请选择新的密码。',
    'regex'                => ':属性格式无效。',
    'required'             => ':属性字段是必需的。',
    'required_if'          => '当:其他为:value时，属性字段是必需的。',
    'required_unless'      => '" :属性"字段是必需的，除非:其他是:值。',
    'required_with'        => '当存在以下值时，属性字段是必需的:值存在。',
    'required_with_all'    => '当存在以下值时，属性字段是必需的:值存在。',
    'required_without'     => '当:值不存在时，属性字段是必需的。',
    'required_without_all' => '当不存在以下值时，属性字段是必需的:值不存在。',
    'same'                 => ':属性和:其他必须匹配。',
    'size'                 => [
        'numeric' => ':属性必须为:size。',
        'file'    => ':属性必须为:大小千字节。',
        'string'  => ':属性必须为:大小字符。',
        'array'   => ':属性必须包含:大小项。',
    ],
    'sum_between'          => ':属性必须在:min和:max之间。',
    'string'               => ':属性必须为字符串。',
    'timezone'             => ':属性必须是有效区域。',
    'unique'               => '已获取:属性。',
    'uploaded'             => ':未能上载属性。',
    'url'                  => ':属性格式无效。',

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
