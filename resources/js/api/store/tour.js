import api from "../http-request";
import apiConstants from "../apiConstant";

//[POST] method
export const postNoneApprovalTour = async (data, id) => api.post(`admin/rental-spaces/tour/update/status/${id}`, data);
export const postApprovalTour = async (data, id) => api.post(`${apiConstants.TOUR_MANAGER}/${id}/confirm`, data);
export const addTourReplyApi = async (data) => api.post(`admin/rental-spaces/tour/add_reply`, data);
//[GET] method
export const getAllListTourApi = async (page) => {
    api.get(`${apiConstants.TOUR_MANAGER}?page=1`)
};
export const getDetailTourApi = async (id) => api.get(`${apiConstants.TOUR_DETAIL}/${id}`);
export const getListTourReplyApi = async (id) => api.get(`${apiConstants.TOUR_LIST_REPLY}/${id}`);
