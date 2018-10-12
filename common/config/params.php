<?php
return [
    // offer id 组装字符串
    'OFFER_ID_STRING' => 'dc',

    // 第三方=unknown时，第三方简称=“3rd”;第三方 in(appsflyer, 友盟, TalkingData, 热云, adjust)，第三方简称=“dsp”
    'THIRD_PARTY' => [
        'mn' => 'dsp',
        'um' => 'dsp',
        '3rd' => '3rd',
    ],
];
