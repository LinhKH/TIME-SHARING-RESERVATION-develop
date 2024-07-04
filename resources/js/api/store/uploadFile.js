import api from "../http-request";
import apiConstants from "../apiConstant";

export const uploadFiles = async (data) =>
    api.post(apiConstants.UPLOAD_FILE, data, {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    });
