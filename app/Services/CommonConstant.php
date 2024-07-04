<?php

/**
 * Created by PhpStorm.
 * User: sonmh
 * Date: 2022-10-23
 * Time: 8:13 PM
 */

namespace App\Services;


class CommonConstant
{
    const FORMAT_DATE = "Y-m-d";
    const PER_PAGE = 20;

    const LIMIT_PAGE = 1000;
    const MISS_PARAM_CODE = 102;
    const SUCCESS_CODE = 200;
    const CHECK_DATA_INPUT = 'Check data input';

    const ERROR_INTERVAL = 'interval error';
    const MSG_ERROR_PROCESSING = "There was an error in processing";
    const STATUS_ACTIVE = 1;
    const STATUS_UN_ACTIVE = 0;
    const ERROR_CODE = 400;
    const EXIT_DATA = 404;
    const MSG_EXISTS = "error happened";
    const MSG_FAIL_SCV = "wrong format csv file";
    const MSG_EXISTS_DATA = "no data exists";
    const MSG_SUCCESSFUL = "successful";
    const GLOBAL_LINK = 'global';
    const PAGINATE_LIMIT_RESSERVATION = 100;
    const PAGINATE_LIMIT_RESSERVATION_FE = 20;
    const PAGINATE_LIMIT_SPACE_WP = 20;
    const PAGINATE_LIMIT_CAMPAIGN_WP = 20;
    const PAGINATE_LIMIT_ROLLBANNER_WP = 20;
    const PAGINATE_LIMIT_MUNICIPALITIE_WP = 20;
    const PAGINATE_LIMIT_TAG_WP = 20;
    const PAGINATE_LIMIT_PLAN_WP = 20;
    const PAGINATE_LIMIT_EQUIPMENT_CATEGORY_WP = 20;
    const PAGINATE_LIMIT_FREE_SUPPLIES_WP = 20;
    const PAGINATE_LIMIT_PAID_EQUIPMENT_WP = 20;
    const PAGINATE_LIMIT_CUSTOMER = 20;
    const CATEGORY_EQUIPMENT = [
        'basic' => 'Basic information',
        'general' => 'General equipment',
        'conference' => 'conference equipment',
        'photography' => 'Equipment for filming',
        'events' => 'Equipment for events',
        'party' => 'party equipment',
        'share' => 'share',
        'radio-options' => '*Radio button options'
    ];

    const STATUS_RESERVATION = [
        'scheduled-to-be-handed-over-on-the-day' => '当日手渡し予定',
        'card-billing-schedule' => 'カード課金予定',
        'waiting-for-card-information-input' => 'カード情報入力待ち',
        'pending-approval-from-owner' => 'オーナーからの承認待ち',
        'cancel-credit-card-not-entered' => 'クレカ未入力取消',
        'reservation-by-proxy-selecting-customer-payment-method' => '代理予約：お客様支払い方法選択中',
        'completed-cash-payment' => '現金払い完了',
        'card-charged' => 'カード課金済み',
        'canceled-(no-penalty)' => 'キャンセル済み (ペナルティ無し)',
        'denial-by-owner' => 'オーナーによる否認',
        'others' => 'その他',
        'cancellation-of-customer-payment-selection-(proxy-reservation)' => 'お客様支払選択の取消(代理予約)',
        'transfer-schedule' => '振込予定',
        'refunded' => '返金済み',
        'canceled-(penalty)' => 'キャンセル済み (ペナルティ)',
        'reject-due-to-timeout' => '時間切れによる否認',
        'reservation-by-proxy: Waiting for supervisor-approval' => '代理予約：上長承認待ち',
        'requesting-cancellation' => 'キャンセルリクエスト中',
        'deposited' => '入金済み',
        'card-charge-failed' => 'カード課金失敗',
        'reservation-request-canceled' => '予約リクエスト取消済',
        'denied-by-superior' => '上長により否認',
        'external-reservation-registration' => '外部予約登録',
    ];

    const STATUS_TOUR = [
        'pending_request' => 'pending_request',
        'fix_date_time' => 'fix_date_time',
        'waiting_response_user' => 'waiting_response_user',
        'user_cancel' => 'user_cancel',
        'change_date_time' => 'change_date_time',
        'observation_NG' => 'observation_NG'
    ];

    const PURPOSE_OF_USE = [
        'party' => 'パーティー',
        'event' => 'イベント',
        'advertisement' => '広告',
        'culture' => 'カルチャー',
        'minpaku' => '民泊',
        'exhibition' => '展示',
        'vegetable-garden' => '菜園',
        'test' => 'test',
        'conference-room' => '会議室',
        'product-sales' => '物販',
        'mama-party' => 'ママ会',
        'wedding' => 'ウェディング',
        'share' => 'シェア',
        'others' => 'その他',
        'rew' => 'rew',
    ];

    const FRONTEND_RESERVATION_TYPE = [
        'reservation-request' => 'リクエスト予約のみ',
        'instant-reservation' => '即時予約のみ',
        'temporary-reservation' => 'すべて',
    ];

    const RESERVATION_TYPE = [
        'online-reservation-only' => 'ネット予約のみ',
        'google-calendar-sync' => 'Googleカレンダー同期',
        'reservation-on-behalf-of-supemane-manager' => '代理予約（スペマネ管理者）',
        'tentative-reservation' => '仮予約',
        'proxy-booking-owner' => '代理予約（オーナー）',
        'unavailable-date-setting' => '利用不可日設定'
    ];

    const RESERVARION_STATUS_PENDING = "pending-approval-from-owner";
    const RESERVARION_STATUS_PROCESSING = "processing";
    const RESERVARION_STATUS_APPROVED = "reservation-by-proxy: Waiting for supervisor-approval";
    const RESERVARION_STATUS_REJECT = "reject-due-to-timeout";
    const RESERVARION_REQUEST_CANCELED = "reservation-request-canceled";
    const RESERVARION_WAITING_FOR_CARD_INFORMATION_INPUT = "waiting-for-card-information-input";
    const RESERVARION_COMPLETED_CASH_PAYMENT = "completed-cash-payment";

    const LIST_ADDRESS_JP_PAGE_UPDATE_CUSTOMER = [
        '都道府県を選択してください。' => "都道府県を選択してください。",
        '北海道' => "北海道",
        '青森県' => "青森県",
        '岩手県' => "岩手県",
        '宮城県' => "宮城県",
        '秋田県' => "秋田県",
        '山形県' => "山形県",
        '福島県' => "福島県",
        '茨城県' => "茨城県",
        '栃木県' => "栃木県",
        '群馬県' => "群馬県",
        '埼玉県' => "埼玉県",
        '千葉県' => "千葉県",
        '東京都' => "東京都",
        '神奈川県' => "神奈川県",
        '新潟県' => "新潟県",
        '富山県' => "富山県",
        '福井県' => "福井県",
        '山梨県' => "山梨県",
        '長野県' => "長野県",
        '岐阜県' => "岐阜県",
        '静岡県' => "静岡県",
        '三重県' => "三重県",
        '滋賀県' => "滋賀県",
        '京都府' => "京都府",
        '大阪府' => "大阪府",
        '兵庫県' => "兵庫県",
        '奈良県' => "奈良県",
        '和歌山県' => "和歌山県",
        '鳥取県' => "鳥取県",
        '島根県' => "島根県",
        '岡山県' => "岡山県",
        '広島県' => "広島県",
        '山口県' => "山口県",
        '徳島県' => "徳島県",
        '愛媛県' => "愛媛県",
        '高知県' => "高知県",
        '福岡県' => "福岡県",
        '佐賀県' => "佐賀県",
        '長崎県' => "長崎県",
        '熊本県' => "熊本県",
        '大分県' => "大分県",
        '大分県' => "大分県",
        '鹿児島県' => "鹿児島県",
        '沖縄県' => "沖縄県",
    ];
}
