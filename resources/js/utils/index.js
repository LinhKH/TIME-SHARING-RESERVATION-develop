import moment from "moment";
import router from "@/router";
import i18n from "@/i18n";
const { t } = i18n.global;

export const convertFormData = (FormData, obj, object, nameObj) => {
    const formData = { ...obj };
    Object.keys(formData).forEach((item) => {
        if (typeof formData[item] == "object") {
            convertFormData(FormData, formData[item], true, item);
            return;
        }
        if (object) {
            FormData.append(nameObj, formData[item]);
            return;
        }
        FormData.append(item, formData[item]);
    });
};
export const convertDateOfBirth = (date) => {
    let result = "";
    if (date) {
        const year = String(date).substr(0, 4);
        const month = String(date).substr(4, 2);
        const day = String(date).substr(6, 2);
        result = `${year}年${month}月${day}日`;
    }
    return result;
};
export const convertDateByTimestamp = (timestamp) => {
    return timestamp ? moment.unix(timestamp).format("YYYY年M月D日 (ddd) HH時mm分") : "";
};
export const convertDateNoTimeByTimestamp = (timestamp) => {
    return timestamp ? moment.unix(timestamp).format("YYYY年M月D日") : "";
};
export const convertDate = (timestamp) => {
    return timestamp ? moment.unix(timestamp).format("YYYY年M月D日 HH時mm分") : "";
};
export const handleBack = () => {
    const url = router.options.history.state.back;
    if (url) {
        router.push(url);
    }
};
export const isRequired = (data, error) => {
    let checkRequired = true;
    Object.keys(data).forEach((item) => {
        if (!data[item]) {
            error[item] = t("validation.required");
            checkRequired = false;
        } else {
            error[item] = null;
        }
    });
    return checkRequired;
};
export const downloadCsv = (csvContent) => {
    let charset = "data:text/csv;charset=utf-8,";
    let encodeUri = encodeURI(`${charset}${csvContent}`);
    let link = document.createElement("a");
    link.setAttribute("href", encodeUri);
    link.setAttribute("download", "inquiry_admin.csv");
    document.body.appendChild(link);
    link.click();
};
