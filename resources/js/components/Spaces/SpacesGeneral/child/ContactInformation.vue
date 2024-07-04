<template>
    <LayoutForm :title="$t('spaces_general_page.contact_information')" icon="fa fa-envelope-o" :borderFooter="false">
        <div class="flex mt-2 items-center">
            <div class="w-64">
                <i class="fa fa-building-o mr-1"></i>
                <span class="font-bold">
                    {{ $t("spaces_general_page.operating_company") }}
                </span>
            </div>
            <div class="flex-1">
                <div class="w-[660px] border border-solid border-[#ddd] rounded flex h-8">
                    <div class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                        <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
                    </div>
                    <FormKit type="text" name="general_contact_operating_company_ja" outer-class="w-full"
                        wrapper-class="h-full" inner-class="h-full" help-class=" mt-1"
                        input-class="px-2 w-full h-full focus:shadow-lg outline-none  focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 " />
                </div>
                <div v-if="messagesFormError.general_contact_operating_company_ja">
                    <MessagesFormError :messages="messagesFormError.general_contact_operating_company_ja" />
                </div>
            </div>
        </div>

        <div class="flex mt-2 items-center">
            <div class="w-64">
                <i class="fa fa-user mr-1"></i>
                <span class="font-bold">
                    {{ $t("spaces_general_page.manager") }}
                </span>
            </div>
            <div class="flex-1">
                <div class="w-[660px] border border-solid border-[#ddd] rounded flex h-8">
                    <div class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                        <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
                    </div>
                    <FormKit type="text" name="general_contact_person_in_charge_ja" outer-class="w-full"
                        wrapper-class="h-full" inner-class="h-full" help-class=" mt-1"
                        input-class="px-2 w-full h-full focus:shadow-lg outline-none  focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 " />
                </div>
                <div v-if="messagesFormError.general_contact_person_in_charge_ja">
                    <MessagesFormError :messages="messagesFormError.general_contact_person_in_charge_ja" />
                </div>
            </div>
        </div>

        <div class="flex mt-2 items-center">
            <div class="w-64">
                <LabelRequired />
                <i class="fa fa-phone mx-1"></i>
                <span class="font-bold">
                    {{ $t("spaces_general_page.phone_number") }}
                </span>
            </div>
            <div class="flex-1 items-center">
                <FormKit type="text" v-model="informationUser.phone_number" name="general_contact_phone_number_ja"
                    :help="$t('spaces_general_page.help_3')" validation="required|number" :validation-messages="{
                        required: $t('validation.required'),
                        number: $t('validation.number'),
                    }" message-class="text-[red] mt-2" outer-class="mr-4" help-class="mt-1 text-[#737373]"
                    input-class="h-9 w-80 focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50 rounded border-solid border border-[#ddd] px-2 outline-none text-sx" />
                <div v-if="messagesFormError.general_contact_phone_number_ja">
                    <MessagesFormError :messages="messagesFormError.general_contact_phone_number_ja" />
                </div>
            </div>
        </div>

        <div class="flex mt-2 items-center">
            <div class="w-64">
                <LabelRequired />
                <i class="fa fa-envelope-o mx-1"></i>
                <span class="font-bold">
                    {{ $t("spaces_general_page.email_address") }}
                </span>
                <i class="fa fa-question-circle text-[#337ab7] ml-1" aria-hidden="true"></i>
            </div>
            <div class="flex-1 items-center">
                <FormKit type="text" v-model="informationUser.email" name="general_contact_email" placeholder=""
                    validation="required|email" :validation-messages="{
                        required: $t('validation.required'),
                        email: $t('validation.email'),
                    }" message-class="text-[red] mt-2" outer-class="mr-4"
                    input-class="h-9 w-80 focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50 rounded border-solid border border-[#ddd] px-2 outline-none text-sx" />
                <div v-if="messagesFormError.general_contact_email">
                    <MessagesFormError :messages="messagesFormError.general_contact_email" />
                </div>
            </div>
        </div>
    </LayoutForm>
</template>

<script>
import JapanIcon from "@/assets/images/japan.png";
import LabelRequired from "@/components/LabelRequired";
import LayoutForm from "@/components/Layouts/LayoutForm.vue";
import MessagesFormError from "@/components/MessagesForm";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import { useStore } from "vuex";
import { ref, inject } from "vue";
import { getUserProfileApi } from "@/api";

export default {
    name: "ContactInformation",
    components: { LabelRequired, LayoutForm, MessagesFormError },
    props: ["messagesFormError"],
    computed: {
        JapanIcon() {
            return JapanIcon;
        },
    },
    async setup(props, context) {
        const store = useStore();
        const toast = inject("$toast");
        const informationUser = ref({
            email: "",
            phone_number: "",
        });
        const getInformationUser = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getUserProfileApi();
                informationUser.value = res;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        await getInformationUser();
        return {
            informationUser,
        };
    },
};
</script>

<style scoped></style>
