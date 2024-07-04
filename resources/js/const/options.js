import { BOOLEAN } from "@/const";
import i18n from "@/i18n";
const { t } = i18n.global;
export const timeOption = [
    { label: "分", value: "0" },
    { label: "時間", value: "1" },
];
export const optionPublicAndPrivate = [
    {
        label: "非公開",
        value: 0,
    },
    {
        label: "公開",
        value: 1,
    },
];
export const optionSettingPurposeOfUse = [
    {
        label: "カテゴリー",
        value: "category",
    },
    {
        label: "PC検索",
        value: "computer",
    },
    {
        label: "モバイル検索",
        value: "mobile",
    },
];
export const dayOfWeek = ["月", "火", "水", "木", "金", "土", "日"];
export const optionNotes = {
    normal: {
        text: "背景色とマークについて",
        backGround: "bg-white",
    },
    in_the_past: {
        text: "過去のため、設定不可 ー",
        backGround: "bg-[#c3c3c3]",
    },
    reserved: {
        text: "予約済みのため、設定不可",
        backGround: "bg-[#adfdaf]",
    },
    no_vacancies: {
        text: "空室なし設定済みのため、設定不可",
        backGround: "bg-[#fede41]",
    },
    cleaning_time: {
        text: "清掃時間のため、設定不可",
        backGround: "bg-[#feb9c9]",
    },
    special_day: {
        text: "特別日設定済み",
        backGround: "bg-[#aed9e5]",
    },
};
export const reservationDeadlineTypeOption = [
    {
        label: "分前まで受け付け",
        value: "0",
    },
    {
        label: "時間前まで受け付け",
        value: "1",
    },
    {
        label: "日前まで受け付け",
        value: "2",
    },
];
export const amountTypeOption = [
    {
        label: "円",
        value: "0",
    },
    {
        label: "%",
        value: "1",
    },
];
export const cleaningTimeSettingOption = [
    {
        label: "なし",
        value: "0",
    },
    {
        label: "30 分",
        value: "30",
    },
    {
        label: "60 分",
        value: "60",
    },
    {
        label: "90 分",
        value: "90",
    },
    {
        label: "120 分",
        value: "120",
    },
];
export const optionsBookingType = [
    {
        label: t("rental_plan_page.immediate_reservation_system"),
        value: "instant-reservation",
    },
    {
        label: t("rental_plan_page.request_reservation_system"),
        value: "reservation-request",
    },
];
export const paymentMethodList = [
    {
        label: "クレジットカード",
        value: "credit-card",
        icon: "fa fa-credit-card",
        nameInput: "payment_method_creditCard",
        disabled: true,
    },
    {
        label: "銀行振込",
        value: "bank-transfer",
        icon: "fa fa-university",
        nameInput: "payment_method_bankTransfer",
    },
    {
        label: "当日現金払い",
        value: "cash-on-site",
        icon: "fa fa-money",
        nameInput: "payment_method_cashOnSite",
    },
    {
        label: "Paid",
        value: "paid",
        icon: "",
        nameInput: "payment_method_paid",
    },
    {
        label: "お客様の支払い方法の選択",
        value: "choose-later-by-customer",
        icon: "",
        nameInput: "payment_method_chooseLaterByCustomer",
    },
];
export const reservationApprovalList = [
    {
        label: "月",
        value: 0,
    },
    {
        label: "火",
        value: 1,
    },
    {
        label: "水",
        value: 2,
    },
    {
        label: "木",
        value: 3,
    },
    {
        label: "金",
        value: 4,
    },
    {
        label: "土",
        value: 5,
    },
    {
        label: "日",
        value: 6,
    },
    {
        label: "祝",
        value: 7,
    },
];
export const optionActive = [
    {
        label: "非公開",
        value: BOOLEAN.NO,
    },
    {
        label: "公開",
        value: BOOLEAN.YES,
    },
];
export const optionUnitType = [
    {
        label: "回",
        value: "times",
    },
    {
        label: "個",
        value: "individual",
    },
    {
        label: "本",
        value: "book",
    },
    {
        label: "台",
        value: "table",
    },
    {
        label: "脚",
        value: "legs",
    },
];
export const optionSettingDate = [
    {
        label: "月",
        value: "day.monday",
    },
    {
        label: "火",
        value: "day.tuesday",
    },
    {
        label: "水",
        value: "day.wednesday",
    },
    {
        label: "木",
        value: "day.thursday",
    },
    {
        label: "金",
        value: "day.friday",
    },
    {
        label: "土",
        value: "day.saturday",
    },
    {
        label: "日",
        value: "day.sunday",
    },
];
export const optionSettingDateFull = {
    label: "全ての曜日",
    value: "all",
};
export const optionHolidayType = [
    {
        label: "1.選んだ曜日が<span class='text-[red]'>祝日の場合も、祝日ではない場合も同一</span>の料金を設定する。",
        value: 1,
        icon: "fa fa-calendar-check-o",
        text_table_show: "有効",
    },
    {
        label: "2.選んだ曜日が<span class='text-[red]'>祝日の場合</span>の料金を設定する。",
        value: 2,
        icon: "fa fa-sun-o",
        text_table_show: "祝日のみ有効",
    },
    {
        label: "3.選んだ曜日が<span class='text-[red]'>祝日ではない場合</span>の料金を設定する。",
        value: 3,
        icon: "fa fa-briefcase",
        text_table_show: "祝日でない時のみ有効",
    },
];

export const optionIntervalMulti = [
    { label: "1つの枠を登録", value: 1 },
    { label: "30分単位で複数枠をまとめて登録", value: 2 },
    { label: "1時間単位で複数枠をまとめて登録", value: 3 },
];

export const optionsPageAndEmailMessage = [
    {
        name: "term_of_use",
        label: "利用規約",
        isRequired: true,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "cancellation_policy",
        label: "キャンセルポリシー",
        isRequired: true,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "prohibited_matter",
        label: "禁止事項",
        isRequired: false,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "faq",
        label: "よくある質問",
        isRequired: false,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "notices",
        label: "お知らせ",
        isRequired: false,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "note_from_space",
        label: "スペースからの連絡事項",
        isRequired: false,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "questions_from_space",
        label: "スペースからの確認事項",
        isRequired: false,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "reservation_creation",
        label: "予約完了時のメール",
        isRequired: false,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "reservation_after_payment",
        label: "利用料金の支払い完了時のメール",
        isRequired: false,
        icon: "ml-1 fa fa-question-circle",
    },
    {
        name: "tomorrows_reminder",
        label: "利用日の前日のリマインドメール",
        isRequired: false,
        icon: "ml-1 fa fa-question-circle",
    },
];

export const optionsSelectSortBy = {
    ops1: "登録日時（新しい順）",
    ops2: "合計金額",
    ops3: "口コミ数",
    ops4: "登録日時（古い順）",
};

export const optionsSelectProvin = {
    option1: "都道府県を選択してください。",
    option2: "北海道",
    option3: "青森県",
    option4: "岩手県",
    option5: "宮城県",
    option6: "秋田県",
    option7: "山形県",
    option8: "福島県",
    option9: "茨城県",
    option10: "栃木県",
    option11: "群馬県",
    option12: "埼玉県",
    option13: "千葉県",
    option14: "東京都",
    option15: "神奈川県",
    option16: "新潟県",
    option17: "富山県",
    option18: "石川県",
    option19: "福井県",
    option20: "山梨県",
    option21: "長野県",
    option22: "岐阜県",
    option23: "静岡県",
    option24: "愛知県",
    option25: "三重県",
    option26: "滋賀県",
    option27: "京都府",
    option28: "大阪府",
    option29: "兵庫県",
    option30: "奈良県",
    option31: "和歌山県",
    option32: "鳥取県",
    option33: "島根県",
    option34: "岡山県",
    option35: "広島県",
    option36: "山口県",
    option37: "徳島県",
    option38: "香川県",
    option39: "愛媛県",
    option40: "高知県",
    option41: "福岡県",
    option42: "佐賀県",
    option43: "長崎県",
    option44: "熊本県",
    option45: "大分県",
    option46: "宮崎県",
    option47: "鹿児島県",
    option48: "沖縄県",
};
export const numberPeople = [
    { label: "1人", value: 1 },
    { label: "2人", value: 2 },
    { label: "3人", value: 3 },
    { label: "4人", value: 4 },
    { label: "5人", value: 5 },
    { label: "6人", value: 6 },
    { label: "7人", value: 7 },
    { label: "8人", value: 8 },
    { label: "9人", value: 9 },
    { label: "10人", value: 10 },
];
export const usePurpose = [
    { value: "パーティー", label: 1 },
    { value: "撮影", label: 2 },
    { value: "会議室", label: 3 },
    { value: "民泊", label: 4 },
    { value: "ウェディング", label: 5 },
    { value: "イベント", label: 6 },
    { value: "展示", label: 7 },
    { value: "物販", label: 8 },
    { value: "シェア", label: 9 },
    { value: "広告", label: 10 },
    { value: "菜園", label: 11 },
    { value: "ママ会", label: 12 },
    { value: "その他", label: 13 },
    { value: "カルチャー", label: 14 },
];
export const optionsCheckBoxOderType = [
    { id: 1, val: "ネット予約のみ", label: "ネット予約のみ" },
    { id: 2, val: " 代理予約（スペマネ管理者）", label: " 代理予約（スペマネ管理者）" },
    { id: 3, val: " 代理予約（オーナー）", label: " 代理予約（オーナー）" },
    { id: 4, val: "利用不可日設定", label: "利用不可日設定" },
    { id: 5, val: "Googleカレンダー同期", label: "Googleカレンダー同期" },
    { id: 6, val: "仮予約", label: "仮予約" },
];
export const optionsCheckBoxPurposeUse = [
    { id: 1, val: "パーティー", label: "パーティー" },
    { id: 2, val: " 撮影", label: " 撮影" },
    { id: 3, val: "会議室", label: "会議室" },
    { id: 4, val: "民泊", label: "民泊" },
    { id: 5, val: "ウェディング", label: "ウェディング" },
    { id: 6, val: "イベント", label: "イベント" },
    { id: 7, val: "展示", label: "展示" },
    { id: 8, val: "物販", label: "物販" },
    { id: 9, val: "シェア", label: "シェア" },
    { id: 10, val: " 広告", label: " 広告" },
    { id: 11, val: "菜園", label: "菜園" },
    { id: 12, val: "ママ会", label: "ママ会" },
    { id: 13, val: "その他", label: "その他" },
    { id: 14, val: " カルチャー", label: " カルチャー" },
];
export const optionsCheckBoxStatus = [
    { id: 1, val: "当日手渡し予定", label: "当日手渡し予定" },
    { id: 2, val: "現金払い完了", label: "現金払い完了" },
    { id: 3, val: "振込予定", label: "振込予定" },
    { id: 4, val: "入金済み", label: "入金済み" },
    { id: 5, val: "カード課金予定", label: "カード課金予定" },
    { id: 6, val: "カード課金済み", label: "カード課金済み" },
    { id: 7, val: "返金済み", label: "返金済み" },
    { id: 8, val: "カード課金失敗", label: "カード課金失敗" },
    { id: 9, val: "カード情報入力待ち", label: "カード情報入力待ち" },
    { id: 10, val: "キャンセル済み (ペナルティ無し)", label: "キャンセル済み (ペナルティ無し)" },
    { id: 11, val: "キャンセル済み (ペナルティ)", label: "キャンセル済み (ペナルティ)" },
    { id: 12, val: "", label: "" },
    { id: 13, val: "オーナーからの承認待ち", label: "オーナーからの承認待ち" },
    { id: 14, val: "オーナーによる否認", label: "オーナーによる否認" },
    { id: 15, val: "時間切れによる否認", label: "時間切れによる否認" },
    { id: 16, val: "予約リクエスト取消済", label: "予約リクエスト取消済" },
    { id: 17, val: "クレカ未入力取消", label: "クレカ未入力取消" },
    { id: 18, val: "その他", label: "その他" },
    { id: 19, val: "代理予約：上長承認待ち", label: "代理予約：上長承認待ち" },
    { id: 20, val: "上長により否認", label: "上長により否認" },
    { id: 21, val: "代理予約：お客様支払い方法選択中", label: "代理予約：お客様支払い方法選択中" },
    { id: 22, val: " お客様支払選択の取消(代理予約)", label: " お客様支払選択の取消(代理予約)" },
    { id: 23, val: "キャンセルリクエスト中", label: "キャンセルリクエスト中" },
    { id: 24, val: "外部予約登録", label: "外部予約登録" },
];
export const optionEffectiveness = [
    {
        label: "いいえ",
        value: 0,
    },
    {
        label: "はい",
        value: 1,
    },
];
export const optionUse = [
    {
        label: "パーティー",
        value: "use-purpose-category-68",
    },
    {
        label: "撮影",
        value: "use-purpose-category-87",
    },
    {
        label: "会議室",
        value: "use-purpose-category-116",
    },
    {
        label: "民泊",
        value: "use-purpose-category-141",
    },
    {
        label: "ウェディング",
        value: "use-purpose-category-78",
    },
    {
        label: "イベント",
        value: "use-purpose-category-110",
    },
    {
        label: "展示",
        value: "use-purpose-category-103",
    },
    {
        label: "物販",
        value: "use-purpose-category-106",
    },
    {
        label: "シェア",
        value: "use-purpose-category-122",
    },
    {
        label: "広告",
        value: "use-purpose-category-127",
    },
    {
        label: "菜園",
        value: "use-purpose-category-133",
    },
    {
        label: "ママ会",
        value: "use-purpose-category-145",
    },
    {
        label: "その他",
        value: "use-purpose-category-137",
    },
    {
        label: "温泉",
        value: "use-purpose-category-147",
    },
    {
        label: "スポーツ（テスト）",
        value: "use-purpose-category-164",
    },
    {
        label: "カルチャー",
        value: "use-purpose-category-166",
    },
];
export const optionArea = [
    {
        label: "都道府県を選択してください。（東京23区の場合は区名）",
        value: 1,
    },
    {
        label: "千代田区",
        value: 2,
    },
    {
        label: "中央区",
        value: 3,
    },
    {
        label: "港区",
        value: 4,
    },
    {
        label: "新宿区",
        value: 5,
    },
    {
        label: "文京区",
        value: 6,
    },
    {
        label: "台東区",
        value: 7,
    },
    {
        label: "墨田区",
        value: 8,
    },
    {
        label: "江東区",
        value: 9,
    },
    {
        label: "品川区",
        value: 10,
    },
    {
        label: "目黒区",
        value: 11,
    },
    {
        label: "大田区",
        value: 12,
    },
    {
        label: "世田谷区",
        value: 13,
    },
    {
        label: "渋谷区",
        value: 14,
    },
    {
        label: "中野区",
        value: 15,
    },
    {
        label: "杉並区",
        value: 16,
    },
    {
        label: "豊島区",
        value: 17,
    },
    {
        label: "北区",
        value: 18,
    },
    {
        label: "荒川区",
        value: 19,
    },
    {
        label: "板橋区",
        value: 20,
    },
    {
        label: "練馬区",
        value: 21,
    },
    {
        label: "足立区",
        value: 22,
    },
    {
        label: "葛飾区",
        value: 23,
    },
    {
        label: "江戸川区",
        value: 24,
    },
    {
        label: "東京その他",
        value: 25,
    },
    {
        label: "神奈川県",
        value: 26,
    },
    {
        label: "埼玉県",
        value: 27,
    },
    {
        label: "千葉県",
        value: 28,
    },
    {
        label: "栃木県",
        value: 29,
    },
    {
        label: "茨城県",
        value: 30,
    },
    {
        label: "群馬県",
        value: 31,
    },
    {
        label: "北海道",
        value: 32,
    },
    {
        label: "青森県",
        value: 33,
    },
    {
        label: "秋田県",
        value: 34,
    },
    {
        label: "山形県",
        value: 35,
    },
    {
        label: "岩手県",
        value: 36,
    },
    {
        label: "宮城県",
        value: 37,
    },
    {
        label: "福島県",
        value: 38,
    },
    {
        label: "新潟県",
        value: 39,
    },
    {
        label: "石川県",
        value: 40,
    },
    {
        label: "富山県",
        value: 41,
    },
    {
        label: "福井県",
        value: 42,
    },
    {
        label: "愛知県",
        value: 43,
    },
    {
        label: "岐阜県",
        value: 44,
    },
    {
        label: "静岡県",
        value: 45,
    },
    {
        label: "山梨県",
        value: 46,
    },
    {
        label: "長野県",
        value: 47,
    },
    {
        label: "大阪府",
        value: 48,
    },
    {
        label: "兵庫県",
        value: 49,
    },
    {
        label: "京都府",
        value: 50,
    },
    {
        label: "滋賀県",
        value: 51,
    },
    {
        label: "奈良県",
        value: 52,
    },
    {
        label: "和歌山県",
        value: 53,
    },
    {
        label: "三重県",
        value: 54,
    },
    {
        label: "岡山県",
        value: 55,
    },
    {
        label: "広島県",
        value: 56,
    },
    {
        label: "鳥取県",
        value: 57,
    },
    {
        label: "島根県",
        value: 58,
    },
    {
        label: "山口県",
        value: 59,
    },
    {
        label: "香川県",
        value: 60,
    },
    {
        label: "徳島県",
        value: 61,
    },
    {
        label: "愛媛県",
        value: 62,
    },
    {
        label: "高知県",
        value: 63,
    },
    {
        label: "福岡県",
        value: 64,
    },
    {
        label: "佐賀県",
        value: 65,
    },
    {
        label: "長崎県",
        value: 66,
    },
    {
        label: "熊本県",
        value: 67,
    },
    {
        label: "大分県",
        value: 68,
    },
    {
        label: "宮崎県",
        value: 69,
    },
    {
        label: "鹿児島県",
        value: 70,
    },
    {
        label: "沖縄県",
        value: 71,
    },
];
export const optionsImageSettingSummary = [
    {
        label: "PC向けヘッダー",
        value: 1,
    },
    {
        label: "PC向けリスト",
        value: 2,
    },
    {
        label: "モバイル向けヘッダー",
        value: 3,
    },
    {
        label: "モバイル向けリスト",
        value: 4,
    },
];
export const optionOnlineReservationType = [
    {
        label: "すべて",
        value: "any",
    },
    {
        label: "即時予約のみ",
        value: "instant_web_reservation",
    },
    {
        label: "リクエスト予約のみ",
        value: "request_web_reservation",
    },
];
export const optionProxyReservationReservationType = [
    {
        label: "すべて",
        value: "any",
    },
    {
        label: "Web予約",
        value: "by_web",
    },
    {
        label: "電話予約(通常)",
        value: "new_by_phone",
    },
    {
        label: "電話予約(延長・追加)",
        value: "update_by_phone",
    },
];
export const conditionFilter = [
    {
        label: "利用予定日 (古い順)",
        value: "day_ident_ascending",
    },
    {
        label: "利用予定日 (新しい順)",
        value: "day_ident_descending",
    },
    {
        label: "合計金額 (安い順)",
        value: "total_price_ascending",
    },
    {
        label: "合計金額 (高い順)",
        value: "total_price_descending",
    },
    {
        label: "予約完了日時 (古い順)",
        value: "creation_time_ascending",
    },
    {
        label: "予約完了日時 (新しい順)",
        value: "creation_time_descending",
    },
];
export const optionYesOrNo = [
    {
        label: "すべて",
        value: "any",
    },
    {
        label: "あり",
        value: "has",
    },
    {
        label: "なし",
        value: "not_used",
    },
];
export const optionUserCategory = [
    {
        label: "すべて",
        value: "any",
    },
    {
        label: "法人利用",
        value: "organization",
    },
    {
        label: "個人利用",
        value: "indivisual",
    },
    {
        label: "未選択",
        value: "unselected",
    },
];
