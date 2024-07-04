<template>
    <div v-if="isSuccess && isEmpty(errors)"
        class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-[10px] py-[12px]">
        <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
        <span class="text-[12px] text-[#3c763d]">{{ $t("form_setting_news.success") }}</span>
    </div>
    <div>
        <MenuForm :listMenus="listMenus" :textColor="textColor" />
        <div v-if="!isEmpty(errors)">
            <div class="text-start text-[14px] mb-[5px] my-[10px]">
                <p class="text-[#a94442] my-[5px]" v-for="(error, index) in errors" :key="index">
                    {{ error }}
                </p>
            </div>
        </div>
        <form @submit="submitForm">
            <div v-for="(newEditItem, index) in newEdit" :key="index" class="flex items-start justify-start mb-[8px]">
                <div class="flex items-center justify-start w-[17%]">
                    <i class="font-bold mr-[2px]" :class="newEditItem.icon"></i>
                    <span class="font-bold translate-y-px">{{ newEditItem.title }}</span>
                </div>
                <div class="w-[100%]">
                    <Field v-if="newEditItem.type === 'Date'" name="date">
                        <DatePicker :disabled="checkDisabled" v-model="date"
                            class="w-[25%] flex-1 border border-slate-300 focus:outline-none rounded block px-[12px] py-[6px] border border-[#ccc] h-[34px] text-[#555]" />
                    </Field>
                    <div v-if="newEditItem.type === 'Radio'" class="flex items-center justify-start">
                        <label class="flex items-center justify-start mr-[20px]">
                            <input type="radio" :checked="newDetail.active === 1" :name="newEditItem.name"
                                :value="newEditItem.inputRadio1" class="translate-y-[-1px] mr-[4px]"
                                @click="() => handleValueRadio(newEditItem.inputRadio1)" />
                            {{ newEditItem.inputRadio1 }}
                        </label>
                        <label class="flex items-center justify-start">
                            <input type="radio" :checked="newDetail.active === 2 || true" :name="newEditItem.name"
                                :value="newEditItem.inputRadio2" class="translate-y-[-1px] mr-[4px]"
                                @click="() => handleValueRadio(newEditItem.inputRadio2)" />
                            {{ newEditItem.inputRadio2 }}
                        </label>
                    </div>

                    <div v-if="newEditItem.type === 'Title'" class="flex items-start justify-start flex-col">
                        <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
                            <div
                                class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                                <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
                            </div>
                            <Field type="text" name="title" v-model="newDetail.title"
                                class="outline-none p-[5px] rounded-r w-full" />
                        </div>
                    </div>
                    <div v-if="newEditItem.type === 'subTitle'" class="flex items-start justify-start flex-col">
                        <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
                            <div
                                class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                                <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
                            </div>
                            <Field type="text" name="subTitle" v-model="newDetail.subtitle"
                                class="outline-none p-[5px] rounded-r w-full" />
                        </div>
                        <span v-if="newEditItem.explanationTitle" class="text-[#737373] mt-[5px]">{{
                            newEditItem.explanationTitle
                            }}</span>
                    </div>

                    <div v-if="newEditItem.type === 'Ckeditor'" class="flex items-start justify-start flex-col">
                        <div class="w-full border border-solid border-[#ddd] rounded flex">
                            <div
                                class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
                                <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
                            </div>
                            <div class="w-full">
                                <Field v-slot="{ field }" name="ckeditor1">
                                    <ckeditor v-bind="field" :editor="editor" :config="editorConfig"
                                        v-model="editorData" class="w-[100%]"></ckeditor>
                                </Field>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mb-[8px]">
                <button @click="handleSubmit"
                    class="group bg-[#fff] hover:bg-[#ffbd00] border border-solid border-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all">
                    <span class="text-[14px] text-[#ffbd00] group-hover:text-[#fff]"> {{ $t("form_setting_news.keep")
                        }}</span>
                </button>

                <button v-if="id || newId" @click="(event) => deleteItemNew(event)"
                    class="bg-[#fff] hover:bg-[#d43f3a] px-[12px] py-[6px] border border-solid border-[#d43f3a] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all ml-[10px] group">
                    <span class="text-[14px] text-[#d43f3a] group-hover:text-[#fff]"> {{ $t("form_setting_news.delete")
                        }}</span>
                </button>
            </div>
        </form>
    </div>
</template>
<script>
import JapanIcon from "@/assets/images/japan.png";
import MenuForm from "@/components/MenuForm";
import { useI18n } from "vue-i18n";
import DatePicker from "vue3-datepicker";
import { Form, Field } from "vee-validate";
import { useForm } from "vee-validate";
import * as Yup from "yup";
import { isEmpty } from "lodash";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { getDetailSettingNewApi, addSettingNewApi, deleteSettingNewApi, updateSettingNew } from "@/api";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import { ref, computed, inject } from "vue";
import { ROUTER_PATH, MODULE_STORE } from "@/const";

export default {
    name: "NewsAdd",
    components: {
        Form,
        MenuForm,
        DatePicker,
        Field,
    },
    setup(props) {
        const { t } = useI18n();
        const textColor = ref("#555");
        const date = ref(new Date());
        const checkDisabled = ref(false);
        const router = useRouter();
        const route = useRoute();
        const store = useStore();
        const toast = inject("$toast");
        const active = ref(2);
        const id = route.query.id;
        const editor = ClassicEditor;
        const editorData = ref(" ");
        const editorConfig = ref();
        const isSuccess = ref(false);
        const newDetail = ref({});
        const newId = ref();
        const checkCountAdd = ref(0);
        const listMenus = [
            {
                id: 1,
                active: true,
                icon: "fa fa-info-circle",
                text: t("form_setting_news.page_detail"),
                link: ``,
            },
        ];
        const newEdit = [
            {
                id: 1,
                type: "Date",
                name: "inputDate",
                icon: "fa fa-calendar",
                title: t("form_setting_news.date"),
            },
            {
                id: 2,
                type: "Radio",
                name: "inputRadio",
                icon: "",
                title: t("form_setting_news.public_private"),
                inputRadio1: "非公開",
                inputRadio2: "公開",
            },
            {
                id: 3,
                type: "Title",
                name: "title",
                icon: "",

                title: t("form_setting_news.title"),
            },
            {
                id: 4,
                type: "subTitle",
                name: "subTitle",
                icon: "",
                title: t("form_setting_news.subtitle"),

                explanationTitle: t(t("form_setting_news.explanation_title")),
            },
            {
                id: 4,
                type: "Ckeditor",
                name: "inputCkeditor",
                icon: "",

                title: t("form_setting_news.content"),
                explanationTitle: t(t("form_setting_news.explanation_title")),
            },
        ];
        const { handleSubmit, errors } = useForm({
            initialValues: {},
            validationSchema: Yup.object().shape({
                title: Yup.string().trim().required(t("form_setting_news.message_title")),
                ckeditor1: Yup.string().trim().required(t("form_setting_news.message_content")),
            }),
        });
        const submitForm = handleSubmit(async (values) => {
            if (id) {
                updateItemNew(values);
            } else {
                addSettingNew(values);
                isSuccess.value = true;
            }
        });
        const handleValueRadio = (value) => {
            if (value === "非公開") {
                checkDisabled.value = false;
                active.value = 1;
                date.value = new Date();
            } else {
                checkDisabled.value = false;
                active.value = 2;
                date.value = new Date();
            }
        };
        const addSettingNew = async (values) => {
            try {
                if (checkCountAdd.value === 0) {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                    let res;
                    if (values.subTitle) {
                        res = await addSettingNewApi({
                            active: active.value,
                            attribute: {
                                title: values.title,
                                content: editorData.value,
                                subtitle: values.subTitle,
                                date_time: date.value,
                            },
                        });
                    } else {
                        res = await addSettingNewApi({
                            active: active.value,
                            attribute: {
                                title: values.title,
                                content: editorData.value,
                                date_time: date.value,
                            },
                        });
                    }

                    newId.value = res.news_id;
                    checkCountAdd.value++;
                    router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.NEWS_ADD}?id=${res.news_id}`);
                }
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const deleteItemNew = async (event) => {
            event.preventDefault();
            if (confirm("お知らせを削除してよろしいですか？")) {
                if (id) {
                    try {
                        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                        await deleteSettingNewApi(id);
                        isSuccess.value = true;
                    } catch (errors) {
                        const error = errors.message || t("common.has_error");
                        toast.error(error);
                    } finally {
                        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
                    }
                }
                if (newId.value) {
                    try {
                        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                        await deleteSettingNewApi(newId.value);
                        isSuccess.value = true;
                    } catch (errors) {
                        const error = errors.message || t("common.has_error");
                        toast.error(error);
                    } finally {
                        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
                    }
                }

                router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.NEWS}`);
            }
        };
        const updateItemNew = async (values) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                if (values.subTitle) {
                    await updateSettingNew(id, {
                        active: active.value,
                        attribute: {
                            title: values.title.trim(),
                            content: editorData.value,
                            subtitle: values.subTitle,
                            date_time: date.value,
                        },
                    });
                } else {
                    await updateSettingNew(id, {
                        active: active.value,
                        attribute: {
                            title: values.title.trim(),
                            content: editorData.value,
                            date_time: date.value,
                        },
                    });
                }

                isSuccess.value = true;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const getDetailSettingNew = async () => {
            if (id) {
                try {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                    newDetail.value = await getDetailSettingNewApi(id);
                    editorData.value = newDetail.value.content;
                    date.value = new Date(newDetail.value.date_time);
                } catch (errors) {
                    const error = errors.message || t("common.has_error");
                    toast.error(error);
                } finally {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
                }
            }
        };
        getDetailSettingNew();
        return {
            listMenus,
            textColor,
            newDetail,
            id,
            newEdit,
            date,
            submitForm,
            errors,
            isEmpty,
            JapanIcon,
            handleValueRadio,
            checkDisabled,
            addSettingNew,
            active,
            editor,
            editorData,
            editorConfig,
            deleteItemNew,
            updateItemNew,
            isSuccess,
            newId,
            checkCountAdd,
        };
    },
};
</script>

<style></style>
