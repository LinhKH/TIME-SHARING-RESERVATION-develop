export const TYPE_COMMON = {
    text: "text",
    textarea: "textarea",
    radio: "radio",
    select: "select",
    twoSelect: "twoSelect",
    multipleSelect: "multipleSelect",
    inputTextSelect: "inputTextSelect",
    checkBox: "checkBox",
    datePicker: "datePicker",
    bus: "bus",
    subway: "subway",
    monorail: "monorail",
    tram: "tram",
    train: "train",
    content: "content",
    image: "image",
    multipleCheckBox: "multipleCheckBox",
    numberOfPeople: "numberOfPeople",
};
export const TYPE_MESSAGE_AND_PAGE = {
    MESSAGE: 1,
    PAGE: 2,
};
export const CATEGORY__PRIORITIZED_PRIORITIZED = "use-purpose-category";
export const LIMIT_TRANSPORTATION = 9;
export const IMAGE_TYPE = {
    NORMAL: "image",
    PANORAMA: "image_panorama",
    FACADE: "image_facade",
    DIRECTION_STATION: "image_direction_station",
    FLOOR_PLAN: "image_floor_plan",
};
export const IMAGE_TYPE_DELETE = {
    NORMAL: "images",
    PANORAMA: "panorama-images",
    FACADE: "facade-images",
    DIRECTION_STATION: "directions-station-images",
    FLOOR_PLAN: "floor-plan",
};
export const ACTIONS_TYPE = {
    UPDATE: "UPDATE",
    CREATE: "CREATE",
    ALL: "all",
};
export const STATUS_RESERVED = "reserved";
export const TYPE_SCREEN = {
    SPACE_ADDING: "space_adding",
    SPACE_EDITING: "space_editing",
    IMAGE_SETTING_COMPILATION: "image_compilation",
    INFO_SETTING_COMPILATION: "info_compilation",
};
export const STATUS_CODE = {
    BadRequest: 400,
    Unauthorized: 401,
    Forbidden: 403,
    TooManyRequests: 429,
    ValidationFailed: 422,
    InternalServerError: 500,
};

export const FORM_DATA_GENERAL_FROM_API = {
    EQUIPMENT_BASIC_INFORMATION: "equipmentBasicInformation",
    EQUIPMENT_GENERAL_INFORMATION: "equipmentGeneralInformation",
    EQUIPMENT_CONFERENCE_INFORMATION: "equipmentConferenceInformation",
    EQUIPMENT_SHOOTING_INFORMATION: "equipmentShootingInformation",
    EQUIPMENT_EVENT_INFORMATION: "equipmentEventInformation",
    EQUIPMENT_PARTY_INFORMATION: "equipmentPartyInformation",
    EQUIPMENT_SHARE_INFORMATION: "equipmentShareInformation",
};

export const STATUS_SPACE = {
    PUBLIC: "published",
    PENDING: "pending",
    ARCHIVED: "archived",
    PENDING_APPROVAL: "pending-approval",
};

export const STATUS_RESERVATION = {
    PENDING: 0,
    PROCESSING: 1,
    APPROVED: 2,
    REJECT: 3,
    REQUESTING_CANCELLATION: 4,
    WAITING: 5,
    COMPLETED: 6,
};

export const TYPE_USER = {
    USER: "user",
    ADMIN: "admin",
};

export const PAGE_DEFAULT = 1;

export const STEP_CREATE_SPACE = {
    GENERAL: 1,
    IMAGE: 2,
    EQUIPMENT_INFORMATION: 3,
    BOOKING_SYSTEM: 4,
    RESERVATION_OPTION: 5,
    PLAN_CREATION: 6,
    PLAN_CREATE_RESERVATION_FRAME: 7,
    PAGE_AND_EMAIL_MESSAGE: 8,
    APPROVE: 9,
};
export const STEP_SPACE_CREATED = {
    general: STEP_CREATE_SPACE.GENERAL,
    images: STEP_CREATE_SPACE.IMAGE,
    "equipment-information": STEP_CREATE_SPACE.EQUIPMENT_INFORMATION,
    "booking-system": STEP_CREATE_SPACE.BOOKING_SYSTEM,
    "reservation-options": STEP_CREATE_SPACE.RESERVATION_OPTION,
    "plan-creation": STEP_CREATE_SPACE.PLAN_CREATION,
    "plan-create-reservation-frame": STEP_CREATE_SPACE.PLAN_CREATE_RESERVATION_FRAME,
    "page-and-email-message": STEP_CREATE_SPACE.PAGE_AND_EMAIL_MESSAGE,
    approve: STEP_CREATE_SPACE.APPROVE,
};
export const STEP_EDIT_SPACE = {
    SPACE_DETAILS: "SPACE_DETAILS",
    RECOMMENDATION: "RECOMMENDATION",
    IMAGE: "IMAGE",
    EQUIPMENT_INFORMATION: "EQUIPMENT_INFORMATION",
    RESERVATION_SYSTEM: "RESERVATION_SYSTEM",
    TERMS: "TERMS",
    INSERT_MESSAGE: "INSERT_MESSAGE",
    DEGREE_PHOTO: "DEGREE_PHOTO",
    APPEARANCE_ENTRANCE: "APPEARANCE_ENTRANCE",
    STATION_ROUTE: "STATION_ROUTE",
    DRAWING: "DRAWING",
    WORD_OF_MOUTH: "WORD_OF_MOUTH",
    TRANSPORTATION_FACILITIES: "TRANSPORTATION_FACILITIES",
};

export const BOOLEAN = {
    YES: 1,
    NO: 2,
};

export const ROUTER_PATH = {
    //ROUTER_COMMON
    HOME: "/",
    EMPTY: "",
    ADD: "add",
    EDIT: "edit",
    RENTAL_PLAN: "rental-plan",
    RENTAL_PLAN_ID: "rental-plan/:id",
    EDIT_ID: "edit/:id",
    EMPTY_ID: ":id",

    // ROUTER_ADMIN
    ADMIN: "/admin",
    LOGIN: "/admin/login",
    RECOVERY_REQUEST: "/admin/user/recovery-request",
    RECOVERY_REQUEST_SUCCESS: "/admin/user/recovery-request-success",
    SPACE: {
        GROUP_EDIT_ID: "group/edit/:idGroup",
        GROUP_EDIT: "group/edit",
        DETAIL_ADD_TRACKING_LINK: "tracking-links/add/rental_space",
        DETAIL_ADD_TRACKING_LINK_ID: "tracking-links/add/rental_space/:id",
        ADD_TRACKING_LINK: "tracking-links/draft-add/rental_space",
        ADD_TRACKING_LINK_ID: "tracking-links/draft-add/rental_space/:id",
        TRACKING_LINK: "booking-system/draft-advanced-settings",
        TRACKING_LINK_ID: "booking-system/draft-advanced-settings/:id",
        FLOOR_PLAN: "floor-plan",
        FLOOR_PLAN_ID: "floor-plan/:id",
        DIRECTIONS_STATION_IMAGES: "directions-station-images",
        DIRECTIONS_STATION_IMAGES_ID: "directions-station-images/:id",
        FACADE_IMAGES: "facade-images",
        FACADE_IMAGES_ID: "facade-images/:id",
        PANORAMA_IMAGES: "panorama-images",
        PANORAMA_IMAGES_ID: "panorama-images/:id",
        PLAN_EDIT: "plan/edit",
        PLAN_EDIT_ID: "plan/edit/:id",
        GROUP_MANAGE_ID: "group/manage/:id",
        PAGE_MANAGE_ID: "page/manage/:id",
        PAGE_MANAGE: "page/manage",
        MESSAGE_MANAGE_ID: "message/manage/:id",
        MESSAGE_MANAGE: "message/manage",
        GROUP_MANAGE: "group/manage",
        GROUP_ADD_ID: "group/add/:id",
        GROUP_ADD: "group/add",
        GENERAL: "general",
        IMAGES_ID: "images/:id",
        IMAGES: "images",
        EQUIPMENT_INFORMATION: "equipment-information",
        EQUIPMENT_INFORMATION_ID: "equipment-information/:id",
        BOOKING_SYSTEM: "booking-system",
        RESERVATION_SYSTEM: "reservation-system",
        RESERVATION_SYSTEM_ID: "reservation-system/:id",
        TRANSPORTATION_FACILITIES: "transportation_facilities",
        TRANSPORTATION_FACILITIES_ID: "transportation_facilities/:id",
        RESERVATION_OPTIONS: "reservation-options",
        RENTAL_INTERVAL_CONFIG_OVERRIDE: "rental-interval-config-override",
        RENTAL_INTERVAL_CONFIG_OVERRIDE_ID: "rental-interval-config-override/:id",
        BOOKING_SYSTEM_ADVANCED_SETTINGS: "booking-system-advanced-settings",
        BOOKING_SYSTEM_ADVANCED_SETTINGS_ID: "booking-system-advanced-settings/:id",
        RESERVATION_SYSTEM_RESERVATION_OPTIONS: "reservation-system-reservation-options",
        RESERVATION_SYSTEM_RESERVATION_OPTIONS_ID: "reservation-system-reservation-options/:id",
        RENTAL_PLAN: "rental-plan",
        RENTAL_PLAN_EDIT_ROUTER: {
            RENTAL_PLAN_ADD: "add-plan",
            RENTAL_PLAN_ADD_ID: "add-plan/:id",
        },
        LIST_PLAN_INTERVAL: "list-plan-interval",
        ADD_PLAN_INTERVAL: "plan-interval",
        EDIT_PLAN_INTERVAL: "edit-plan-interval",
        EMAIL_MESSAGE: "page-and-email-message",
        APPROVAL: "approval",
        RENTAL_PLAN_DETAIL_MESSAGE: "rental-plan-detail-message",
        RENTAL_PLAN_DETAIL_PAGE: "rental-plan-detail-page",
        RENTAL_PLAN_DETAIL_MESSAGE_ID: "rental-plan-detail-message/:id",
        RENTAL_PLAN_DETAIL_PAGE_ID: "rental-plan-detail-page/:id",
    },
    GOOGLE_COLLABORATION: "google-collaboration",
    GOOGLE_CALENDAR: "google-calendar/:id",
    USER_MANAGER: "user-manage",
    ORDER: "rental-spaces",
    TOUR: "tour",
    TOUR_LIST: "tour-list",
    TOUR_SETTING: "tour-setting",
    TOUR_GUIDE: "tour-guide",
    INQUIRIES: "inquiries",
    INQUIRIES_DETAIL: "inquiries/view",
    TOUR_TABLE: "list_tour",
    APPROVAL_CONFIRM_TOUR: "confirm_tour",
    NON_APPROVAL_CONFIRM_TOUR: "non_confirm_tour",
    TOUR_MANAGER: {
        TOUR_LIST: "list",
        TOUR_SETTING: "setting",
        TOUR_GUIDE: "guide",
        TOUR_DETAIL: "tour/:id",
    },
    DASHBOARD: "dashboard",
    CONFIGURATION: "configuration",
    RESERVATIONS: "reservations",
    LIST_CUSTOMER: "list-customer",
    RESERVATION_CALENDAR: "reservation-calendar",
    RESERVATION_REGISTER: "reservation-register",
    CUSTOMER_VIEW_ID: "customer-view/:id",
    CUSTOMER_VIEW: "customer-view",
    SYSTEM_CONFIG: "system-config",
    NEWS: "news",
    NEWS_ADD: "news/add",
    FOOTER_LINKS_ADD: "footer_links/add",
    FOOD_CATEGORY_ADD: "footer-links/category/add",
    CUSTOMER_NEWS: "customer-news",
    FAQ: "faq",
    STATIC_PAGE: "static-page",
    HTML_PAGE: "html-page",
    RENTAL_SPACE_COMPILATION: "rental-space-compilation/manage",
    RENTAL_SPACE_COMPILATION_ADD: "rental-space-compilation/add",
    RENTAL_SPACE_COMPILATION_EDIT: "rental-space-compilation/edit",
    SLIDE: "slide",
    META: "meta",
    RENTAL_SPACE_USE_PURPOSE: "rental-space-use-purpose",
    RENTAL_SPACE_EQUIPMENT_INFORMATION: "rental-space-equipment-information",
    RENTAL_SPACE_EQUIPMENT_INFORMATION_ADD: "rental-space-equipment-information/add",
    RENTAL_SPACE_EQUIPMENT_INFORMATION_EDIT: "rental-space-equipment-information/edit",
    AREA: "area",
    AREA_GROUP: "area-group/middle_level/manage",
    AREA_GROUP_ADD: "area-group/middle_level/add",
    AREA_GROUP_EDIT: "area-group/middle_level/edit",
    AREA_GROUP_LOW_LEVEL: "area-group/middle_level/low-level",
    AREA_GROUP_LOW_LEVEL_EDIT: "area-group/middle_level/low-level/edit",
    AREA_LOW_LEVER_MANAGE: "area-group/middle_level/low-level/manage",
    EMAIL_TEMPLATE: "email-template",
    RENTAL_SPACE_POINTS: "rental-space-points",
    ORGANIZATION: "organization",
    REQUEST_MANAGEMENT: "request-management",
    DOCUMENTATION: "documentation/explorer/browse",
    FOOTER_LINKS: "footer_links",
    HOLIDAY_INFO: "holiday-info",
    PAYOUT: "payout",
    RENTAL_SPACE_COUPONS: "rental-space-coupons",
    CAMPAIGN: "campaign",
    TRACKING_LINKS: "tracking-links/manage",
    TRACKING_LINKS_ADD: "tracking-links/add/global",
    TRACKING_LINKS_EDIT: "tracking-links/edit/:id",
    XML_EXPORT: "xml-export",
    CSV_EXPORT: "csv-export",
    CSV_MANAGE_RESERVATIONS: "csv-export/manage/reservations",
    FIRST_CONTRACTOR: "first-contractor",
    EXTERNAL_RESERVATION: "external-reservation",
    RESERVATION_REGISTER_RESERVED: "reservation/reserved",
    STATIC_PAGE_ADD: "static-page-add",
    EMAIL_TEMPLATE_ADD: "email-template/add",
    EMAIL_TEMPLATE_EDIT: "email-template/edit",
    HOLIDAY_IMPORT: "holiday-info-import",
    MANAGE_COUPON_DETAIL: "manager-coupon-detail",
    RESERVATIONS_CONFIRMATION: "manage/confirmation",
    PURPOSE_OF_USE: "purpose-of-use",
    PURPOSE_CATEGORY: "purpose-category",
    PURPOSE_OF_USE_DETAIL: "purpose-of-use/detail",
    LARGE_AREA_DETAIL: "large-area/detail",
    // ROUTER_CUSTOMER
    REGISTER_CUSTOMER: "/register",
    LOGIN_CUSTOMER: "/login",
    OVERVIEW_USER: "overview-user",
    SPACE_DETAILS_CLIENT: "space-details-client",
    RESERVATIONS_MANAGE: "list",
    SPACE_TOUR: "/space/tour",
};
export const ROUTE_NAME = {
    ADMIN: {
        TOUR_LIST: "AdminTourList",
        TOUR_SETTING: "AdminTourSetting",
        TOUR_GUIDE: "AdminTourGuide",
        TOUR_CONFIRM: "AdminTourConfirm",
        TRACKING_LINKS: "AdminTracking",
        TRACKING_LINKS_ADD: "AdminTrackingAdd",
        TRACKING_LINKS_EDIT: "AdminTrackingEdit",
        STATIC_PAGE: "AdminPages",
        STATIC_PAGE_ADD: "AdminPagesAdd",
        STATIC_PAGE_EDIT: "AdminPagesEdit",
        RENTAL_SPACE_COMPILATION: "AdminRentalSpace",
        RENTAL_SPACE_COMPILATION_ADD: "AdminRentalSpaceAdd",
        RENTAL_SPACE_COMPILATION_EDIT: "AdminRentalSpaceEdit",
        NEWS: "AdminNews",
        NEWS_ADD: "AdminNewsAdd",
        NEWS_EDIT: "AdminNewsEdit",
        RENTAL_SPACE_USE_PURPOSE: "AdminSpacePurpose",
        PURPOSE_OF_USE_DETAIL: "AdminSpacePurposeDetail",
        RENTAL_SPACE_EQUIPMENT_INFORMATION: "AdminRentalSpaceEquipmentInformation",
        RENTAL_SPACE_EQUIPMENT_INFORMATION_ADD: "AdminRentalSpaceEquipmentInformationAdd",
        RENTAL_SPACE_EQUIPMENT_INFORMATION_EDIT: "AdminRentalSpaceEquipmentInformationEdit",
        AREA: "AdminArea",
        AREA_EDIT: "AdminAreaEdit",
        AREA_GROUP: "AdminAreaGroup",
        AREA_GROUP_ADD: "AdminAreaGroupAdd",
        AREA_GROUP_EDIT: "AdminAreaGroupEdit",
        AREA_GROUP_LOW_LEVEL: "AdminAreaGroupLowLevelEdit",
        AREA_GROUP_LOW_LEVEL_EDIT: "AdminAreaGroupLowLevelEditEdit",
        AREA_LOW_LEVER_MANAGE: "AdminAreaGroupLowLevelManager",
        EMAIL_TEMPLATE: "AdminEmailTemplate",
        EMAIL_TEMPLATE_ADD: "AdminEmailTemplateAdd",
        EMAIL_TEMPLATE_EDIT: "AdminEmailTemplateEdit",
        FOOTER_LINKS: "AdminFooterLinks",
        FOOTER_LINKS_ADD: "AdminFooterLinksAdd",
        FOOD_CATEGORY_ADD: "AdminFoodCategoryAdd",
        HOLIDAY_INFO: "AdminHolidayInfo",
        HOLIDAY_IMPORT: "AdminHolidayAdd",
        RENTAL_SPACE_COUPONS: "AdminCoupons",
        RENTAL_SPACE_COUPONS_EDIT: "AdminCouponsEdit",
        CSV_EXPORT: "AdminCsvExport",
        CSV_MANAGE_RESERVATIONS: "AdminCsvManageReservation",
        ADMIN_EDIT_MANAGER: "admin_edit_manager",
        ADMIN_UPDATE_INFO: "ADMIN_UPDATE_INFO",
    },
};
export const NESTED_ROUTE = {
    AdminTracking: [ROUTE_NAME.ADMIN.TRACKING_LINKS_ADD, ROUTE_NAME.ADMIN.TRACKING_LINKS_EDIT],
    AdminPages: [ROUTE_NAME.ADMIN.STATIC_PAGE_ADD],
    AdminRentalSpace: [ROUTE_NAME.ADMIN.RENTAL_SPACE_COMPILATION_ADD, ROUTE_NAME.ADMIN.RENTAL_SPACE_COMPILATION_EDIT],
    AdminNews: [ROUTE_NAME.ADMIN.NEWS_ADD],
    AdminSpacePurpose: [ROUTE_NAME.ADMIN.PURPOSE_OF_USE_DETAIL],
    AdminRentalSpaceEquipmentInformation: [
        ROUTE_NAME.ADMIN.RENTAL_SPACE_EQUIPMENT_INFORMATION_EDIT,
        ROUTE_NAME.ADMIN.RENTAL_SPACE_EQUIPMENT_INFORMATION_ADD,
    ],
    AdminArea: [ROUTE_NAME.ADMIN.AREA_EDIT],
    AdminAreaGroup: [
        ROUTE_NAME.ADMIN.AREA_GROUP_ADD,
        ROUTE_NAME.ADMIN.AREA_GROUP_EDIT,
        ROUTE_NAME.ADMIN.AREA_GROUP_LOW_LEVEL,
        ROUTE_NAME.ADMIN.AREA_GROUP_LOW_LEVEL_EDIT,
        ROUTE_NAME.ADMIN.AREA_LOW_LEVER_MANAGE,
    ],
    AdminEmailTemplate: [ROUTE_NAME.ADMIN.EMAIL_TEMPLATE_ADD, ROUTE_NAME.ADMIN.EMAIL_TEMPLATE_EDIT],
    AdminFooterLinks: [ROUTE_NAME.ADMIN.FOOTER_LINKS_ADD, ROUTE_NAME.ADMIN.FOOD_CATEGORY_ADD],
    AdminHolidayInfo: [ROUTE_NAME.ADMIN.HOLIDAY_IMPORT],
    AdminCoupons: [ROUTE_NAME.ADMIN.RENTAL_SPACE_COUPONS_EDIT],
    AdminCsvExport: [ROUTE_NAME.ADMIN.CSV_MANAGE_RESERVATIONS],
};

export const STEP_CREATE_SPACE_FROM_API = {
    general: ROUTER_PATH.SPACE.GENERAL,
    images: ROUTER_PATH.SPACE.IMAGES,
    "equipment-information": ROUTER_PATH.SPACE.EQUIPMENT_INFORMATION,
    "booking-system": ROUTER_PATH.SPACE.BOOKING_SYSTEM,
    "reservation-options": ROUTER_PATH.SPACE.RESERVATION_OPTIONS,
    "plan-creation": ROUTER_PATH.SPACE.RENTAL_PLAN,
    "plan-create-reservation-frame": ROUTER_PATH.SPACE.LIST_PLAN_INTERVAL,
    "page-and-email-message": ROUTER_PATH.SPACE.EMAIL_MESSAGE,
    approve: ROUTER_PATH.SPACE.APPROVAL,
};

export const MODULE_STORE = {
    RENTAL_SPACES: {
        NAME: "RENTAL_SPACES",
        GETTERS: {
            GET_LIST_STEPS: "GET_LIST_STEPS",
            GET_NAME_SPACE: "GET_NAME_SPACE",
            GET_LIST_STEP_EDIT: "GET_LIST_STEP_EDIT",
            GET_ID_EDIT_SPACE: "GET_ID_EDIT_SPACE",
            GET_ID_PLAN: "GET_ID_PLAN",
            GET_STEP_SPACE_CREATED: "GET_STEP_SPACE_CREATED",
            GET_NAME_PLAN_CURRENT: "GET_NAME_PLAN_CURRENT",
        },
        ACTIONS: {
            SET_ACTIVE: "SET_ACTIVE",
            SET_ACTIVE_EDIT: "SET_ACTIVE_EDIT",
        },
        MUTATIONS: {
            SET_ID_PLAN: "SET_ID_PLAN",
            SET_NAME_SPACE: "SET_NAME_SPACE",
            SET_STEP_EDIT_SPACE: "SET_STEP_EDIT_SPACE",
            SET_ID_EDIT_SPACE: "SET_ID_EDIT_SPACE",
            SET_NAME_PLAN_CURRENT: "SET_NAME_PLAN_CURRENT",
            SET_STEP_SPACE_CREATED: "SET_STEP_SPACE_CREATED",
        },
    },

    AUTH: {
        NAME: "AUTH",
        GETTERS: {},
        ACTIONS: {},
        MUTATIONS: {},
    },

    COMMON: {
        NAME: "COMMON",
        GETTERS: {
            GET_IS_LOADING: "GET_IS_LOADING",
        },
        ACTIONS: {},
        MUTATIONS: {},
    },

    SETTING: {
        NAME: "SETTING",
        GETTERS: {
            GET_LIST_CATEGORY_PURPOSE_OF_USE: "GET_LIST_CATEGORY_PURPOSE_OF_USE",
        },
        ACTIONS: {
            SET_ACTIVE_CATEGORY_PURPOSE: "SET_ACTIVE_CATEGORY_PURPOSE",
        },
        MUTATIONS: {},
    },
};

export const FORM_USER_MANAGE = {
    ORGANIZATION: "organization",
    ADMIN: "admin",
    MALE: "male",
    FEMALE: "female",
    INQUIRY: "inquiry",
    USER: "user",
    RESERVATION: "reservation",
    RESERVATION_COMPENSATION_CHARGE: "reservation_compensation_charge",
    CUSTOMER: "customer",
    RENTAL_SPACE: "rental_space",
    ALL: "all",
    SUPERVISOR: "supervisor",
    BILLING: "billing",
};

export const OPTIONS_MAIN_CATEGORY = [
    {
        label: "-- メインカテゴリーを選択してください --",
        value: "",
    },
];

export const OPTIONS_SUB_CATEGORY = {
    "use-purpose-category-68": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "ウェディング二次会",
            value: "69",
        },
        {
            label: "懇親会",
            value: "70",
        },
        {
            label: "貸切パーティー",
            value: "71",
        },
        {
            label: "箱貸しOK",
            value: "72",
        },
        {
            label: "少人数利用可能",
            value: "73",
        },
        {
            label: "合コン",
            value: "74",
        },
        {
            label: "慶事・法事",
            value: "75",
        },
        {
            label: "BBQ",
            value: "76",
        },
        {
            label: "その他",
            value: "77",
        },
    ],
    "use-purpose-category-87": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "撮影スタジオ",
            value: "88",
        },
        {
            label: "ハウススタジオ",
            value: "89",
        },
        {
            label: "キッチンスタジオ",
            value: "90",
        },
        {
            label: "一棟ビル",
            value: "91",
        },
        {
            label: "レストラン・カフェ",
            value: "92",
        },
        {
            label: "バー・クラブ",
            value: "93",
        },
        {
            label: "一軒家・洋館",
            value: "94",
        },
        {
            label: "庭付き",
            value: "95",
        },
        {
            label: "オフィス",
            value: "96",
        },
        {
            label: "屋上",
            value: "97",
        },
        {
            label: "倉庫",
            value: "98",
        },
        {
            label: "公共施設",
            value: "99",
        },
        {
            label: "異空間",
            value: "100",
        },
        {
            label: "海岸沿い",
            value: "101",
        },
        {
            label: "その他",
            value: "102",
        },
    ],
    "use-purpose-category-116": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "ハイグレード",
            value: "117",
        },
        {
            label: "スタンダード",
            value: "118",
        },
        {
            label: "リーズナブル",
            value: "119",
        },
        {
            label: "会議室ぽくない",
            value: "120",
        },
        {
            label: "その他",
            value: "121",
        },
    ],
    "use-purpose-category-141": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "家族で利用",
            value: "142",
        },
        {
            label: "二人で利用",
            value: "143",
        },
        {
            label: "一人で利用",
            value: "144",
        },
    ],
    "use-purpose-category-78": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "ホテル",
            value: "79",
        },
        {
            label: "レストラン",
            value: "80",
        },
        {
            label: "ガーデンウェディング",
            value: "81",
        },
        {
            label: "神社・仏閣",
            value: "82",
        },
        {
            label: "教会",
            value: "83",
        },
        {
            label: "船上",
            value: "85",
        },
        {
            label: "その他",
            value: "86",
        },
    ],
    "use-purpose-category-110": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "教室",
            value: "111",
        },
        {
            label: "音楽イベント",
            value: "112",
        },
        {
            label: "ダンス",
            value: "113",
        },
        {
            label: "演劇",
            value: "114",
        },
        {
            label: "その他",
            value: "115",
        },
    ],
    "use-purpose-category-103": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "アパレル",
            value: "104",
        },
        {
            label: "その他",
            value: "105",
        },
    ],
    "use-purpose-category-106": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "ワゴン販売スペース",
            value: "107",
        },
        {
            label: "短期貸し店舗",
            value: "108",
        },
        {
            label: "その他",
            value: "109",
        },
    ],
    "use-purpose-category-122": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "シェアハウス",
            value: "123",
        },
        {
            label: "シェアオフィス",
            value: "124",
        },
        {
            label: "シェアサロン",
            value: "125",
        },
        {
            label: "その他",
            value: "126",
        },
    ],
    "use-purpose-category-127": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "外壁",
            value: "128",
        },
        {
            label: "ウィンドウ",
            value: "129",
        },
        {
            label: "フリーペーパー・リーフレット",
            value: "130",
        },
        {
            label: "ポスター",
            value: "131",
        },
        {
            label: "その他",
            value: "132",
        },
    ],
    "use-purpose-category-133": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "畑",
            value: "134",
        },
        {
            label: "田んぼ",
            value: "135",
        },
        {
            label: "その他",
            value: "136",
        },
    ],
    "use-purpose-category-145": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
    ],
    "use-purpose-category-137": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
        {
            label: "音楽練習",
            value: "138",
        },
        {
            label: "トランクルーム",
            value: "139",
        },
        {
            label: "その他",
            value: "140",
        },
    ],
    "use-purpose-category-166": [
        {
            label: "-- サブカテゴリーを選択してください --",
            value: "",
        },
    ],
};

export const OPTIONS_DATE = [
    { label: "利用日当日", value: 0 },
    { label: "予約日", value: 180 },
    { label: "1", value: 1 },
    { label: "2", value: 2 },
    { label: "3", value: 3 },
    { label: "4", value: 4 },
    { label: "5", value: 5 },
    { label: "6", value: 6 },
    { label: "7", value: 7 },
    { label: "8", value: 8 },
    { label: "9", value: 9 },
    { label: "10", value: 10 },
    { label: "11", value: 11 },
    { label: "12", value: 12 },
    { label: "13", value: 13 },
    { label: "14", value: 14 },
    { label: "15", value: 15 },
    { label: "16", value: 16 },
    { label: "17", value: 17 },
    { label: "18", value: 18 },
    { label: "19", value: 19 },
    { label: "20", value: 20 },
    { label: "21", value: 21 },
    { label: "22", value: 22 },
    { label: "23", value: 23 },
    { label: "24", value: 24 },
    { label: "25", value: 25 },
    { label: "26", value: 26 },
    { label: "27", value: 27 },
    { label: "28", value: 28 },
    { label: "29", value: 29 },
    { label: "30", value: 30 },
    { label: "31", value: 31 },
    { label: "32", value: 32 },
    { label: "33", value: 33 },
    { label: "34", value: 34 },
    { label: "35", value: 35 },
    { label: "36", value: 36 },
    { label: "37", value: 37 },
    { label: "38", value: 38 },
    { label: "39", value: 39 },
    { label: "40", value: 40 },
    { label: "41", value: 41 },
    { label: "42", value: 42 },
    { label: "43", value: 43 },
    { label: "44", value: 44 },
    { label: "45", value: 45 },
    { label: "46", value: 46 },
    { label: "47", value: 47 },
    { label: "48", value: 48 },
    { label: "49", value: 49 },
    { label: "50", value: 50 },
    { label: "51", value: 51 },
    { label: "52", value: 52 },
    { label: "53", value: 53 },
    { label: "54", value: 54 },
    { label: "55", value: 55 },
    { label: "56", value: 56 },
    { label: "57", value: 57 },
    { label: "58", value: 58 },
    { label: "59", value: 59 },
    { label: "60", value: 60 },
    { label: "61", value: 61 },
    { label: "62", value: 62 },
    { label: "63", value: 63 },
    { label: "64", value: 64 },
    { label: "65", value: 65 },
    { label: "66", value: 66 },
    { label: "67", value: 67 },
    { label: "68", value: 68 },
    { label: "69", value: 69 },
    { label: "70", value: 70 },
    { label: "71", value: 71 },
    { label: "72", value: 72 },
    { label: "73", value: 73 },
    { label: "74", value: 74 },
    { label: "75", value: 75 },
    { label: "76", value: 76 },
    { label: "77", value: 77 },
    { label: "78", value: 78 },
    { label: "79", value: 79 },
    { label: "80", value: 80 },
    { label: "81", value: 81 },
    { label: "82", value: 82 },
    { label: "83", value: 83 },
    { label: "84", value: 84 },
    { label: "85", value: 85 },
    { label: "86", value: 86 },
    { label: "87", value: 87 },
    { label: "88", value: 88 },
    { label: "89", value: 89 },
    { label: "90", value: 90 },
    { label: "91", value: 91 },
    { label: "92", value: 92 },
    { label: "93", value: 93 },
    { label: "94", value: 94 },
    { label: "95", value: 95 },
    { label: "96", value: 96 },
    { label: "97", value: 97 },
    { label: "98", value: 98 },
    { label: "99", value: 99 },
    { label: "100", value: 100 },
    { label: "101", value: 101 },
    { label: "102", value: 102 },
    { label: "103", value: 103 },
    { label: "104", value: 104 },
    { label: "105", value: 105 },
    { label: "106", value: 106 },
    { label: "107", value: 107 },
    { label: "108", value: 108 },
    { label: "109", value: 109 },
    { label: "110", value: 110 },
    { label: "111", value: 111 },
    { label: "112", value: 112 },
    { label: "113", value: 113 },
    { label: "114", value: 114 },
    { label: "115", value: 115 },
    { label: "116", value: 116 },
    { label: "117", value: 117 },
    { label: "118", value: 118 },
    { label: "119", value: 119 },
    { label: "120", value: 120 },
    { label: "121", value: 121 },
    { label: "122", value: 122 },
    { label: "123", value: 123 },
    { label: "124", value: 124 },
    { label: "125", value: 125 },
    { label: "126", value: 126 },
    { label: "127", value: 127 },
    { label: "128", value: 128 },
    { label: "129", value: 129 },
    { label: "130", value: 130 },
    { label: "131", value: 131 },
    { label: "132", value: 132 },
    { label: "133", value: 133 },
    { label: "134", value: 134 },
    { label: "135", value: 135 },
    { label: "136", value: 136 },
    { label: "137", value: 137 },
    { label: "138", value: 138 },
    { label: "139", value: 139 },
    { label: "140", value: 140 },
    { label: "141", value: 141 },
    { label: "142", value: 142 },
    { label: "143", value: 143 },
    { label: "144", value: 144 },
    { label: "145", value: 145 },
    { label: "146", value: 146 },
    { label: "147", value: 147 },
    { label: "148", value: 148 },
    { label: "149", value: 149 },
    { label: "150", value: 150 },
    { label: "151", value: 151 },
    { label: "152", value: 152 },
    { label: "153", value: 153 },
    { label: "154", value: 154 },
    { label: "155", value: 155 },
    { label: "156", value: 156 },
    { label: "157", value: 157 },
    { label: "158", value: 158 },
    { label: "159", value: 159 },
    { label: "160", value: 160 },
    { label: "161", value: 161 },
    { label: "162", value: 162 },
    { label: "163", value: 163 },
    { label: "164", value: 164 },
    { label: "165", value: 165 },
    { label: "166", value: 166 },
    { label: "167", value: 167 },
    { label: "168", value: 168 },
    { label: "169", value: 169 },
    { label: "170", value: 170 },
    { label: "171", value: 171 },
    { label: "172", value: 172 },
    { label: "173", value: 173 },
    { label: "174", value: 174 },
    { label: "175", value: 175 },
    { label: "176", value: 176 },
    { label: "177", value: 177 },
    { label: "178", value: 178 },
    { label: "179", value: 179 },
];

export const OPTIONS_EATING_AND_DRINKING = [
    {
        label: "確認",
        value: "confirmation",
    },
    {
        label: "飲食可",
        value: "food_allowed",
    },
    {
        label: "飲料のみ可",
        value: "drinks_only",
    },
    {
        label: "飲食禁止",
        value: "not_allowed",
    },
    {
        label: "軽飲食可",
        value: "light_food_allowed",
    },
];

export const OPTIONS_SMOKING = [
    {
        label: "確認",
        value: "confirmation",
    },
    {
        label: "室内喫煙可",
        value: "indoor_smoking",
    },
    {
        label: "室内喫煙所有り",
        value: "indoor_non_smoking_has_smoking_area",
    },
    {
        label: "室内喫煙所なし",
        value: "indoor_non_smoking_no_smoking_area",
    },
    {
        label: "分煙",
        value: "separated_areas",
    },
];

export const OPTIONS_RECEIPT_CORRESPONDENCE = [
    {
        label: "不可",
        value: "not_possible",
    },
    {
        label: "可",
        value: "yes",
    },
    {
        label: "冷蔵のみ可",
        value: "refrigerated_only",
    },
    {
        label: "常温のみ可",
        value: "room_temperature_only",
    },
    {
        label: "応相談",
        value: "negotiable",
    },
];

export const OPTIONS_WIFI = [
    {
        label: "無",
        value: "none",
    },
    {
        label: "Wifi(無線LAN)有",
        value: "wifi",
    },
    {
        label: "有線LAN有",
        value: "lan",
    },
];

export const OPTION_AUDIO_SPEAKER = [
    {
        label: "無",
        value: "no",
    },
    {
        label: "有",
        value: "yes",
    },
];

export const OPTIONS_MONITOR = [
    {
        label: "無",
        value: "no",
    },
    {
        label: "有",
        value: "yes",
    },
];

export const OPTIONS_TOILET = [
    {
        label: "確認",
        value: "yes",
    },
    {
        label: "有（男女別）",
        value: "by_gender",
    },
    {
        label: "有（男女共用）",
        value: "unisex",
    },
    {
        label: "無",
        value: "No",
    },
];

export const OPTIONS_ELECTRIC = [
    {
        label: "A",
        value: "a",
    },
    {
        label: "W",
        value: "w",
    },
];

export const OPTIONS_GLASS_COMMON = [
    {
        label: "充分",
        value: "sufficient",
    },
    {
        label: "定員分",
        value: "one_for_each",
    },
    {
        label: "最低限",
        value: "minimum",
    },
    {
        label: "なし",
        value: "none",
    },
    {
        label: "確認",
        value: "confirmation",
    },
];

export const OPTIONS_STOVE = [
    {
        label: "有(IH)",
        value: "yes",
    },
    {
        label: "有(ガス)",
        value: "gas",
    },
    {
        label: "確認",
        value: "confirmation",
    },
    {
        label: "なし",
        value: "none",
    },
];
export const TYPE_STATUS = {
    ACTIVE: "active",
    ARCHIVED: "archived",
};
export const TAX_RATIO = 0.1;
