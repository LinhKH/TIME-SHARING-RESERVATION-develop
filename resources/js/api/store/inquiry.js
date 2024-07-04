import api from "../http-request";
import apiConstants from "../apiConstant";
//  GET METHOD
export const getListInquiesApi = async () => api.get(`${apiConstants.GET_LIST_INQUIRIES}`);

export const getDetailInquiriesApi = async (id) => api.get(`${apiConstants.GET_DETAIL_INQUIRIES}/${id}`);
export const getListInquiesReplyApi = async (id) => api.get(`${apiConstants.GET_LIST_INQUIRIES_REPLY}/${id}`);
// POST METHOD
export const createInquiesReplyApi = async (id, data) => api.post(`${apiConstants.CREATE_INQUIRIES_REPLY}/${id}`, data);
export const updateStatusSupportInquiriesApi = async (id, data) =>
  api.post(`${apiConstants.UPDATE_STATUS_SUPPORT_INQUIRIES}/${id}`, data);

export const getCsvInquiries = async () => api.get(`${apiConstants.GET_CSV_INQUIRIES}`);
export const updateIsReadInquiry = async (id, data) => api.post(`admin/inquiry/update/read/${id}`, data);
