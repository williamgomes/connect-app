<?php

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

    'accepted'        => ':attribute må være godkjent.',
    'active_url'      => ':attribute er ikke en gyldig URL.',
    'after'           => ':attribute må være en dato etter :date.',
    'after_or_equal'  => ':attribute må være :date eller en dato etter.',
    'alpha'           => ':attribute kan bare inneholde bokstaver.',
    'alpha_dash'      => ':attribute kan bare inneholde bokstaver, tall, bindestrek og understrek.',
    'alpha_num'       => ':attribute kan bare inneholde bokstaver og tall.',
    'array'           => ':attribute må være et array.',
    'before'          => ':attribute må være en dato før :date.',
    'before_or_equal' => ':attribute må være :date eller en dato før.',
    'between'         => [
        'numeric' => ':attribute må være mellom :min og :max.',
        'file'    => ':attribute må være mellom :min og :max kilobytes.',
        'string'  => ':attribute må være mellom :min og :max karakterer.',
        'array'   => ':attribute må inneholde mellom :min og :max elementer.',
    ],
    'boolean'        => ':attribute må være sant eller usant.',
    'confirmed'      => ':attribute bekreftelsen er ugyldig.',
    'date'           => ':attribute er ikke en gyldig dato.',
    'date_equals'    => ':attribute må være :date.',
    'date_format'    => ':attribute følger ikke korrekt format :format.',
    'different'      => ':attribute og :other må være ulike.',
    'digits'         => ':attribute må være :digits tall.',
    'digits_between' => ':attribute må være tall mellom :min og :max.',
    'dimensions'     => ':attribute har ugyldige dimenasjoner.',
    'distinct'       => ':attribute har en duplikat verdi.',
    'email'          => ':attribute må være en gyldig e-post adresse.',
    'ends_with'      => ':attribute må avsluttes med en av følgende: :values',
    'exists'         => ':attribute er ugyldig.',
    'file'           => ':attribute må være en fil.',
    'filled'         => ':attribute må ha en verdi.',
    'gt'             => [
        'numeric' => ':attribute må være større enn :value.',
        'file'    => ':attribute må være større enn :value kilobytes.',
        'string'  => ':attribute må være større enn :value karakterer.',
        'array'   => ':attribute må ha mer enn :value enheter.',
    ],
    'gte' => [
        'numeric' => ':attribute må være større enn eller lik :value.',
        'file'    => ':attribute må være større enn eller lik :value kilobytes.',
        'string'  => ':attribute må være større enn eller lik :value karakterer.',
        'array'   => ':attribute må ha :value enheter eller mer.',
    ],
    'image'    => ':attribute må være et bilde.',
    'in'       => ':attribute er ugyldig.',
    'in_array' => ':attribute eksisterer ikke i :other.',
    'integer'  => ':attribute må være et tall.',
    'ip'       => ':attribute må være en gyldig IP adresse.',
    'ipv4'     => ':attribute må være en gyldig IPv4 adresse.',
    'ipv6'     => ':attribute må være en gyldig IPv6 adresse.',
    'json'     => ':attribute må være en gyldig JSON streng.',
    'lt'       => [
        'numeric' => ':attribute må være mindre enn :value.',
        'file'    => ':attribute må være mindre enn :value kilobytes.',
        'string'  => ':attribute må være mindre enn :value karakterer.',
        'array'   => ':attribute må ha mindre enn :value enheter.',
    ],
    'lte' => [
        'numeric' => ':attribute må være mindre enn eller lik: :value.',
        'file'    => ':attribute må være mindre enn eller lik: :value kilobytes.',
        'string'  => ':attribute må være mindre enn eller lik: :value karakterer.',
        'array'   => ':attribute kan ikke ha mer enn :value enheter.',
    ],
    'max' => [
        'numeric' => ':attribute kan ikke være større enn :max.',
        'file'    => ':attribute kan ikke være større enn :max kilobytes.',
        'string'  => ':attribute kan ikke være større enn :max karakterer.',
        'array'   => ':attribute kan ikke ha mer enn :max enheter.',
    ],
    'mimes'     => ':attribute må være en av følgende filtyper: :values.',
    'mimetypes' => ':attribute må være en av følgende filtyper: :values.',
    'min'       => [
        'numeric' => ':attribute kan ikke være mindre enn :min.',
        'file'    => ':attribute kan ikke være mindre enn :min kilobytes.',
        'string'  => ':attribute kan ikke være mindre enn :min karakterer.',
        'array'   => ':attribute kan ikke ha mindre enn :min enheter.',
    ],
    'not_in'               => ':attribute er ugyldig.',
    'not_regex'            => ':attribute har et ugyldig format.',
    'numeric'              => ':attribute må være et tall.',
    'present'              => ':attribute må være tilstede.',
    'regex'                => ':attribute har et ugyldig format.',
    'required'             => ':attribute er påkrevd.',
    'required_if'          => ':attribute er påkrevd når :other er :value.',
    'required_unless'      => ':attribute er påkrevd om ikke :other er :values.',
    'required_with'        => ':attribute er påkrevd når :values er tilstede.',
    'required_with_all'    => ':attribute er påkrevd når alle verdier er tilstede: :values',
    'required_without'     => ':attribute er påkrevd når :values ikke er tilstede.',
    'required_without_all' => ':attribute er påkrevd når ingen av følgende verider er tilstede: :values',
    'same'                 => ':attribute og :other må være identiske.',
    'size'                 => [
        'numeric' => ':attribute må være :size.',
        'file'    => ':attribute må være :size kilobytes.',
        'string'  => ':attribute må være :size characters.',
        'array'   => ':attribute må inneholde :size enheter.',
    ],
    'starts_with' => ':attribute må starte med en av de følgende verdiene: :values',
    'string'      => ':attribute må være en streng.',
    'timezone'    => ':attribute må være en gyldig tidssone.',
    'unique'      => ':attribute har allerede blitt tatt.',
    'uploaded'    => ':attribute feilet under opplastning.',
    'url'         => ':attribute har et ugyldig format.',
    'uuid'        => ':attribute må være en gyldig UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'active'    => 'aktiv',
        'name'      => 'navn',
        'email'     => 'epost',
        'role'      => 'rolle',
        'password'  => 'passord',
    ],
];
