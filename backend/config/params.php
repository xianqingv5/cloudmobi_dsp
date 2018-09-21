<?php
return [
    // 权限组
    'GROUP_CONF' => [
        '1' => 'dev',
        '2' => 'operation manager',
        '3' => 'advertiser agent', // 广告位代理商
        '4' => 'advertiser', // 广告主
    ],

    // 权限组名映射id
    'MAPPING_NAME_TO_GROUP_ID' => [
        'dev'               => 1,
        'operation manager' => 2,
        'advertiser agent'  => 3,
        'advertiser'        => 4,
    ],

    // 区分不同的组的home_url
    'HOME_URL_BY_ROLE'      => [
        '1' => 'user/user-index',
        '2' => 'user/user-index',
        '3' => 'offer/offer-index',
        '4' => '',
    ],

    //平台类型
    'PLATFORM_TYPE' => [
        'android'   =>1,
        'ios'       =>2,
        'unknown'   =>3
    ],

    // 代理广告商群组
    'AGENT_ADVERTISERS' => 3,

    // 无需登录即可访问方法
    'NO_LOGIN_ACTIONS' => require 'params/no_login_actions.php',

    // 需要记录操作的方法
    'LOG_RECORD_METHOD' => require 'params/record_log.php',

    // 群组权限列表
    'GROUP_PREV' => require 'params/group_prev.php',

    // 平台版本
    'DEMAND_PLATFORM' => require 'params/demand-offer-version.php',

    // 设备信息
    'MOBILE' => require 'params/mobile.php',

    // 页面按钮权限
    'VIEW_GROUP' => require 'params/view_group_prev.php',
];
