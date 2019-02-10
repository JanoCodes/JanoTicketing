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

    'errors_in_form'       => 'Opps ! Il y a des erreurs dans votre formulaire.',

    'accepted'             => 'L\'attribut: doit être accepté.',
    'active_url'           => 'L\'attribut: n\'est pas une URL valide.',
    'after'                => 'L\'attribut: doit être une date postérieure à :date.',
    'after_or_equal'       => 'L\'attribut: doit être une date postérieure ou égale à :date.',
    'agreement'            => 'L\'attribut: doit être accepté.',
    'alpha'                => 'L\'attribut: peut uniquement contenir des lettres.',
    'alpha_dash'           => 'L\'attribut: peut uniquement contenir des lettres, des nombres et des tirets.',
    'alpha_num'            => 'L\'attribut: peut uniquement contenir des lettres et des nombres.',
    'array'                => 'L\'attribut: doit être un tableau.',
    'before'               => 'L\'attribut: doit être une date antérieure à :date.',
    'before_or_equal'      => 'L\'attribut: doit être une date antérieure ou égale à :date.',
    'between'              => [
        'numeric' => 'L\'attribut: doit être compris entre: min et :max.',
        'file'    => 'L\'attribut: doit être compris entre: min et: max kilooctets.',
        'string'  => 'L\'attribut: doit être compris entre: min et: max caractères.',
        'array'   => 'L\'attribut: doit avoir entre: min et: max.',
    ],
    'boolean'              => 'La zone: attribut doit être true ou false.',
    'confirmed'            => 'La confirmation d\'attribut: ne correspond pas.',
    'date'                 => 'L\'attribut: n\'est pas une date valide.',
    'date_format'          => 'L\'attribut: ne correspond pas au format: format.',
    'different'            => 'L\'attribut: et l\'autre doit être différent.',
    'digits'               => 'L\'attribut: doit être: chiffres chiffres.',
    'digits_between'       => 'L\'attribut: doit être compris entre: min et: chiffres max.',
    'dimensions'           => 'L\'attribut: a des dimensions d\'image non valides.',
    'distinct'             => 'La zone: attribut a une valeur en double.',
    'email'                => 'L\'attribut: doit être une adresse électronique valide.',
    'exists'               => 'L\'attribut sélectionné: n\'est pas valide.',
    'file'                 => 'L\'attribut: doit être un fichier.',
    'filled'               => 'La zone: attribut doit avoir une valeur.',
    'image'                => 'L\'attribut: doit être une image.',
    'in'                   => 'L\'attribut sélectionné: n\'est pas valide.',
    'in_array'             => 'La zone: attribut n\'existe pas dans: autre.',
    'integer'              => 'L\'attribut: doit être un entier.',
    'ip'                   => 'L\'attribut: doit être une adresse IP valide.',
    'ipv4'                 => 'L\'attribut: doit être une adresse IPv4 valide.',
    'ipv6'                 => 'L\'attribut: doit être une adresse IPv6 valide.',
    'json'                 => 'L\'attribut: doit être une chaîne JSON valide.',
    'max'                  => [
        'numeric' => 'L\'attribut: peut ne pas être supérieur à :max.',
        'file'    => 'L\'attribut: peut ne pas être supérieur à: kilooctets max.',
        'string'  => 'L\'attribut: peut ne pas être supérieur à: caractères max.',
        'array'   => 'L\'attribut: peut ne pas avoir plus de: éléments max.',
    ],
    'mimes'                => 'L\'attribut: doit être un fichier de type: :values.',
    'mimetypes'            => 'L\'attribut: doit être un fichier de type: :values.',
    'min'                  => [
        'numeric' => 'L\'attribut: doit être au moins :min.',
        'file'    => 'L\'attribut: doit être au moins: min kilooctets.',
        'string'  => 'L\'attribut: doit être au moins: min caractères.',
        'array'   => 'L\'attribut: doit avoir au moins: min éléments.',
    ],
    'not_in'               => 'L\'attribut sélectionné: n\'est pas valide.',
    'numeric'              => 'L\'attribut: doit être un nombre.',
    'preferences'          => 'L\'attribut: doit être une liste de préférences valide.',
    'present'              => 'La zone: attribut doit être présente.',
    'pwned'                => 'Le mot de passe que vous avez choisi n\'est pas suffisamment sécurisé car il a été trouvé dans des violations de mots de passe connues, veuillez en choisir un nouveau.',
    'regex'                => 'Le format d\'attribut: n\'est pas valide.',
    'required'             => 'La zone: attribut est obligatoire.',
    'required_if'          => 'La zone: attribut est obligatoire lorsque l\'autre valeur est :value.',
    'required_unless'      => 'La zone: attribut est obligatoire sauf si l\'autre est dans :values.',
    'required_with'        => 'La zone: attribut est obligatoire lorsque: les valeurs sont présentes.',
    'required_with_all'    => 'La zone: attribut est obligatoire lorsque: les valeurs sont présentes.',
    'required_without'     => 'La zone: attribut est obligatoire lorsque: les valeurs ne sont pas présentes.',
    'required_without_all' => 'La zone: attribut est obligatoire lorsqu\'aucune des valeurs suivantes n\'est présente.',
    'same'                 => 'L\'attribut: et l\'autre doit correspondre.',
    'size'                 => [
        'numeric' => 'L\'attribut: doit être :size.',
        'file'    => 'L\'attribut: doit être: taille kilooctets.',
        'string'  => 'L\'attribut: doit être: taille caractères.',
        'array'   => 'L\'attribut: doit contenir: taille des éléments.',
    ],
    'sum_between'          => 'L\'attribut: doit être compris entre: min et :max.',
    'string'               => 'L\'attribut: doit être une chaîne.',
    'timezone'             => 'L\'attribut: doit être une zone valide.',
    'unique'               => 'L\'attribut: a déjà été pris.',
    'uploaded'             => 'L\'attribut: n\'a pas pu être téléchargé.',
    'url'                  => 'Le format d\'attribut: n\'est pas valide.',

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
