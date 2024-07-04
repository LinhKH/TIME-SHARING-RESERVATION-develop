import api from "../http-request";
import apiConstants from "../apiConstant";

//[POST] method
export const loginCustomer = async (data) => api.post(apiConstants.LOGIN_CUSTOMER, data);
export const createCustomer = async (data) => api.post(apiConstants.CREATE_CUSTOMER, data);

//[GET] method
export const getListCustomerFromApi = async (data) => {
    return api.get(`${apiConstants.GET_LIST_CUSTOMER}?page=${data.page}`, { params: data.filter });
};
export const getCustomerDetailFromApi = async (id) => api.get(`${apiConstants.GET_CUSTOMER_DETAIL}/${id}`);

//[PUT] method
export const putCustomerStatusFromApi = async (id, data) => api.put(`customer/auth/update-status/${id}`, data);
export const putCustomerReceiveEmailFromApi = async (id, data) =>
    api.put(`customer/auth/update-receive-email/${id}`, data);
