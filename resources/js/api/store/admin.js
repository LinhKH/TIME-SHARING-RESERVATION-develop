import api from "../http-request";
import apiConstants from "../apiConstant";

//[POST] method
export const login = async (data) =>
    api.post(apiConstants.AUTH.LOGIN, data, {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });
export const logout = async () => api.post(apiConstants.AUTH.LOGOUT);
export const addUserManager = async (data) => api.post(apiConstants.AUTH.USER_MANAGER_CREATE, data);

//[GET] method
export const getUserManager = async (id) => api.get(`${apiConstants.ADMIN}/${id}`);
export const getListUserManagerFromApi = async (data) => {
    return api.get(`${apiConstants.AUTH.USER_MANAGER}=${data.page}`, { params: data.filter });
};
export const getUserProfileApi = async () => api.get(`/auth/user-profile`);

//[PUT] method
export const updateProfileManager = async (id, data) => api.put(`${apiConstants.ADMIN}/${id}`, data);

export const resetPassWordUser = async (email) => api.put(`${apiConstants.AUTH.RESET_PASSWORD}/${email}`);
