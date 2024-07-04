import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import i18n from "./i18n";
import store from "./store";
import "./assets/styles/font-awesome-4.5.0-master/css/font-awesome.min.css";
import "vue-toast-notification/dist/theme-sugar.css";
import "./assets/styles/tailwind.css";
import "./assets/styles/base.css";
import * as VeeValidate from "vee-validate";
import { plugin, defaultConfig } from "@formkit/vue";
import VueToast from "vue-toast-notification";
import CKEditor from "@ckeditor/ckeditor5-vue";

const app = createApp(App);

app.use(router);
app.use(store);
app.use(i18n);
app.use(plugin, defaultConfig);
app.use(VueToast, {
    position: "top-right",
});
app.use(VeeValidate, {
    inject: true,
    fieldsBagName: "$veeFields",
    errorBagName: "$veeErrors",
});
app.use(CKEditor);
app.mount("#app");

export default app;
