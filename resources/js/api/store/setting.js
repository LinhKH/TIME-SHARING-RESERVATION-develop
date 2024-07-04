import api from "../http-request";
import apiConstants from "../apiConstant";

//[GET] method
export const getFormSettingFromApi = async () => api.get(`${apiConstants.SETTING}`);
export const getListSettingNewApi = async (page) => api.get(`${apiConstants.GET_SETTING_NEW}?page=${page}`);
export const getDetailSettingNewApi = async (id) => api.get(`${apiConstants.GET_DETAIL_SETTING_NEW}/${id}`);
export const getListCouponApi = async () => api.get(`${apiConstants.GET_SETTING_COUPON}`);
export const getDetailCouponApi = async (id) => api.get(`${apiConstants.GET_DETAIL_SETTING_COUPON}/${id}`);
export const getListPageNewApi = async (page) => api.get(`${apiConstants.GET_PAGE_NEW}?page=${page}`);
export const getDetailPageNewApi = async (id) => api.get(`${apiConstants.GET_DETAIL_PAGE_NEW}/${id}`);
export const getListGlobalLinksApi = async (page) => api.get(`${apiConstants.GET_GLOBAL_LINKS}?page=${page}`);
export const getDetailGlobalLinksApi = async (id) => api.get(`${apiConstants.GET_DETAIL_GLOBAL_LINKS}/${id}`);
export const getListCategoryFooterApi = async (page) => api.get(`${apiConstants.GET_CATEGORY_FOOTER}?page=${page}`);
export const getDetailCategoryFooterApi = async (id) => api.get(`${apiConstants.GET_DETAIL_CATEGORY_FOOTER}/${id}`);
export const getListFooterLinkByCategoryApi = async (id) =>
    api.get(`${apiConstants.GET_FOOTER_LINK_BY_CATEGORY}/${id}`);
export const getDetailFooterLinksApi = async (id) => api.get(`${apiConstants.GET_DETAIL_FOOTER_LINKS}/${id}`);
export const getListPurposeOfUseByCategory = async (categoryId, page) =>
    api.get(`/admin/manager-setting/purpose-use/list-by-category/${categoryId}?page=${page}`);
export const getListEquipment = async () => api.get(`/admin/manager-setting/equipment-information/list`);
export const getDetailPurposeOfUse = async (id) => api.get(`/admin/manager-setting/purpose-use/detail/${id}`);
export const getListSummary = async (page) =>
    api.get(`/admin/configuration/rental-space-compilation/manage?page=${page}`);
export const getDetailSummary = async (id) => api.get(`/admin/configuration/rental-space-compilation/${id}/detail`);
export const getListHoliday = async () => api.get(`/admin/manager-setting/holiday/list_holiday`);
export const getListImagePurpose = async (id) => api.get(`/admin/manager-setting/purpose-use/img/list/${id}`);
export const getListEquipInformationByCategoryApi = async (id) =>
    api.get(`${apiConstants.GET_EQUIPMENT_INFORMATION_BY_CATEGORY}/${id}`);
export const getDetailEquipmentInformationApi = async (id) =>
    api.get(`${apiConstants.GET_DETAIL_EQUIPMENT_INFORMATION}/${id}`);
export const getAllEmailTemplate = async () => api.get(`/admin/manager-setting/email-template/all`);
export const getDetailEmailTemplate = async (id) => api.get(`/admin/manager-setting/email-template/${id}`);

export const getListLargeArea = async () => api.get(`/admin/manager-setting/large-area/list`);
export const getDetailLargeAreaApi = async (id) => api.get(`/admin/manager-setting/large-area/detail/${id}`);

export const getListSmallAreaApi = async () => api.get(`/admin/manager-setting/small-area/list`);
export const getDetailSmallAreaApi = async (id) => api.get(`/admin/manager-setting/small-area/detail/${id}`);

//[PUT] method
export const updateFormSetting = async (data) => api.put(`${apiConstants.SETTING}`, data);
export const updateSummary = async (id, data) =>
    api.put(`/admin/configuration/rental-space-compilation/${id}/update`, data);
export const updateImageSummary = async (id, data) =>
    api.put(`/admin/configuration/rental-space-compilation/images/${id}/update`, data);
export const updateEmailTemplate = async (id, data) => api.put(`/admin/manager-setting/email-template/${id}`, data);
export const updateSmallAreaApi = async (id, data) => api.put(`/admin/manager-setting/small-area/update/${id}`, data);

// [POST] method
export const addSettingNewApi = async (data) => api.post(apiConstants.CREATE_SETTING_NEW, data);
export const addSettingCouponApi = async (data) => api.post(apiConstants.CREATE_SETTING_COUPON, data);
export const updateSettingNew = async (id, data) => api.post(`${apiConstants.UPDATE_SETTING_NEW}/${id}`, data);
export const updateSettingCouponApi = async (id, data) => api.post(`${apiConstants.UPDATE_SETTING_COUPON}/${id}`, data);
export const addPageNewApi = async (data) => api.post(apiConstants.CREATE_PAGE_NEW, data);
export const updatePageNew = async (id, data) => api.post(`${apiConstants.UPDATE_PAGE_NEW}/${id}`, data);
export const createSettingSummary = async (params) =>
    api.post(`/admin/configuration/rental-space-compilation/add`, params);
export const createGlobalLinksApi = async (data) => api.post(apiConstants.CREATE_GLOBAL_LINKS, data);
export const updateGlobalLinksApi = async (id, data) => api.post(`${apiConstants.UPDATE_GLOBAL_LINKS}/${id}`, data);
export const createCategoryFooterApi = async (data) => api.post(apiConstants.CREATE_CATEGORY_FOOTER, data);
export const updateCategoryFooterApi = async (id, data) =>
    api.post(`${apiConstants.UPDATE_CATEGORY_FOOTER}/${id}`, data);
export const createFooterLinksApi = async (data) => api.post(apiConstants.CREATE_FOOTER_LINKS, data);
export const updateFooterLinksApi = async (id, data) => api.post(`${apiConstants.UPDATE_FOOTER_LINKS}/${id}`, data);
export const createPurposeUse = async (idCategory, data) =>
    api.post(`/admin/manager-setting/purpose-use/create/${idCategory}`, data);
export const importCSVHolidaySetting = async (data) => api.post(`/admin/manager-setting/holiday/import-csv`, data);
export const uploadImageSummary = async (id, data) =>
    api.post(`/admin/configuration/rental-space-compilation/${id}/upload-images`, data);
export const createEquipmentInformationApi = async (id, data) =>
    api.post(`/admin/manager-setting/equipment-information/create/${id}`, data);
export const updateEquipmentInformationApi = async (id, data) =>
    api.post(`${apiConstants.UPDATE_EQUIPMENT_INFORMATION}/${id}`, data);
export const uploadImageEquipment = async (id, data) =>
    api.post(`/admin/manager-setting/equipment-information/upload-img/${id}`, data);
export const updatePurposeOfUse = async (id, data) => api.post(`/admin/manager-setting/purpose-use/update/${id}`, data);
export const uploadImageSettingPurposeOfUse = async (id, data) =>
    api.post(`/admin/manager-setting/purpose-use/img-upload/${id}`, data);
export const createEmailTemplate = async (data) => api.post(`/admin/manager-setting/email-template/create`, data);

export const addLargeAreaApi = async (data) => api.post(`admin/manager-setting/large-area/create`, data);
export const createSmallAreaApi = async (data) => api.post(`/admin/manager-setting/small-area/create`, data);

// [DELETE] method
export const deleteSettingNewApi = async (id) => api.delete(`${apiConstants.DELETE_SETTING_NEW}/${id}`);
export const deletePageNewApi = async (id) => api.delete(`${apiConstants.DELETE_PAGE_NEW}/${id}`);
export const deleteImageSummarySetting = async (idImage) =>
    api.delete(`/admin/configuration/rental-space-compilation/images/${idImage}/delete`);
export const deleteEquipmentInformationApi = async (id) =>
    api.delete(`/admin/manager-setting/equipment-information/delete/${id}`);
export const deleteImageEquipmentSetting = async (id) =>
    api.delete(`/admin/manager-setting/equipment-information/delete/img/${id}`);
export const deleteImagePurpose = async (id) => api.delete(`/admin/manager-setting/purpose-use/img-delete/${id}`);
export const deleteEmailTemplate = async (id) => api.delete(`/admin/manager-setting/email-template/${id}`);
export const deleteSettingCouponApi = async (id) => api.delete(`/admin/manager-setting/coupon/delete/${id}`);

export const deleteLargeAreaApi = async (id) => api.delete(`/admin/manager-setting/large-area/delete/${id}`);
// [PUT] method
export const updateLargeAreaApi = async (id, data) => api.put(`/admin/manager-setting/large-area/update/${id}`, data);

export const deleteSmallAreaApi = async (id) => api.delete(`/admin/manager-setting/small-area/delete/${id}`);
export const deleteCouponApi = async (id) => api.delete(`${apiConstants.DELETE_COUPON}/${id}`)

export const getDetailTrackingUrlApi = async (spaceId, linkId) => api.get(`/admin/rental-spaces/detail/${spaceId}/tracking-links/${linkId}`)
export const updateDetailTrackingUrlApi = async (linkId, name) => api.put(`/admin/rental-spaces/update-name-tracking-links/${linkId}`, { _method: "PUT", name })
