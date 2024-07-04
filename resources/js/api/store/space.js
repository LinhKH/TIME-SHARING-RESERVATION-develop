import api from "../http-request";
import apiConstants from "../apiConstant";

// [GET] method
export const getListAllSpaces = async (page) => api.get(`${apiConstants.GET_LIST_ALL_SPACES}?page=${page}`);
export const getDetailSpaceGeneral = async (id) => api.get(`${apiConstants.DETAIL_SPACE}/${id}/general`);
export const getDetailSpaceImages = async (id) => api.get(`${apiConstants.DETAIL_SPACE}/${id}/images`);
export const getDetailSpaceBookingSystem = async (id) => api.get(`${apiConstants.DETAIL_SPACE}/${id}/booking-system`);
export const getDetailSpaceRentalPlan = async (idSpace, idPlan) => api.get(`/admin/rental-spaces/detail/${idSpace}/rental-plan/plan/${idPlan}`);
export const getDetailSpaceReservation = async (id) => api.get(`${apiConstants.DETAIL_SPACE}/${id}/reservation-option-type`);
export const getDetailSpaceEquipmentInfo = async (id) => api.get(`${apiConstants.DETAIL_SPACE}/${id}/equipment-information`);
export const getCurrentStep = async (id) => api.get(`/admin/rental-spaces/${id}/current-draft-step`);
export const getListPlan = async (id) => api.get(`/admin/rental-spaces/${id}/list/rental-plan`);
export const getDetailSpaceEmailMessage = async (id) => api.get(`/admin/rental-spaces/detail/${id}/email-message`);
export const getDetailSpacePage = async (id) => api.get(`/admin/rental-spaces/detail/${id}/page`);
export const getDetailSpaceReservationSystem = async (id) => api.get(`${apiConstants.DETAIL_SPACE}/${id}/rental-plan/interval`);
export const getRentalPlanPageManage = async (id) => api.get(`/admin/rental-spaces/page/${id}/manage`);
export const getRentalPlanMessageManage = async (id) => api.get(`/admin/rental-spaces/email-message/${id}/manage`);
export const getDetailTrackLink = async (idSpace) => api.get(`/admin/rental-spaces/detail/${idSpace}/tracking-links`);
export const getDetailBookingSystemAdvanced = async (id) => api.get(`/admin/rental-spaces/detail/${id}/booking-system/advanced`);
export const getListGroup = async (id) => api.get(`/admin/rental-spaces/${id}/list/rental-plan/group`);
export const getDetailGroup = async (idGroup) => api.get(`/admin/rental-spaces/rental-plan/group/${idGroup}`);
export const getDetainIntervalOfPlan = async (idSpace, idPlan) => api.get(`/admin/rental-spaces/${idSpace}/rental-plan/${idPlan}/interval/detail`);
export const getDetailSpaceImagesPanorama = async (id) => api.get(`/admin/rental-spaces/detail/${id}/panorama-images`);
export const getDetailSpaceImagesFloorPlan = async (id) => api.get(`/admin/rental-spaces/detail/${id}/floor-plan`);
export const getDetailSpaceImagesFacade = async (id) => api.get(`/admin/rental-spaces/detail/${id}/facade-images`);
export const getDetailSpaceImagesDirectionsStation = async (id) => api.get(`/admin/rental-spaces/detail/${id}/directions-station-images`);
export const getIntervalInThisDay = async (idSpace, idPlan, params) => api.get(`/admin/rental-spaces/${idSpace}/rental-plan/${idPlan}/interval-in-this-day/detail`, { params });
export const getDetailInterval = async (idInterval) => api.get(`/admin/rental-spaces/rental-plan/interval/${idInterval}/detail`);
export const getDetailPageAndMessage = async (idPageAndMessage, type) => api.get(`/admin/rental-spaces/page-and-email-message/${idPageAndMessage}/view?type=${type}`);
export const getIntervalOverride = async (idSpace, idPlan, params) => api.get(`/admin/rental-spaces/${idSpace}/rental-plan/${idPlan}/interval-override-in-this-day/detail`, { params });
export const getRentalSlotUnavailableCacheEntryInThisDay = async (idSpace, idPlan, params) => api.get(
    `/admin/rental-spaces/${idSpace}/rental-plan/${idPlan}/rental-slot-unavailable-cache-entry-in-this-day/detail`,
    { params }
);
export const getSuggestTransport = async (params) => api.get(`/admin/transportations/suggest/transport`, { params });
export const getAllTransportation = async (idSpace) => api.get(`/admin/rental-spaces/${idSpace}/transport/list`);
export const getCouponCustomerFilterApi = async (params) => api.get(`/admin/manager-setting/coupon/filter`, { params });
export const getStatusSpace = async (idSpace) => api.get(`/admin/rental-spaces/detail/${idSpace}/approval`);
export const getPublicSpacePreview = async (idSpace) => api.get(`/rental-spaces/detail/${idSpace}/manage`);
export const getListPublicSpacePreview = async (params) => api.get(`/rental-spaces/list-by-condition${params}`);
export const getListLocation = async () => api.get(`/admin/location/list`);
export const checkUsedSpace = async (id) => api.get(`admin/rental-spaces/check_use/${id}`);

//[POST] method
export const postSpaceImages = async (data, id) => api.post(`${apiConstants.CREATE_SPACE}/${id}/images`, data);
export const postSpaceEquipment = async (data, id) => api.post(`${apiConstants.CREATE_SPACE}/${id}/equipment-information`, data);
export const postSpaceBookingSystem = async (data, id) => api.post(`${apiConstants.CREATE_SPACE}/${id}/booking-system`, data);
export const postSpaceReservationOption = async (data, id) => api.post(`${apiConstants.CREATE_SPACE}/${id}/reservation-option-type`, data);
export const postSpacePageAndEmailMessage = async (data, id) => api.post(`${apiConstants.CREATE_SPACE}/${id}/page-and-email-message`, data);
export const postSpaceRentalPlan = async (data, id) => api.post(`${apiConstants.CREATE_SPACE}/${id}/rental-plan/plan`, data);
export const postSpaceRentalPlanInterval = async (data, idSpace, idPlan) => api.post(`${apiConstants.CREATE_SPACE}/space/${idSpace}/rental-plan/${idPlan}/interval`, data);
export const postBookingSystemAdvanced = async (id, data) => api.post(`/admin/rental-spaces/create/${id}/booking-system/advanced`, data);
export const postSpaceGeneral = async (data) => api.post(apiConstants.CREATE_SPACE_GENERAL, data);
export const postTrackingLink = async (id, data) => api.post(`/admin/rental-spaces/create/${id}/tracking-links`, data);
export const createGroup = async (id, data) => api.post(`/admin/rental-spaces/create/${id}/rental-plan/group`, data);
export const postReservationRegisterFromApi = async (id, data) => api.post(`/admin/reservations/rental-space/${id}/booking/plan-less`, data);
export const updateAndCreateTransportation = async (idSpace, data) => api.post(`/admin/rental-spaces/${idSpace}/near-by-transportation`, data);

//[PUT] method
export const changeStatusPublic = async (data, id) => api.put(`${apiConstants.CHANGE_STATUS_PUBLIC}/${id}/approval`, data);
export const updateInterval = async (data) => api.put(`/admin/rental-spaces/update/rental-plan/interval`, data);
export const updatePlanOfSpace = async (id, data) => api.put(`/admin/rental-spaces/update/rental-plan/${id}/plan`, data);
export const updateIntervalOverride = async (idSpace, idPlan, data) => api.put(
    `/admin/rental-spaces/${idSpace}/rental-plan/${idPlan}/rental-interval-config-override/post-rental-slots/update`,
    data
);
export const updateSpaceImage = async (idSpace, data) => api.put(`/admin/rental-spaces/${idSpace}/update-title-image`, data);
export const updateSpaceEmailMessage = async (id, data) => api.put(`/admin/rental-spaces/update/${id}/email-message`, data);
export const updateSpacePage = async (id, data) => api.put(`/admin/rental-spaces/update/${id}/page`, data);
export const updateRentalPlanGroup = async (id, data) => api.put(`/admin/rental-spaces/update/rental-plan/group/${id}`, data);
export const updateSpaceGeneral = async (id, data) => api.put(`/admin/rental-spaces/update/${id}/general`, data);
export const updateStatusSpace = async (id, data) => api.put(`/admin/rental-spaces/${id}/approval`, data);
export const updatStatusReservation = async (id, data) => api.put(`admin/reservations/update-status/${id}`, data);

//[DELETE] method
export const deleteOverrideInterval = async (data) => api.delete(`/admin/rental-spaces/rental-interval/rental-interval-override/delete`, { data });
export const deleteTransportation = async (idSpace, idNear) => api.delete(`/admin/rental-spaces/${idSpace}/transport/${idNear}`);
export const deleteInterval = async (idSpace, idPlan, idInterval) => api.delete(`/admin/rental-spaces/${idSpace}/rental-plan/${idPlan}/interval/${idInterval}/delete`);
export const deleteImageSpace = async (id, type) => api.delete(`/admin/rental-spaces/delete/${id}/${type}`);
