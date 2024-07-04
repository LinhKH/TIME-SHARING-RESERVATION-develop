import { TYPE_USER } from "@/const";
export const setToken = (token, expires_in, type) => {
    const d = new Date();
    d.setTime(d.getTime() + expires_in * 1000);
    let expires = "expires=" + d.toUTCString();
    document.cookie = `token${type}=` + token + ";" + expires + ";path=/";
};
export const getToken = (type) => {
    let token = getCookie(`token${type}`);
    return token;
};

export const removeToken = (type) => {
    if (type) {
        document.cookie = `token${type}=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;`;
        return;
    }
    document.cookie = `token${TYPE_USER.ADMIN}=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;`;
    document.cookie = `token${TYPE_USER.USER}=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;`;
};

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(";");
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
