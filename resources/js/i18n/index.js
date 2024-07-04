import { createI18n } from "vue-i18n";
import langJa from "../locales/ja.json";
const i18n = createI18n({
    legacy: false,
    locale: "ja",
    messages: {
        ja: langJa,
    },
});
export default i18n;
