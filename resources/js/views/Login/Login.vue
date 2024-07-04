<template>
    <div class="h-[50px] w-full">
        <img :src="logoTimeSharing" alt="Log" class="h-4/5 ml-3" />
    </div>
    <div class="h-12 w-full bg-[#555555] flex items-center justify-center text-base text-white">
        {{ $t("login_screen_admin.owner_login_page") }}
    </div>
    <div class="w-full">
        <form class="mx-auto w-[600px] h-52 pt-16">
            <FormKit type="group" v-model="dataLogin">
                <FormKit type="text" :label="$t('login_screen_admin.label_email')"
                    :placeholder="$t('login_screen_admin.placeholder_email')" name="email"
                    value="admin@s-management.co.jp" wrapper-class="flex items-center mb-3" label-class="flex-1"
                    input-class="w-[400px] h-[45px] border border-solid border-[#dbdbdb] rounded outline-none px-2 focus:shadow-lg" />
                <FormKit type="password" :label="$t('login_screen_admin.label_password')"
                    :placeholder="$t('login_screen_admin.placeholder_password')" name="password" value="password"
                    wrapper-class="flex items-center mb-3" label-class="flex-1"
                    input-class="w-[400px] h-[45px] border border-solid border-[#dbdbdb] rounded outline-none px-2 focus:shadow-lg" />
                <div class="w-[400px] ml-auto">
                    <button @click="handleLogin"
                        class="block text-white transition-all duration-300 w-full py-2 bg-[#555] rounded my-2 hover:translate-y-1">
                        {{ $t("login_screen_admin.login") }}
                    </button>
                    <div class="mt-1">{{ $t("login_screen_admin.you_forget") }}</div>
                    <a class="text-blue-400" :href="urlRecovery">{{ $t("login_screen_admin.password_reset") }}</a>
                </div>
            </FormKit>
        </form>
    </div>
</template>

<script>
import logoTimeSharing from "@/assets/images/time_sharing_logo.png";
import { login } from "@/api";
import { MODULE_STORE, ROUTER_PATH, TYPE_USER } from "@/const";
import { isEmpty } from "lodash";
import { setToken, getToken, removeToken } from "@/utils/authToken";

export default {
    name: "Login",

    data() {
        return {
            dataLogin: {},
            urlRecovery: ROUTER_PATH.RECOVERY_REQUEST,
        };
    },
    computed: {
        logoTimeSharing() {
            return logoTimeSharing;
        },
    },
    methods: {
        async handleLogin(event) {
            event.preventDefault();
            if (isEmpty(this.dataLogin)) {
                return;
            }
            try {
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const form = new FormData;
                form.append("email", this.dataLogin.email);
                form.append("password", this.dataLogin.password);
                const response = await login(form);

                localStorage.setItem("roles", response.user.roles);
                localStorage.setItem("type", response.user.type);
                localStorage.setItem("adminId", response.user.id);

                const { access_token, expires_in } = response;
                if (getToken(TYPE_USER.USER)) removeToken(TYPE_USER.USER);
                setToken(access_token, expires_in, TYPE_USER.ADMIN);
                this.$store.state[MODULE_STORE.AUTH.NAME].isAuthenticated = true;
                this.$router.push(ROUTER_PATH.ADMIN);
                this.$toast.success(this.$t("toast_message.login_success"));
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            } catch (errors) {
                const error = errors.message || errors.error || this.$t("common.has_error");
                this.$toast.error(error);
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        },
    },
};
</script>

<style scoped></style>
