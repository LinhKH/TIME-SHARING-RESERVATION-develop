<template>
    <div class="p-3">
        <FormKit type="group" v-model="formData">
            <div v-if="isEdit" class="flex items-center mb-1">
                <div class="w-[250px] h-full flex items-center">
                    <i class="fa fa-calendar"></i>
                    <span class="font-bold ml-1">
                        {{ $t("form_user_manage.registered_date") }}
                    </span>
                </div>
                <div class="flex-1 flex justify-between h-full">
                    <div class="h-full flex items-center">
                        {{ formData.register_date }}
                        {{ convertDate(new Date(formData.register_date) ) }}
                    </div>
                </div>
            </div>

            <div class="flex items-center mb-2">
                <div class="w-[250px] h-full flex items-center">
                    <LabelRequired />
                    <i class="fa fa-level-up"></i>
                    <span class="font-bold ml-1"> {{ $t("form_user_manage.user_type") }}</span>
                </div>
                <div class="flex-1 h-full">
                    <FormKit type="radio" name="user_type" :options="optionUserType" wrapper-class="flex items-center"
                        options-class="flex" outer-class="w-96 h-full flex items-center"
                        label-class=" font-bold ml-1 mr-4" validation="required" :validation-messages="{
                            required: $t('validation.required'),
                        }" message-class="text-[red] mt-2" />
                </div>
            </div>

            <div class="flex items-center mb-2">
                <div class="w-[250px] h-full flex items-center">
                    <i class="fa fa-font"></i>
                    <span class="font-bold ml-1">
                        {{ $t("form_user_manage.company_organization_name") }}
                    </span>
                </div>
                <div class="flex-1 h-full">
                    <FormKit type="text" :value="formData.organization_name" :readonly="false" name="organization_name"
                        input-class="bg-white w-[800px] max-w-full h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                </div>
            </div>

            <div class="flex items-center mb-2">
                <div class="w-[250px] h-full flex items-center">
                    <LabelRequired />
                    <span class="font-bold ml-1"> {{ $t("form_user_manage.enabled_disabled") }}</span>
                </div>
                <div class="flex-1 h-full">
                    <FormKit type="radio" name="active" :options="optionsUserActive" wrapper-class="flex items-center"
                        options-class="flex" outer-class="w-96 h-full flex items-center"
                        label-class=" font-bold ml-1 mr-4" validation="required" :validation-messages="{
                            required: $t('validation.required'),
                        }" message-class="text-[red] mt-2" />
                </div>
            </div>

            <div class="flex items-center mb-2">
                <div class="w-[250px] h-full flex items-center">
                    <LabelRequired />
                    <i class="fa fa-envelope-o"></i>
                    <span class="font-bold ml-1">
                        {{ $t("form_user_manage.email_address") }}
                    </span>
                </div>
                <div class="flex-1 h-full">
                    <FormKit type="text" name="email" validation="required|email"
                        input-class="bg-white w-[800px] max-w-full h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                        :validation-messages="{
                            required: $t('validation.required'),
                            email: $t('validation.email'),
                        }" message-class="text-[red] mt-2" />
                </div>
            </div>

            <div class="flex items-center mb-2">
                <div class="w-[250px] h-full flex items-center">
                    <LabelRequired />
                    <span class="font-bold ml-1">
                        {{ $t("form_user_manage.name_chinese") }}
                    </span>
                </div>

                <div class="flex-1 flex h-full">
                    <div class="pr-4 flex">
                        <div class="w-1/4 flex items-center">
                            <LabelRequired />
                            <span class="font-bold mr-2 block">
                                {{ $t("form_user_manage.surname") }}
                            </span>
                        </div>
                        <FormKit type="text" name="first_name"
                            input-class="bg-white max-w-full w-[350px] h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                            validation="required" :validation-messages="{
                                required: $t('validation.required'),
                            }" message-class="text-[red] mt-2" />
                    </div>
                    <div class="pr-4 flex">
                        <div class="w-1/4 flex items-center">
                            <LabelRequired />
                            <span class="font-bold mr-2 block">
                                {{ $t("form_user_manage.name") }}
                            </span>
                        </div>
                        <FormKit type="text" name="last_name"
                            input-class="bg-white max-w-full w-[350px] h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                            validation="required" :validation-messages="{
                                required: $t('validation.required'),
                            }" message-class="text-[red] mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center mb-2">
                <div class="w-[250px] h-full flex items-center">
                    <LabelRequired />
                    <span class="font-bold ml-1">
                        {{ $t("form_user_manage.name_furigana") }}
                    </span>
                </div>

                <div class="flex-1 flex h-full">
                    <div class="pr-4 flex">
                        <div class="w-1/4 flex items-center">
                            <LabelRequired />
                            <span class="font-bold mr-2 block">
                                {{ $t("form_user_manage.surname") }}
                            </span>
                        </div>
                        <FormKit type="text" name="first_name_furigana"
                            input-class="first_name_furigana bg-white max-w-full w-[350px] h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                            :validation="[['required'], ['matches', /^[\u30A0-\u30FF]+$/]]" :validation-messages="{
                                required: $t('validation.required'),
                                matches: $t('validation.error_katakana'),
                            }" message-class="text-[red] mt-2" />
                    </div>
                    <div class="pr-4 flex">
                        <div class="w-1/4 flex items-center">
                            <LabelRequired />
                            <span class="font-bold mr-2 block">
                                {{ $t("form_user_manage.name") }}
                            </span>
                        </div>
                        <FormKit type="text" name="last_name_furigana"
                            input-class="last_name_furigana bg-white max-w-full w-[350px] h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                            :validation="[['required'], ['matches', /^[\u30A0-\u30FF]+$/]]" :validation-messages="{
                                required: $t('validation.required'),
                                matches: $t('validation.error_katakana'),
                            }" message-class="text-[red] mt-2" autocomplete="off" />
                    </div>
                </div>
            </div>

            <div class="flex mb-2">
                <div class="flex w-[250px]">
                    <i class="fa fa-picture-o"></i>
                    <span class="block ml-1 font-bold">
                        {{ $t("form_user_manage.photo") }}
                    </span>
                </div>
                <div class="flex-1">
                    <span class="block mb-2">
                        {{ $t("form_user_manage.photo") }}
                    </span>
                    <input type="file" name="" accept="image/png, image/jpeg" id="" />
                </div>
            </div>

            <div class="flex mb-2">
                <div class="flex w-[250px] items-center">
                    <i class="fa fa-key"></i>
                    <span class="block ml-1 font-bold">
                        {{ $t("form_user_manage.password") }}
                    </span>
                </div>
                <div class="flex-1">
                    <FormKit type="password" name="password"
                        :help="$t('form_user_manage.not_want_to_change_the_password')" help-class=" mt-1"
                        input-class="bg-white max-w-full w-[350px] h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                        autocomplete="new-password" />
                </div>
            </div>

            <div class="flex mb-2">
                <div class="flex w-[250px] items-center">
                    <LabelRequired />
                    <i class="fa fa-transgender"></i>
                    <span class="block ml-1 rounded font-bold"> {{ $t("form_user_manage.sex") }}</span>
                </div>
                <div class="flex-1">
                    <FormKit type="radio" name="gender_type" :options="optionsGenderType"
                        wrapper-class="flex items-center" options-class="flex"
                        outer-class="w-96 h-full flex items-center" label-class=" font-bold ml-1 mr-4"
                        validation="required" :validation-messages="{
                            required: $t('validation.required'),
                        }" message-class="text-[red] mt-2" />
                </div>
            </div>

            <div class="flex mb-2">
                <div class="flex w-[250px] items-center">
                    <span class="block ml-1 font-bold">
                        {{ $t("form_user_manage.request_notification") }}
                    </span>
                </div>
                <div class="flex-1">
                    <FormKit type="checkbox" name="request_notification" input-class="mr-2"
                        wrapper-class="flex items-center" :label="$t('form_user_manage.receive')"
                        label-class=" font-bold" />
                </div>
            </div>

            <div class="flex mb-2">
                <div class="flex w-[250px]">
                    <i class="fa fa-wrench"></i>
                    <span class="block ml-1 font-bold">
                        {{ $t("form_user_manage.email_newsletter") }}
                    </span>
                </div>
                <div class="flex-1">
                    <FormKit type="checkbox" input-class="mr-2" name="receive_newsletter"
                        wrapper-class="flex items-center" label-class=" font-bold"
                        :label="$t('form_user_manage.receive')" :help="$t('form_user_manage.inquiry_emails')" />
                </div>
            </div>

            <div class="flex mb-2">
                <div class="flex w-[250px] pr-2">
                    <i class="fa fa-wrench"></i>
                    <span class="block ml-1 font-bold">
                        {{ $t("form_user_manage.please_select_the_authority") }}
                    </span>
                </div>
                <div class="flex-1">
                    <FormKit type="checkbox" :options="optionsUserRoles" name="roles" wrapper-class="flex items-center"
                        input-class="mr-2" label-class=" font-bold" />
                </div>
            </div>

            <div class="flex mb-2">
                <div class="flex w-[250px] pr-2">
                    <i class="fa fa-wrench"></i>
                    <span class="block ml-1 font-bold">
                        {{ $t("form_user_manage.responsible_person") }}
                    </span>
                </div>
                <div class="flex-1">
                    <FormKit type="checkbox" :options="optionsUserWorkingGroup" name="working_groups"
                        wrapper-class="flex items-center" input-class="mr-2" label-class=" font-bold" />
                </div>
            </div>

            <div class="flex mb-2">
                <div class="flex w-[250px]"></div>
                <div class="w-[500px]">
                    <button class="px-3 py-2 bg-[#ffbd00] text-white block ml-auto rounded-lg" @click="handleSubmit">
                        {{ $t("form_user_manage.keep") }}
                    </button>
                </div>
            </div>
        </FormKit>
    </div>
</template>

<script>
import { addUserManager, getUserManager, updateProfileManager } from "@/api";
import { MODULE_STORE, ROUTER_PATH, FORM_USER_MANAGE, ROUTE_NAME } from "@/const";
import LabelRequired from "@/components/LabelRequired";
import { convertDate } from "@/utils";

export default {
    name: "FORM_USER_MANAGE",
    components: { LabelRequired },
    data() {
        return {
            formData: {
                organization_name: null,
                user_type: null,
                active: null,
                email: null,
                first_name: null,
                last_name: null,
                first_name_furigana: null,
                nameSpace: null,
                last_name_furigana: null,
                password: null,
                gender_type: null,
                request_notification: null,
                receive_newsletter: null,
                roles: null,
                working_groups: null,
                organization_id: 1,
            },
            type: localStorage.getItem("type"),
        };
    },
    props: {
        edit: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        convertDate() {
            return convertDate;
        },
        optionUserType() {
            return [
                {
                    label: this.$t("list_user_manage_page.admin"),
                    value: FORM_USER_MANAGE.ADMIN,
                },
                {
                    label: this.$t("list_user_manage_page.organization"),
                    value: FORM_USER_MANAGE.ORGANIZATION,
                },
            ];
        },
        optionsUserActive() {
            return [
                {
                    label: this.$t("form_user_manage.enabled"),
                    value: true,
                },
                {
                    label: this.$t("form_user_manage.disabled"),
                    value: false,
                },
            ];
        },
        optionsGenderType() {
            return [
                {
                    label: this.$t("form_user_manage.male"),
                    value: FORM_USER_MANAGE.MALE,
                },
                {
                    label: this.$t("form_user_manage.female"),
                    value: FORM_USER_MANAGE.FEMALE,
                },
            ];
        },
        optionsUserRoles() {
            return [
                {
                    label: this.$t("form_user_manage.organization"),
                    value: FORM_USER_MANAGE.ORGANIZATION,
                },
                {
                    label: this.$t("form_user_manage.inquiry"),
                    value: FORM_USER_MANAGE.INQUIRY,
                },
                {
                    label: this.$t("form_user_manage.user"),
                    value: FORM_USER_MANAGE.USER,
                },
                {
                    label: this.$t("form_user_manage.reservation"),
                    value: FORM_USER_MANAGE.RESERVATION,
                },
                {
                    label: this.$t("form_user_manage.reservation_compensation_charge"),
                    value: FORM_USER_MANAGE.RESERVATION_COMPENSATION_CHARGE,
                },
                {
                    label: this.$t("form_user_manage.customer"),
                    value: FORM_USER_MANAGE.CUSTOMER,
                },
                {
                    label: this.$t("form_user_manage.rental_space"),
                    value: FORM_USER_MANAGE.RENTAL_SPACE,
                },
                {
                    label: this.$t("form_user_manage.all"),
                    value: FORM_USER_MANAGE.ALL,
                },
                {
                    label: this.$t("form_user_manage.supervisor"),
                    value: FORM_USER_MANAGE.SUPERVISOR,
                },
            ];
        },
        optionsUserWorkingGroup() {
            return [
                {
                    label: this.$t("form_user_manage.invoice_charge"),
                    value: FORM_USER_MANAGE.BILLING,
                },
            ];
        },
        isEdit() {
            return this.edit;
        },
        isAdd() {
            return !this.edit;
        },
        manageId() {
            return this.$route.params.id;
        },
        isUpdateInfo() {
            return this.$route.name == ROUTE_NAME.ADMIN.ADMIN_UPDATE_INFO;
        },
        loginId() {
            return localStorage.getItem("adminId");
        },
    },
    methods: {
        handleSubmit() {
            const regex = /^[\u30A0-\u30FF]+$/;
            if (!regex.test(this.formData.first_name_furigana)) {
                const first_name_furigana = document.querySelector(".first_name_furigana");
                if (first_name_furigana) first_name_furigana.focus();
            } else if (!regex.test(this.formData.last_name_furigana)) {
                const last_name_furigana = document.querySelector(".last_name_furigana");
                if (last_name_furigana) last_name_furigana.focus();
            } else {
                if (this.isAdd) {
                    this.addUserManager();
                    return;
                }
                this.updateProfileManager();
            }
        },
        async addUserManager() {
            try {
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                await addUserManager({
                    ...this.formData,
                    user: {
                        roles: this.formData["roles"],
                        working_groups: this.formData["working_groups"],
                    },
                });
                this.$router.back();
            } catch (errors) {
                const error = errors.message || this.$t("common.has_error");
                this.$toast.error(error);
            } finally {
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        },
        async updateProfileManager() {
            let manageId = this.manageId;
            if (this.isUpdateInfo) manageId = this.loginId;
            try {
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                await updateProfileManager(manageId, {
                    ...this.formData,
                    user: {
                        roles: this.formData["roles"],
                        working_groups: this.formData["working_groups"],
                    },
                });
                this.$toast.success("Successfully!");
                this.$router.back();
            } catch (errors) {
                if (errors.data.length) {
                    errors.data.forEach((element) => {
                        element.messages.forEach((err) => {
                            this.$toast.error(err);
                        });
                    });
                }
            } finally {
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        },
    },
    async created() {
        let manageId = this.manageId;
        if (this.type) if (this.isUpdateInfo) manageId = this.loginId;
        if (this.isEdit) {
            try {
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const response = await getUserManager(manageId);
                this.formData = {
                    ...this.formData,
                    ...response,
                    gender_type: response.gender,
                    roles: response.roles.map((item) => item),
                    working_groups: response.working_groups.map((item) => item),
                };
            } catch (errors) {
                const error = errors.message || this.$t("common.has_error");
                this.$toast.error(error);
            } finally {
                this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        }
    },
};
</script>

<style scoped></style>
