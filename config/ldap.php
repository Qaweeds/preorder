<?php

return [
    'hosts' => explode(',', env('LDAP_HOST')),
    'base_dn' => env('LDAP_DN'),
    'suffix' => env('LDAP_SUFFIX'),
    'group' => [
        'Админ' => 'PreAdmin',
        'Директор' => 'PreManager',
        'Закупка' => 'PreTrade',
        'Товаровед' => 'PreMarket',
        'CityBluzka' => 'PreCityBluzka',
        'OLKO' => 'PreOLKO',
        'Vip-опт' => 'PreVIPOpt',
        'Опт' => 'PreOpt'
    ],
];
