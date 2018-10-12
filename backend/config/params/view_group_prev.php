<?php
/**
 * @params show : 是否显示
 * @params operate : 是否可操作
 */
return [
    // super admin
    '1' => [
        // user list 页面
        'user-index' => [
            // 根据权限搜索用户
            'search_role' => ['show' => true, 'operate' => true],
        ],

        // offer list页面
        'offer-index' => [
            // 创建
            'offer_create' => ['show' => true, 'operate' => true],
            // 修改
            'offer_update' => ['show' => true,'operate' => true],
            // 查看
            'offer_see' => ['show' => false,'operate' => false],
            // 状态
            'offer_status' => ['show' => true,'operate' => true],
            // offer 审核
            'offer_sh' => ['show' => true,'operate' => true],
            // 列表投放单价是否显示
            'offer_delivery_price' => ['show' => true,'operate' => true],
            // offer search campaign owner
            'offer_search_campaign_owner' => ['show' => true,'operate' => true],
        ],
        // offer update 页面
        'offer-update-info' => [
            // 是否页面可操作
            'show' => true,'operate' => true,
            // 投放价格是否显示
            'delivery_price' => ['show' => true,'operate' => true,],
            // 价格是否可修改
            'payout' => ['show' => true,'operate' => false,],
        ],

        // offer create 页面
        'offer-create' => [
            // 投放价格是否显示
            'delivery_price' => ['show' => true,'operate' => true,],
        ],

        // 报表页面
        'offer-report-index' => [
            // 用户搜索
            'campaigns_owner' => ['show' => true,'operate' => true],
            // 是否显示收入
            'payout' => ['show' => true,'operate' => true],
        ],
    ],
    // admin
    '2' => [
        // user list 页面
        'user-index' => [
            // 根据权限搜索用户
            'search_role' => ['show' => true, 'operate' => true],
        ],

        // offer list页面
        'offer-index' => [
            // 创建
            'offer_create' => ['show' => true, 'operate' => true],
            // 修改
            'offer_update' => ['show' => true,'operate' => true],
            // 查看
            'offer_see' => ['show' => false,'operate' => false],
            // 状态
            'offer_status' => ['show' => true,'operate' => true],
            // offer 审核
            'offer_sh' => ['show' => true,'operate' => true],

            // 列表投放单价是否显示
            'offer_delivery_price' => ['show' => true,'operate' => true],
            // offer search campaign owner
            'offer_search_campaign_owner' => ['show' => true,'operate' => true],
        ],
        // offer update 页面
        'offer-update-info' => [
            // 是否页面可操作
            'show' => true,'operate' => true,
            // 投放价格是否显示
            'delivery_price' => ['show' => true,'operate' => true,],
            // 价格是否可修改
            'payout' => ['show' => true,'operate' => false,],
        ],

        // offer create 页面
        'offer-create' => [
            // 投放价格是否显示
            'delivery_price' => ['show' => true,'operate' => true,],
        ],

        // 报表页面
        'offer-report-index' => [
            'campaigns_owner' => ['show' => true,'operate' => true],
            'payout' => ['show' => true,'operate' => true],
        ],
    ],
    // advertiser agent
    '3' => [
        // user list 页面
        'user-index' => [
            // 根据权限搜索用户
            'search_role' => ['show' => false, 'operate' => false],
        ],

        // offer list页面
        'offer-index' => [
            // 创建
            'offer_create' => ['show' => true, 'operate' => true],
            // 修改
            'offer_update' => ['show' => true,'operate' => true],
            // 查看
            'offer_see' => ['show' => true,'operate' => false],
            // 状态
            'offer_status' => ['show' => true,'operate' => false],
            // offer 审核
            'offer_sh' => ['show' => true,'operate' => false],

            // 列表投放单价是否显示
            'offer_delivery_price' => ['show' => false,'operate' => false],
            // offer search campaign owner
            'offer_search_campaign_owner' => ['show' => false,'operate' => false],
        ],
        // offer update 页面
        'offer-update-info' => [
            // 是否页面可操作
            'show' => true,'operate' => false,
            // 投放价格是否显示
            'delivery_price' => ['show' => false,'operate' => false,],
            // 价格是否可修改
            'payout' => ['show' => true,'operate' => true,],
        ],

        // offer create 页面
        'offer-create' => [
            // 投放价格是否显示
            'delivery_price' => ['show' => false,'operate' => false,],
        ],

        // 报表页面
        'offer-report-index' => [
            'campaigns_owner' => ['show' => false,'operate' => false],
            'payout' => ['show' => false,'operate' => false],
        ],
    ]
];