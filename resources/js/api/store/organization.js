import api from "../http-request";
import apiConstants from "../apiConstant";

//[GET] method
export const getInfoBankCompany = async (id = 1) =>
  api.get(`${apiConstants.GET_INFO_BANK_COMPANY}/${id}/bank-account/all`);