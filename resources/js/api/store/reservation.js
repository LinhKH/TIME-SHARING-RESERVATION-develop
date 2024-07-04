import api from "../http-request";
import apiConstants from "../apiConstant";


//[GET] method
export const getFilterCustomerByEmailApi = async (params) => api.get(`/admin/customer/filter`, { params });
export const getPurposeUseAllApi = async () => api.get(`admin/manager-setting/purpose-use/list`);
export const getOptionReservationType = async () => api.get(`/admin/reservations/get-list-reservation-type`);
export const getOptionPurposeOfUse = async () => api.get(`/admin/reservations/get-list-purpose-of-use`);
export const getOptionStatusReservation = async () => api.get(`/admin/reservations/get-list-status-reservation`);
export const getReservationByCondition = async (params) => api.get(`/admin/reservations/list`, { params });
export const getReservationDetail = async (id) => api.get(`/admin/reservations/detail/${id}`);
export const getListAsCsv = async () => api.get(`/admin/reservations/export-reservation`);

