<?php
return [
    // 权限组
    'GROUP_CONF' => [
        '1' => 'super_admin',
        '2' => 'admin',
        '3' => 'ad_dl', // 广告位代理商
        '4' => 'advs', // 广告主
    ],

    // 权限组名映射id
    'MAPPING_NAME_TO_GROUP_ID' => [
        'super_admin'   => 1,
        'admin'         => 2,
        'ad_dl'         => 3,
        'advs'          => 4,
    ],

    // 无需登录即可访问方法
    'NO_LOGIN_ACTIONS' => require 'params/no_login_actions.php',
];
