<?php
/**
 * @params show : 是否显示
 * @params operate : 是否可操作
 */
return [
    // super admin
    '1' => [
        // offer list页面
        'offer-index' => [
            // 创建
            'offer_create' => ['show' => true, 'operate' => true],
            // 修改
            'offer_update' => ['show' => true,'operate' => true],
            // 查看
            'offer_see' => ['show' => true,'operate' => true],
            // 状态
            'offer_status' => ['show' => true,'operate' => true],
            // offer 审核
            'offer_sh' => ['show' => true,'operate' => true],
        ],
        'user-index' => [

        ],
    ],
    // admin
    '2' => [
        // offer list页面
        'offer-index' => [
            // 创建
            'offer_create' => ['show' => true, 'operate' => true],
            // 修改
            'offer_update' => ['show' => true,'operate' => true],
            // 查看
            'offer_see' => ['show' => true,'operate' => true],
            // 状态
            'offer_status' => ['show' => true,'operate' => true],
            // offer 审核
            'offer_sh' => ['show' => true,'operate' => true],
        ]
    ],
    // advertiser agent
    '3' => [
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
        ]
    ]
];