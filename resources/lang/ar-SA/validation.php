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

    'errors_in_form'       => '! أوبس توجد بعض الأخطاء في النموذج الخاص بك.',

    'accepted'             => 'يجب قبول الخاصية :attribute.',
    'active_url'           => 'الخاصية المميزة : لا تعد عنوان URL صحيح.',
    'after'                => 'الخاصية المميزة : يجب أن تكون تاريخ بعد : تاريخ.',
    'after_or_equal'       => 'الخاصية المميزة : يجب أن تكون تاريخ بعد أو مساوي الى :date.',
    'agreement'            => 'يجب أن يتم الموافقة على الخاصية المميزة :attribute.',
    'alpha'                => 'الخاصية المميزة : قد تحتوي على حروف فقط.',
    'alpha_dash'           => 'يمكن أن تحتوي الخاصية المميزة :attribute على حروف وأرقام وشرطة فقط.',
    'alpha_num'            => 'الخاصية المميزة : قد تحتوي على حروف وأرقام فقط.',
    'array'                => 'يجب أن تكون الخاصية المميزة عبارة عن مصفوفة.',
    'before'               => 'الخاصية المميزة : يجب أن تكون تاريخ قبل : التاريخ.',
    'before_or_equal'      => 'الخاصية المميزة : يجب أن تكون تاريخ قبل أو مساوي الى : date.',
    'between'              => [
        'numeric' => 'يجب أن تكون الخاصية :mattribute بين : min و :max.',
        'file'    => 'يجب أن تكون الخاصية :mattribute بين : min و : max kilobytes.',
        'string'  => 'يجب أن تكون الخاصية المميزة :min بين : min و : max Characters.',
        'array'   => 'يجب أن يكون للخاصية المميزة بين : min و : max items.',
    ],
    'boolean'              => 'مجال :etubirtta يجب أن يكون true أو false.',
    'confirmed'            => 'تأكيد :attribute غير مطابق.',
    'date'                 => 'الخاصية :attribute ليست تاريخ صحيح.',
    'date_format'          => 'الخاصية المميزة : لا تتفق مع النسق :format.',
    'different'            => 'يجب أن تكون الخاصية المميزة :attribute و : الأخرى مختلفة.',
    'digits'               => 'الخاصية :attribute يجب أن تكون : أرقام أرقام.',
    'digits_between'       => 'يجب أن تكون الخاصية :attribute بين : min و : max digits.',
    'dimensions'           => 'الخاصية المميزة لها أبعاد صورة غير صحيحة.',
    'distinct'             => 'مجال :الخاصية المميزة يحتوي على قيمة مكررة.',
    'email'                => 'يجب أن تكون الخاصية المميزة عبارة عن عنوان بريد الكتروني صحيح.',
    'exists'               => 'الخاصية المميزة : الخاصية المميزة غير صحيحة.',
    'file'                 => 'يجب أن تكون الخاصية المميزة عبارة عن ملف.',
    'filled'               => 'يجب أن يحتوي مجال الخاصية المميزة :attribute على قيمة.',
    'image'                => 'يجب أن تكون الخاصية المميزة عبارة عن صورة.',
    'in'                   => 'الخاصية المميزة : الخاصية المميزة غير صحيحة.',
    'in_array'             => 'مجال : الخاصية المميزة غير موجود في : الآخر.',
    'integer'              => 'يجب أن تكون الخاصية المميزة عبارة عن رقم صحيح.',
    'ip'                   => 'يجب أن تكون الخاصية :attribute عبارة عن عنوان IP صحيح.',
    'ipv4'                 => 'يجب أن تكون الخاصية المميزة عبارة عن عنوان IPv4 صحيح.',
    'ipv6'                 => 'يجب أن تكون الخاصية المميزة عبارة عن عنوان IPv6 صحيح.',
    'json'                 => 'يجب أن تكون الخاصية المميزة :etubirtribute عبارة عن مجموعة حروف JSON صحيحة.',
    'max'                  => [
        'numeric' => 'قد لا تكون الخاصية المميزة : أكبر من : max.',
        'file'    => 'قد لا تكون خاصية :attribute أكبر من : max kilobytes.',
        'string'  => 'الخاصية المميزة : قد لا تكون أكبر من : الحد الأقصى للحروف.',
        'array'   => 'قد لا تحتوي الخاصية المميزة :attribute على أكثر من : الحد الأقصى للبنود.',
    ],
    'mimes'                => 'يجب أن تكون الخاصية المميزة عبارة عن ملف من النوع : : القيم.',
    'mimetypes'            => 'يجب أن تكون الخاصية المميزة عبارة عن ملف من النوع : : القيم.',
    'min'                  => [
        'numeric' => 'الخاصية المميزة يجب أن تكون على الأقل : الحد الأدنى.',
        'file'    => 'الخاصية :attribute يجب أن تكون على الأقل : min kilobytes.',
        'string'  => 'يجب أن تكون الخاصية :attribute على الأقل : min characters.',
        'array'   => 'يجب أن يكون للخاصية المميزة : الحد الأدنى للبنود على الأقل.',
    ],
    'not_in'               => 'الخاصية المميزة : الخاصية المميزة غير صحيحة.',
    'numeric'              => 'يجب أن تكون الخاصية المميزة عبارة عن رقم.',
    'preferences'          => 'يجب أن تكون الخاصية المميزة عبارة عن كشف تفضيلات صحيح.',
    'present'              => 'مجال :etubirtta يجب أن يكون موجود.',
    'pwned'                => 'كلمة السرية التي قمت باختيارها غير مؤمنة بما فيه الكفاية حيث أنه تم ايجادها في انتهاكات كلمة السرية المعروفة ، برجاء اختيار واحد جديد.',
    'regex'                => 'نسق الخاصية المميزة : غير صحيح.',
    'required'             => 'مجال :الخاصية المميزة مطلوب.',
    'required_if'          => 'مجال الخاصية المميزة : مطلوب عندما يكون : الآخر : value.',
    'required_unless'      => 'مجال الخاصية المميزة :attribute مطلوب الا اذا : الأخرى في :valuee.',
    'required_with'        => 'مجال :الخاصية المميزة مطلوب عندما تكون القيم موجودة.',
    'required_with_all'    => 'مجال :الخاصية المميزة مطلوب عندما تكون القيم موجودة.',
    'required_without'     => 'مجال :الخاصية المميزة مطلوب عندما تكون القيم غير موجودة.',
    'required_without_all' => 'مجال :الخاصية المميزة مطلوب عند عدم وجود أي من : القيم.',
    'same'                 => 'الخاصية :attribute و : الأخرى يجب مطابقتها.',
    'size'                 => [
        'numeric' => 'الخاصية المميزة :size يجب أن تكون : size.',
        'file'    => 'الخاصية : يجب أن تكون : حجم كيلوبايت.',
        'string'  => 'الخاصية المميزة :etubirtta يجب أن تكون : حروف الحجم.',
        'array'   => 'يجب أن تحتوي الخاصية :attribute على : size items.',
    ],
    'sum_between'          => 'يجب أن تكون الخاصية :mattribute بين : min و :max.',
    'string'               => 'يجب أن تكون الخاصية المميزة عبارة عن مجموعة حروف.',
    'timezone'             => 'يجب أن تكون الخاصية المميزة عبارة عن zone صحيح.',
    'unique'               => 'الخاصية المميزة :attribute تم أخذها بالفعل.',
    'uploaded'             => 'فشلت محاولة تحميل الخاصية المميزة :attribute.',
    'url'                  => 'نسق الخاصية المميزة : غير صحيح.',

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
