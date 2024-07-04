import axios from "axios";
import { get } from "lodash";
import { STATUS_CODE, TYPE_USER } from "@/const";
import { getToken, removeToken } from "@/utils/authToken";
import i18n from "@/i18n";

const headers = {
    Accept: "application/json",
    "Content-Type": "application/json; charset=utf-8",
};

const axiosInstance = axios.create({
    baseURL: process.env.MIX_API_URL,
    headers,
});

axiosInstance.interceptors.request.use(
    (config) => {
        let params = config.params || {};
        const token = getToken(TYPE_USER.ADMIN) || getToken(TYPE_USER.USER);
        if (token) {
            config.headers["Authorization"] = "Bearer " + token;
        }
        return {
            ...config,
            params: params,
        };
    },
    (error) => {
        return Promise.reject(error);
    }
);

axiosInstance.interceptors.response.use(
    (response) => response.data,
    (error) => {
        const status = get(error, "response.status");
        const errorData = get(error, "response.data");
        switch (status) {
            case STATUS_CODE.Unauthorized: {
                const { t } = i18n.global;
                removeToken();
                return Promise.reject({ message: t("common.unauthorized"), status });
            }
            default:
                return Promise.reject({ ...errorData, status });
        }
    }
);

function getApi(url, config = {}) {
    return axiosInstance.get(url, config);
}

function postApi(url, data, config = {}) {
    return axiosInstance.post(url, data, config);
}

function putApi(url, data, config = {}) {
    return axiosInstance.put(url, data, config);
}

function deleteApi(url, config = {}) {
    return axiosInstance.delete(url, config);
}

const httpRequest = {
    get: getApi,
    post: postApi,
    put: putApi,
    delete: deleteApi,
};

export default httpRequest;
