import { auth, guest } from "./middlewares";
import { ROUTER_PATH, TYPE_SCREEN, TYPE_USER, TYPE_COMMON, ROUTE_NAME } from "@/const";

const ReservationCalendar = () => import("@/views/ReservationsCalendar");
const ReservationRegister = () => import("@/views/ReservationRegister");
const Home = () => import("@/views/Home");
const Login = () => import("@/views/Login");
const RecoveryRequest = () => import("@/views/RecoveryRequest");
const RecoveryRequestPassWordSuccess = () => import("@/views/RecoveryRequestPassWordSuccess");
const ListUserManage = () => import("@/views/ListUserManage");
const Inquiries = () => import("@/views/Inquiries");
const InquiriesDetail = () => import("@/views/InquiriesDetail/InquiriesDetail");
const UserManage = () => import("@/views/UserManage");
const EditUserManage = () => import("@/views/EditUserManage");
const AddUserManage = () => import("@/views/AddUserManage");
const ListOrder = () => import("@/views/ListOrder");
const AddOrder = () => import("@/views/AddOrder");
const EditOrder = () => import("@/views/EditOrder");
const EditSpacesGeneral = () => import("@/views/EditOrder/EditSpacesGeneral");
const EditSpacesImage = () => import("@/views/EditOrder/EditSpacesImage");
const EditSpacesEquipmentInfo = () => import("@/views/EditOrder/EditSpacesEquipmentInfo");
const Order = () => import("@/views/Order");
const FormSetting = () => import("@/views/FormSetting");
const ListCustomer = () => import("@/views/ListCustomer");
const SpacesGeneral = () => import("@/components/Spaces/SpacesGeneral");
const SpacesImage = () => import("@/components/Spaces/SpacesImage");
const SpaceReservationSystem = () => import("@/views/EditOrder/SpaceReservationSystem");
const EquipmentInformation = () => import("@/components/Spaces/EquipmentInformation");
const BookingSystem = () => import("@/components/Spaces/BookingSystem");
const ReservationOptions = () => import("@/components/Spaces/ReservationOptions");
const SpacePlanAddDraft = () => import("@/components/Spaces/ReservationSystem/SpacePlanAdd/SpacePlanAddDraft.vue");
const PageAndEmailMessage = () => import("@/components/Spaces/PageAndEmailMessage");
const SpacePlanInterview = () => import("@/components/Spaces/SpacePlanInterview");
const RentalPlanInterval = () => import("@/components/Spaces/RentalPlanInterval");
const SpaceApproval = () => import("@/components/Spaces/SpaceApproval");
const TourManagement = () => import("@/components/TourManagement");
const TourSetting = () => import("@/components/TourManagement/TourSetting");
const TourGuide = () => import("@/components/TourManagement/TourGuide");
const TourList = () => import("@/components/TourManagement/TourList");
const LayoutAdmin = () => import("@/components/Layouts/LayoutAdmin.vue");
const LayoutCustomer = () => import("@/components/Layouts/LayoutCustomer.vue");
const ReservationsManage = () => import("@/views/ReservationsManage");
const SpaceTour = () => import("@/components/SpaceTour");
const EditTransport = () => import("@/views/EditOrder/EditTransport");
const SpacePlanAdd = () => import("@/components/Spaces/ReservationSystem/SpacePlanAdd");
const SpaceConfigOverride = () => import("@/components/Spaces/ReservationSystem/SpaceConfigOverride");
const BookingSystemAdvancedSetting = () => import("@/components/Spaces/ReservationSystem/BookingSystemAdvancedSetting");
const SystemReservationOption = () => import("@/components/Spaces/ReservationSystem/SystemReservationOption");
const SystemGroupManage = () => import("@/components/Spaces/ReservationSystem/SystemGroupManage");
const SystemGroupAdd = () => import("@/components/Spaces/ReservationSystem/SystemGroupAdd");
const SystemGroupDetail = () => import("@/components/Spaces/ReservationSystem/SystemGroupDetail");
const RentalPlanPageManage = () => import("@/views/EditOrder/RentalPlanPageManage");
const RentalPlanMessageManage = () => import("@/views/EditOrder/RentalPlanMessageManage");
const EditPanoramaImage = () => import("@/views/EditOrder/EditPanoramaImage");
const EditFacadeImage = () => import("@/views/EditOrder/EditFacadeImage");
const EditDirectionsStationImage = () => import("@/views/EditOrder/EditDirectionsStationImage");
const EditFloorPlan = () => import("@/views/EditOrder/EditFloorPlan");
const CustomerView = () => import("@/views/CustomerView");
const AddTrackLink = () => import("@/views/AddTrackLink");
const TourDetail = () => import("@/components/TourDetail");
const SpacePlanEdit = () => import("@/views/EditOrder/SpacePlanEdit");
const RentalPlanManageDetail = () => import("@/views/EditOrder/RentalPlanManageDetail");
const MenuSettings = () => import("@/components/MenuSettings");
const ExternalReservation = () => import("@/views/ExternalReservation");
const DashBoard = () => import("@/components/DashBoard");
const FormMenu = () => import("@/components/FormMenu");
const StaticPage = () => import("@/views/StaticPage");
const StaticPageViewAdd = () => import("@/views/StaticPageViewAdd");
const SettingEmailTemplate = () => import("@/views/Setting/SettingEmailTemplate");
const Compilation = () => import("@/views/Setting/Compilation");
const CompilationDetail = () => import("@/views/Setting/CompilationDetail");
const SettingEmailTemplateAdd = () => import("@/views/Setting/SettingEmailTemplateAdd");
const SettingEmailTemplateEdit = () => import("@/views/Setting/SettingEmailTemplateEdit");
const ManagerSettingHoliday = () => import("@/views/ManagerSettingHoliday");
const HolidayImport = () => import("@/views/HolidayImport");
const FormSettingNews = () => import("@/views/Setting/FormSettingNews");
const NewsAdd = () => import("@/views/Setting/NewsAdd");
const ManagerSettingCoupon = () => import("@/views/ManagerSettingCoupon");
const ManagerCouponDetail = () => import("@/views/ManagerCouponDetail");
const TrackingLinks = () => import("@/views/Setting/TrackingLinks");
const TrackingLinksAdd = () => import("@/views/Setting/TrackingLinksAdd");
const TrackingLinksEdit = () => import("@/views/Setting/TrackingLinksEdit");
const FooterLink = () => import("@/views/Setting/FooterLink");
const FooterLinkAdd = () => import("@/views/Setting/FooterLinkDetail");
const FooterCategoryAdd = () => import("@/views/Setting/FooterCategoryAdd");
const CsvExport = () => import("@/views/Setting/CsvExport");
const ManageReservations = () => import("@/views/Setting/CsvExport/child/index");
const PurposeUse = () => import("@/views/Setting/PurposeUse");
const PurposeUseDetail = () => import("@/views/Setting/PurposeDetail");
const SpaceEquipmentInformation = () => import("@/views/Setting/SpaceEquipmentInformation");
const SpaceEquipmentInformationAdd = () => import("@/views/Setting/SpaceEquipmentInformationAdd");
const SpaceEquipmentInformationEdit = () => import("@/views/Setting/SpaceEquipmentInformationEdit");
const LargeArea = () => import("@/views/Setting/LargeArea");
const LargeAreaDetail = () => import("@/views/Setting/LargeAreaDetail");
const MediumSmallArea = () => import("@/views/Setting/MediumSmallArea");
const MediumSmallAreaAdd = () => import("@/views/Setting/MediumSmallAreaAdd");
const MediumSmallLowLevel = () => import("@/views/Setting/MediumSmallLowLevel");
const MediumLowLevelManager = () => import("@/views/Setting/MediumLowLevelManager");
const ReservationsConfirmation = () => import("@/views/Reservation/ReservationsConfirmation");
const ReservationsReserved = () => import("@/views/Reservation/ReservationsReserved");
const ListTour = () => import("@/components/TourManagement/Tour/index");
const ApprovalConfirmTour = () => import("@/components/TourManagement/ApprovalTour");
const AlternativeCalender = () => import("@/components/TourManagement/AlternativeCalender");
const GoogleCalendar = () => import("@/components/GoogleCalendar");
const GoogleCollaboration = () => import("@/components/GoogleCollaboration");
export default [
    // ROUTER_ADMIN
    {
        path: ROUTER_PATH.LOGIN, // /admin/login
        component: Login,
        meta: {
            middleware: [(context) => guest(context, TYPE_USER.ADMIN)],
        },
    },
    // ROUTER_ADMIN

    {
        path: ROUTER_PATH.ADMIN, // /admin
        component: LayoutAdmin,
        meta: {
            middleware: [(context) => auth(context, TYPE_USER.ADMIN)],
        },
        children: [
            {
                path: ROUTER_PATH.EMPTY,
                redirectTo: ROUTER_PATH.DASHBOARD,
                component: Home,
            },
            {
                path: ROUTER_PATH.RECOVERY_REQUEST,
                component: RecoveryRequest,
                meta: {
                    middleware: [(context) => guest(context, TYPE_USER.ADMIN)],
                },
            },
            {
                path: ROUTER_PATH.RECOVERY_REQUEST_SUCCESS,
                component: RecoveryRequestPassWordSuccess,
                meta: {
                    middleware: [(context) => guest(context, TYPE_USER.ADMIN)],
                },
            },
            {
                path: ROUTER_PATH.USER_MANAGER,
                component: UserManage,
                children: [
                    {
                        path: ROUTER_PATH.EMPTY,
                        component: ListUserManage,
                    },
                    {
                        path: ROUTER_PATH.ADD,
                        component: AddUserManage,
                    },
                    {
                        path: ROUTER_PATH.EDIT_ID,
                        component: EditUserManage,
                        name: ROUTE_NAME.ADMIN.ADMIN_EDIT_MANAGER
                    },
                    {
                        path: "update-info",
                        component: EditUserManage,
                        name: ROUTE_NAME.ADMIN.ADMIN_UPDATE_INFO
                    },
                ],
            },
            {
                path: ROUTER_PATH.ORDER,
                component: Order,
                children: [
                    {
                        path: ROUTER_PATH.EMPTY,
                        component: ListOrder,
                    },
                    {
                        path: ROUTER_PATH.ADD,
                        component: AddOrder,
                        children: [
                            {
                                path: ROUTER_PATH.SPACE.GENERAL,
                                component: SpacesGeneral,
                                name: ROUTER_PATH.SPACE.GENERAL,
                            },
                            {
                                path: ROUTER_PATH.SPACE.IMAGES,
                                component: SpacesImage,
                                name: ROUTER_PATH.SPACE.IMAGES,
                            },
                            {
                                path: ROUTER_PATH.SPACE.EQUIPMENT_INFORMATION,
                                component: EquipmentInformation,
                                name: ROUTER_PATH.SPACE.EQUIPMENT_INFORMATION,
                            },
                            {
                                path: ROUTER_PATH.SPACE.BOOKING_SYSTEM,
                                component: BookingSystem,
                                name: ROUTER_PATH.SPACE.BOOKING_SYSTEM,
                            },
                            {
                                path: ROUTER_PATH.SPACE.RESERVATION_OPTIONS,
                                component: ReservationOptions,
                                name: ROUTER_PATH.SPACE.RESERVATION_OPTIONS,
                            },
                            {
                                path: ROUTER_PATH.SPACE.RENTAL_PLAN,
                                component: SpacePlanAddDraft,
                                name: ROUTER_PATH.SPACE.RENTAL_PLAN,
                            },
                            {
                                path: ROUTER_PATH.SPACE.LIST_PLAN_INTERVAL,
                                component: RentalPlanInterval,
                                name: ROUTER_PATH.SPACE.LIST_PLAN_INTERVAL,
                            },
                            {
                                path: ROUTER_PATH.SPACE.EMAIL_MESSAGE,
                                component: PageAndEmailMessage,
                                name: ROUTER_PATH.SPACE.EMAIL_MESSAGE,
                            },
                            {
                                path: ROUTER_PATH.SPACE.APPROVAL,
                                component: SpaceApproval,
                                name: ROUTER_PATH.SPACE.APPROVAL,
                            },
                            {
                                path: ROUTER_PATH.SPACE.ADD_PLAN_INTERVAL,
                                component: SpacePlanInterview,
                                name: ROUTER_PATH.SPACE.ADD_PLAN_INTERVAL,
                                props: { typeScreen: TYPE_SCREEN.SPACE_ADDING },
                            },
                        ],
                    },
                    {
                        path: ROUTER_PATH.SPACE.TRACKING_LINK_ID,
                        component: AddOrder,
                        children: [
                            {
                                path: ROUTER_PATH.EMPTY,
                                component: BookingSystemAdvancedSetting,
                                props: { isAdding: true },
                            },
                        ],
                    },
                    {
                        path: `${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.PLAN_EDIT_ID}`,
                        component: SpacePlanEdit,
                    },
                    {
                        path: ROUTER_PATH.EDIT,
                        component: AddOrder,
                        children: [
                            {
                                path: ROUTER_PATH.SPACE.ADD_PLAN_INTERVAL,
                                component: SpacePlanInterview,
                                props: { isUpdateInterval: true, typeScreen: TYPE_SCREEN.SPACE_ADDING },
                            },
                        ],
                    },
                    {
                        path: ROUTER_PATH.SPACE.ADD_TRACKING_LINK_ID,
                        component: AddOrder,
                        children: [
                            {
                                path: ROUTER_PATH.EMPTY,
                                component: AddTrackLink,
                                props: { isAdding: true },
                            },
                        ],
                    },
                    {
                        path: ROUTER_PATH.EDIT,
                        component: EditOrder,
                        children: [
                            {
                                path: ROUTER_PATH.EMPTY_ID,
                                component: EditSpacesGeneral,
                                name: "edit-published-space",
                            },
                            {
                                path: ROUTER_PATH.SPACE.IMAGES_ID,
                                component: EditSpacesImage,
                            },
                            {
                                path: ROUTER_PATH.SPACE.EQUIPMENT_INFORMATION_ID,
                                component: EditSpacesEquipmentInfo,
                            },
                            {
                                path: ROUTER_PATH.SPACE.TRANSPORTATION_FACILITIES_ID,
                                component: EditTransport,
                            },
                            {
                                path: ROUTER_PATH.SPACE.PANORAMA_IMAGES_ID,
                                component: EditPanoramaImage,
                            },
                            {
                                path: ROUTER_PATH.SPACE.FACADE_IMAGES_ID,
                                component: EditFacadeImage,
                            },
                            {
                                path: ROUTER_PATH.SPACE.DIRECTIONS_STATION_IMAGES_ID,
                                component: EditDirectionsStationImage,
                            },
                            {
                                path: ROUTER_PATH.SPACE.FLOOR_PLAN_ID,
                                component: EditFloorPlan,
                            },
                        ],
                    },
                    {
                        path: ROUTER_PATH.RENTAL_PLAN,
                        component: EditOrder,
                        children: [
                            {
                                path: ROUTER_PATH.SPACE.RESERVATION_SYSTEM_ID,
                                component: SpaceReservationSystem,
                            },
                            {
                                path: ROUTER_PATH.SPACE.RENTAL_PLAN_EDIT_ROUTER.RENTAL_PLAN_ADD_ID,
                                component: SpacePlanAdd,
                            },
                            {
                                path: ROUTER_PATH.SPACE.RENTAL_INTERVAL_CONFIG_OVERRIDE_ID,
                                component: SpaceConfigOverride,
                            },
                            {
                                path: ROUTER_PATH.SPACE.BOOKING_SYSTEM_ADVANCED_SETTINGS_ID,
                                component: BookingSystemAdvancedSetting,
                                name: "AdminTrackingUrlList",
                            },
                            {
                                path: "booking-system-advanced-settings/:id/edit-link/:linkId",
                                component: () =>
                                    import("@/components/Spaces/ReservationSystem/BookingSystemAdvancedSetting/EditTrackingUrl.vue"),
                                name: "AdminEditTrackingUrl",
                            },
                            {
                                path: ROUTER_PATH.SPACE.RESERVATION_SYSTEM_RESERVATION_OPTIONS_ID,
                                component: SystemReservationOption,
                            },
                            {
                                path: ROUTER_PATH.SPACE.DETAIL_ADD_TRACKING_LINK_ID,
                                component: AddTrackLink,
                            },
                            {
                                path: ROUTER_PATH.SPACE.PLAN_EDIT_ID,
                                component: SpacePlanEdit,
                            },
                            {
                                path: ROUTER_PATH.SPACE.GROUP_MANAGE_ID,
                                component: SystemGroupManage,
                            },
                            {
                                path: ROUTER_PATH.SPACE.GROUP_ADD_ID,
                                component: SystemGroupAdd,
                            },
                            {
                                path: ROUTER_PATH.SPACE.PAGE_MANAGE_ID,
                                component: RentalPlanPageManage,
                            },
                            {
                                path: ROUTER_PATH.SPACE.MESSAGE_MANAGE_ID,
                                component: RentalPlanMessageManage,
                            },
                            {
                                path: ROUTER_PATH.SPACE.RENTAL_PLAN_DETAIL_MESSAGE_ID,
                                component: RentalPlanManageDetail,
                                props: { isMessageManage: true },
                            },
                            {
                                path: ROUTER_PATH.SPACE.RENTAL_PLAN_DETAIL_PAGE_ID,
                                component: RentalPlanManageDetail,
                                props: { isPageManage: true },
                            },
                            {
                                path: ROUTER_PATH.SPACE.ADD_PLAN_INTERVAL,
                                component: SpacePlanInterview,
                                props: { typeScreen: TYPE_SCREEN.SPACE_EDITING },
                            },
                            {
                                path: ROUTER_PATH.SPACE.EDIT_PLAN_INTERVAL,
                                component: SpacePlanInterview,
                                props: { isUpdateInterval: true, typeScreen: TYPE_SCREEN.SPACE_EDITING },
                            },
                        ],
                    },
                    {
                        path: ROUTER_PATH.RENTAL_PLAN_ID,
                        component: EditOrder,
                        children: [
                            {
                                path: ROUTER_PATH.SPACE.GROUP_EDIT_ID,
                                component: SystemGroupDetail,
                            },
                        ],
                    },
                ],
            },
            {
                path: ROUTER_PATH.CONFIGURATION,
                component: MenuSettings,
                children: [
                    {
                        path: ROUTER_PATH.SYSTEM_CONFIG,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.NEWS,
                        component: FormSettingNews,
                        name: ROUTE_NAME.ADMIN.NEWS,
                    },
                    {
                        path: ROUTER_PATH.NEWS_ADD,
                        component: NewsAdd,
                        name: ROUTE_NAME.ADMIN.NEWS_ADD,
                    },
                    {
                        path: ROUTER_PATH.CUSTOMER_NEWS,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.FAQ,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.STATIC_PAGE,
                        component: StaticPage,
                        name: ROUTE_NAME.ADMIN.STATIC_PAGE,
                    },
                    {
                        path: ROUTER_PATH.HTML_PAGE,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_COMPILATION,
                        component: Compilation,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_COMPILATION,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_COMPILATION_ADD,
                        component: CompilationDetail,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_COMPILATION_ADD,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_COMPILATION_EDIT,
                        component: CompilationDetail,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_COMPILATION_EDIT,
                        props: { isUpdate: true },
                    },
                    {
                        path: ROUTER_PATH.SLIDE,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.META,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_USE_PURPOSE,
                        component: PurposeUse,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_USE_PURPOSE,
                    },
                    {
                        path: ROUTER_PATH.PURPOSE_OF_USE_DETAIL,
                        component: PurposeUseDetail,
                        name: ROUTE_NAME.ADMIN.PURPOSE_OF_USE_DETAIL,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_EQUIPMENT_INFORMATION,
                        component: SpaceEquipmentInformation,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_EQUIPMENT_INFORMATION,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_EQUIPMENT_INFORMATION_ADD,
                        component: SpaceEquipmentInformationAdd,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_EQUIPMENT_INFORMATION_ADD,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_EQUIPMENT_INFORMATION_EDIT,
                        component: SpaceEquipmentInformationEdit,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_EQUIPMENT_INFORMATION_EDIT,
                    },
                    {
                        path: ROUTER_PATH.AREA,
                        component: LargeArea,
                        name: ROUTE_NAME.ADMIN.AREA,
                    },
                    {
                        path: ROUTER_PATH.LARGE_AREA_DETAIL,
                        component: LargeAreaDetail,
                        name: ROUTE_NAME.ADMIN.AREA_EDIT,
                    },
                    {
                        path: ROUTER_PATH.AREA_GROUP,
                        component: MediumSmallArea,
                        name: ROUTE_NAME.ADMIN.AREA_GROUP,
                    },
                    {
                        path: ROUTER_PATH.AREA_GROUP_ADD,
                        component: MediumSmallAreaAdd,
                        name: ROUTE_NAME.ADMIN.AREA_GROUP_ADD,

                        props: {
                            isDelete: false,
                        },
                    },
                    {
                        path: ROUTER_PATH.AREA_GROUP_EDIT,
                        component: MediumSmallAreaAdd,
                        name: ROUTE_NAME.ADMIN.AREA_GROUP_EDIT,
                    },
                    {
                        path: ROUTER_PATH.AREA_GROUP_LOW_LEVEL,
                        component: MediumSmallLowLevel,
                        name: ROUTE_NAME.ADMIN.AREA_GROUP_LOW_LEVEL,
                    },
                    {
                        path: ROUTER_PATH.AREA_GROUP_LOW_LEVEL_EDIT,
                        component: MediumSmallLowLevel,
                        name: ROUTE_NAME.ADMIN.AREA_GROUP_LOW_LEVEL_EDIT,
                    },

                    {
                        path: ROUTER_PATH.AREA_LOW_LEVER_MANAGE,
                        component: MediumLowLevelManager,
                        name: ROUTE_NAME.ADMIN.AREA_LOW_LEVER_MANAGE,
                    },
                    {
                        path: ROUTER_PATH.EMAIL_TEMPLATE,
                        component: SettingEmailTemplate,
                        name: ROUTE_NAME.ADMIN.EMAIL_TEMPLATE,
                    },
                    {
                        path: ROUTER_PATH.EMAIL_TEMPLATE_ADD,
                        component: SettingEmailTemplateAdd,
                        name: ROUTE_NAME.ADMIN.EMAIL_TEMPLATE_ADD,
                    },
                    {
                        path: ROUTER_PATH.EMAIL_TEMPLATE_EDIT,
                        component: SettingEmailTemplateEdit,
                        name: ROUTE_NAME.ADMIN.EMAIL_TEMPLATE_EDIT,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_POINTS,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.DOCUMENTATION,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.FOOTER_LINKS,
                        name: "footer-link",
                        component: FooterLink,
                        name: ROUTE_NAME.ADMIN.FOOTER_LINKS,
                    },
                    {
                        path: ROUTER_PATH.FOOTER_LINKS_ADD,
                        component: FooterLinkAdd,
                        name: ROUTE_NAME.ADMIN.FOOTER_LINKS_ADD,
                    },
                    {
                        path: ROUTER_PATH.FOOD_CATEGORY_ADD,
                        component: FooterCategoryAdd,
                        name: ROUTE_NAME.ADMIN.FOOD_CATEGORY_ADD,
                    },
                    {
                        path: ROUTER_PATH.HOLIDAY_INFO,
                        component: ManagerSettingHoliday,
                        name: ROUTE_NAME.ADMIN.HOLIDAY_INFO,
                    },
                    {
                        path: ROUTER_PATH.PAYOUT,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.RENTAL_SPACE_COUPONS,
                        component: ManagerSettingCoupon,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_COUPONS,
                    },
                    {
                        path: ROUTER_PATH.CAMPAIGN,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.TRACKING_LINKS,
                        component: TrackingLinks,
                        name: ROUTE_NAME.ADMIN.TRACKING_LINKS,
                    },
                    {
                        path: ROUTER_PATH.TRACKING_LINKS_ADD,
                        component: TrackingLinksAdd,
                        name: ROUTE_NAME.ADMIN.TRACKING_LINKS_ADD,
                    },
                    {
                        path: ROUTER_PATH.TRACKING_LINKS_EDIT,
                        component: TrackingLinksEdit,
                        name: ROUTE_NAME.ADMIN.TRACKING_LINKS_EDIT,
                    },
                    {
                        path: ROUTER_PATH.XML_EXPORT,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.CSV_EXPORT,
                        component: CsvExport,
                        name: ROUTE_NAME.ADMIN.CSV_EXPORT,
                    },
                    {
                        path: ROUTER_PATH.CSV_MANAGE_RESERVATIONS,
                        component: ManageReservations,
                        name: ROUTE_NAME.ADMIN.CSV_MANAGE_RESERVATIONS,
                    },
                    {
                        path: ROUTER_PATH.FIRST_CONTRACTOR,
                        component: FormSetting,
                    },
                    {
                        path: ROUTER_PATH.STATIC_PAGE_ADD,
                        component: StaticPageViewAdd,
                        name: ROUTE_NAME.ADMIN.STATIC_PAGE_ADD,
                    },
                    {
                        path: ROUTER_PATH.HOLIDAY_IMPORT,
                        component: HolidayImport,
                        name: ROUTE_NAME.ADMIN.HOLIDAY_IMPORT,
                    },
                    {
                        path: ROUTER_PATH.MANAGE_COUPON_DETAIL,
                        component: ManagerCouponDetail,
                        name: ROUTE_NAME.ADMIN.RENTAL_SPACE_COUPONS_EDIT,
                    },
                ],
            },
            {
                path: ROUTER_PATH.ORGANIZATION,
                component: MenuSettings,
                children: [
                    {
                        path: ROUTER_PATH.REQUEST_MANAGEMENT,
                        component: FormSetting,
                    },
                ],
            },
            {
                path: ROUTER_PATH.LIST_CUSTOMER,
                component: ListCustomer,
            },
            {
                path: ROUTER_PATH.TOUR,
                component: TourManagement,
                children: [
                    {
                        path: ROUTER_PATH.TOUR_LIST,
                        component: TourList,
                        name: ROUTE_NAME.ADMIN.TOUR_LIST,
                    },
                    {
                        path: ROUTER_PATH.TOUR_SETTING,
                        component: TourSetting,
                        name: ROUTE_NAME.ADMIN.TOUR_SETTING,
                    },
                    {
                        path: ROUTER_PATH.TOUR_GUIDE,
                        component: TourGuide,
                        name: ROUTE_NAME.ADMIN.TOUR_GUIDE,
                    },
                    {
                        path: ROUTER_PATH.APPROVAL_CONFIRM_TOUR,
                        component: ApprovalConfirmTour,
                        name: ROUTE_NAME.ADMIN.TOUR_CONFIRM,
                    },
                    {
                        path: ROUTER_PATH.NON_APPROVAL_CONFIRM_TOUR,
                        component: AlternativeCalender,
                    },
                ],
            },
            {
                path: ROUTER_PATH.TOUR_MANAGER.TOUR_DETAIL,
                component: TourDetail,
                name: "TourDetail",
            },
            {
                path: ROUTER_PATH.GOOGLE_CALENDAR,
                component: GoogleCalendar,
                name: "GoogleCalendar",
            },
            {
                path: ROUTER_PATH.GOOGLE_COLLABORATION,
                component: GoogleCollaboration,
                name: "GoogleCollaboration",
            },
            {
                path: ROUTER_PATH.INQUIRIES,
                component: Inquiries,
            },
            {
                path: ROUTER_PATH.INQUIRIES_DETAIL,
                component: InquiriesDetail,
            },
            {
                path: ROUTER_PATH.CUSTOMER_VIEW_ID,
                component: CustomerView,
            },

            {
                path: ROUTER_PATH.RESERVATIONS,
                component: DashBoard,
                children: [
                    {
                        path: ROUTER_PATH.DASHBOARD,
                        component: FormMenu,
                    },
                    {
                        path: ROUTER_PATH.RESERVATIONS_MANAGE,
                        component: ReservationsManage,
                    },
                    {
                        path: ROUTER_PATH.RESERVATIONS_CONFIRMATION,
                        component: ReservationsConfirmation,
                        name: ROUTER_PATH.RESERVATIONS_CONFIRMATION,
                    },
                ],
            },
            {
                path: ROUTER_PATH.EXTERNAL_RESERVATION,
                component: ExternalReservation,
            },
            {
                path: ROUTER_PATH.RESERVATION_REGISTER_RESERVED,
                component: ReservationsReserved,
            },
        ],
    },
    {
        path: ROUTER_PATH.ADMIN, // /admin
        component: LayoutCustomer,
        meta: {
            middleware: [(context) => auth(context, TYPE_USER.ADMIN)],
        },
        children: [
            {
                path: ROUTER_PATH.RESERVATION_CALENDAR,
                component: ReservationCalendar,
            },
            {
                path: ROUTER_PATH.RESERVATION_REGISTER,
                component: ReservationRegister,
            },
        ],
    },
];
