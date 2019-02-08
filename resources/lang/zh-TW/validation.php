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

    'errors_in_form'       => '奧普斯! 您的表單中有錯誤。',

    'accepted'             => '必須接受：屬性。',
    'active_url'           => '：屬性不是有效的URL。',
    'after'                => '：屬性必須是在:日期之後的日期。',
    'after_or_equal'       => '：屬性必須是晚於或等於:日期的日期。',
    'agreement'            => '：必須同意屬性。',
    'alpha'                => '：屬性只能包含字母。',
    'alpha_dash'           => '：屬性只能包含字母、數字和橫線。',
    'alpha_num'            => '：屬性只能包含字母和數字。',
    'array'                => '：屬性必須是陣列。',
    'before'               => '：屬性必須是在:日期之前的日期。',
    'before_or_equal'      => ':屬性必須是早於或等於:日期的日期。',
    'between'              => [
        'numeric' => '：屬性必須介於min和:max之間。',
        'file'    => '：屬性必須介於：min和:max KB之間。',
        'string'  => '：屬性必須介於min和:max個字元之間。',
        'array'   => '：屬性必須介於：min和:max個項目之間。',
    ],
    'boolean'              => '：屬性欄位必須為true或false。',
    'confirmed'            => '：屬性確認不符。',
    'date'                 => '：屬性不是有效日期。',
    'date_format'          => '：屬性不符合格式： s格式。',
    'different'            => '：屬性和：其他必須不同。',
    'digits'               => '：屬性必須是：數字位數。',
    'digits_between'       => '：屬性必須介於：min和:max位數之間。',
    'dimensions'           => '：屬性具有無效的影像維度。',
    'distinct'             => '：屬性欄位有重複的值。',
    'email'                => '：屬性必須是有效的電子郵件位址。',
    'exists'               => '選取的：屬性無效。',
    'file'                 => '：屬性必須是檔案。',
    'filled'               => '：屬性欄位必須具有值。',
    'image'                => '：屬性必須是影像。',
    'in'                   => '選取的：屬性無效。',
    'in_array'             => '：屬性欄位不存在於：其他。',
    'integer'              => '：屬性必須是整數。',
    'ip'                   => '：屬性必須是有效的IP位址。',
    'ipv4'                 => ':屬性必須是有效的IPv4位址。',
    'ipv6'                 => ':屬性必須是有效的IPv6位址。',
    'json'                 => ':屬性必須是有效的JSON字串。',
    'max'                  => [
        'numeric' => '：屬性不得大於:max。',
        'file'    => '：屬性不得大於：maxKB。',
        'string'  => '：屬性不得大於：字元數上限。',
        'array'   => '：屬性不能超過：個項目數上限。',
    ],
    'mimes'                => '：屬性必須是類型： :值的檔案。',
    'mimetypes'            => '：屬性必須是類型： :值的檔案。',
    'min'                  => [
        'numeric' => '：屬性必須至少為:min。',
        'file'    => '：屬性必須至少為：下限( KB)。',
        'string'  => ':屬性必須至少是:min個字元。',
        'array'   => '：屬性必須至少有：min個項目。',
    ],
    'not_in'               => '選取的：屬性無效。',
    'numeric'              => '：屬性必須是數字。',
    'preferences'          => '：屬性必須是有效的喜好設定清單。',
    'present'              => '必須存在：屬性欄位。',
    'pwned'                => '您選擇的密碼不夠安全，因爲在已知的密碼違規中找到了密碼，請選擇一個新密碼。',
    'regex'                => '：屬性格式無效。',
    'required'             => '需要：屬性欄位。',
    'required_if'          => '當：其他是:值時需要：屬性欄位。',
    'required_unless'      => '除非：其他是在：值中，否則需要：屬性欄位。',
    'required_with'        => '當存在下列情況時需要：屬性欄位：值。',
    'required_with_all'    => '當存在下列情況時需要：屬性欄位：值。',
    'required_without'     => '當：值不存在時需要：屬性欄位。',
    'required_without_all' => '如果不存在任何值，那麼" :屬性"欄位是必需的。',
    'same'                 => '：屬性與：其他必須相符。',
    'size'                 => [
        'numeric' => '：屬性必須是： s s大小。',
        'file'    => '：屬性必須是：s大小( KB)。',
        'string'  => '：屬性必須是：大小字元。',
        'array'   => '：屬性必須包含：大小項目。',
    ],
    'sum_between'          => '：屬性必須介於min和:max之間。',
    'string'               => '：屬性必須是字串。',
    'timezone'             => '：屬性必須是有效的區域。',
    'unique'               => '已採用：屬性。',
    'uploaded'             => '無法上傳：屬性。',
    'url'                  => '：屬性格式無效。',

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
