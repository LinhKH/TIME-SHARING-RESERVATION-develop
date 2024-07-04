<template>
    <div>
        <LayoutInput :customCss="`mt-5`" v-for="(item, index) in listInput" :key="index" :labelText="item.label"
            :isRequired="item.isRequired" :iconPrev="item.iconPrev">
            <template v-if="item.type === TYPE_COMMON.select">
                <Select :optionsSelect="item.option" :inputKey="'input_1'" :currentValue="'item2'"
                    @changeValue="updateValueInput" />
            </template>

            <template v-if="item.type === TYPE_COMMON.multipleCheckBox">
                <MultipleCheckbox :optionFilterReservation="item.option"
                    @onInput="(value) => item.name && (formData[item.name] = value)" :hiddenButton="item.hiddenButton"
                    :valueSelected="formData[item.name]" />
            </template>

            <template v-if="item.type === TYPE_COMMON.text">
                <Input class="w-[30%]" @changeValue="(obj) => (formData[obj.key] = obj.value)" :inputKey="item.name"
                    :inputText="formData[item.name]" />
            </template>

            <template v-if="item.type === TYPE_COMMON.multipleSelect">
                <select multiple="" size="10" class="p-2 w-[30%] border border-solid border-[#ddd]">
                    <option class="select-pref">北海道</option>
                    <option class="select-pref">熊本県</option>
                    <option class="select-pref">大分県</option>
                    <option class="select-pref">宮崎県</option>
                    <option class="select-pref">鹿児島県</option>
                    <option class="select-pref">沖縄県</option>
                </select>
            </template>

            <template v-if="item.type === TYPE_COMMON.radio">
                <InputRadio :optionProps="item.option" :disabledAll="item.disabledAll"
                    @update:modelValue="(value) => item.name && (formData[item.name] = value)"
                    :modelValue="formData[item.name]" />
            </template>

            <template v-if="item.type === TYPE_COMMON.numberOfPeople">
                <div class="flex items-center">
                    <Input type="number" min="1" class="w-[30%]" :label="item.labelInputLeft"
                        @changeValue="(obj) => (formData[obj.key].from = obj.value)" :inputKey="item.name" />
                    <div class="mx-2">〜</div>
                    <Input type="number" min="1" class="w-[30%]" :label="item.labelInputRight"
                        @changeValue="(obj) => (formData[obj.key].to = obj.value)" :inputKey="item.name" />
                    <CheckBox :option="item.optionCheckBox" class="ml-3"
                        @updateValue="(value) => (formData[item.name].case_person = value[0])" />
                </div>
            </template>

            <template v-if="item.type === TYPE_COMMON.datePicker">
                <div class="flex items-center">
                    <div class="flex h-8 border rounded mr-4">
                        <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div
                            class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] text-sm flex items-center justify-center">
                            {{ $t("list_customer_dropdown.start_date") }}
                        </div>
                        <div class="flex items-center justify-center">
                            <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="startDatePicker" />
                        </div>
                    </div>
                    <div class="flex h-8 border rounded">
                        <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div
                            class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] text-sm flex items-center justify-center">
                            {{ $t("list_customer_dropdown.end_date") }}
                        </div>
                        <div class="flex items-center justify-center">
                            <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="endDatePicker" />
                        </div>
                    </div>
                    <div class="mx-4 cursor-pointer inline-block p-2 bg-[#efefef] rounded">今日</div>
                    <div class="text-[#737373]">例) 2016-03-12</div>
                </div>
            </template>
        </LayoutInput>
        <ButtonCommon :icon="`fa fa-search mr-1`" :text="`検索`" class="px-3 py-2 mb-5" @click="handleEmitFilter" />
        <hr />
    </div>
</template>

<script>
import Datepicker from "vue3-datepicker";
import Input from "@/components/Form/Input.vue";
import { watch, ref, reactive } from "vue";
import Select from "@/components/Form/Select.vue";
import MultipleCheckbox from "@/components/Form/MultipleCheckbox.vue";
import { TYPE_COMMON } from "@/const";
import {
    optionOnlineReservationType,
    optionProxyReservationReservationType,
    conditionFilter,
    optionYesOrNo,
    optionUserCategory,
} from "@/const/options";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import InputRadio from "@/components/Form/InputRadio.vue";
import CheckBox from "@/components/Form/CheckBox.vue";
import ButtonCommon from "@/components/Buttons/ButtonCommon";

export default {
    name: "FilterReservation",
    components: {
        Input,
        Select,
        MultipleCheckbox,
        Datepicker,
        LayoutInput,
        InputRadio,
        CheckBox,
        ButtonCommon,
    },
    props: {
        optionStatusReservation: Object,
        optionPurposeOfUse: Object,
        optionReservationType: Object,
        dataFilter: { type: Object, default: {} },
    },
    emits: ["filter"],
    setup(props, context) {
        const startDatePicker = ref(new Date());
        const endDatePicker = ref(new Date());
        const updateValueInput = () => { };
        const initForm = {
            status: [],
            use_purpose_category: [],
            use_purpose_for_other: "",
            proxy_reservation_type: "",
            frontend_reservation_type: "",
            coupon_status: "",
            id: "",
            coupon_name: "",
            email: "",
            phone_number: "",
            tracking_reference_id: "",
            people_count: {},
            rental_space_id: "",
            space_id_exclusion: "",
        };
        const formData = reactive({ ...initForm });
        watch(
            () => props.dataFilter,
            (value) => {
                if (Object.keys(value).length) {
                    Object.keys(value).forEach((item) => {
                        formData[item] = value[item];
                    });
                } else {
                    Object.keys(initForm).forEach((item) => {
                        formData[item] = initForm[item];
                    });
                }
            },
            { immediate: true }
        );
        const listInput = [
            {
                type: TYPE_COMMON.select,
                option: conditionFilter,
                isRequired: true,
                iconPrev: "fa fa-sort mr-1",
                label: "以下で並べ替え",
            },
            {
                type: TYPE_COMMON.multipleCheckBox,
                option: props.optionStatusReservation,
                label: "ステータス",
                name: "status",
            },
            {
                type: TYPE_COMMON.multipleCheckBox,
                option: props.optionPurposeOfUse,
                label: "利用目的",
                name: "use_purpose_category",
            },
            {
                type: TYPE_COMMON.text,
                label: "利用目的詳細",
                name: "use_purpose_for_other",
            },
            {
                type: TYPE_COMMON.multipleSelect,
                iconPrev: "fa fa-map-marker mr-1",
                label: "都道府県",
            },
            {
                type: TYPE_COMMON.multipleCheckBox,
                option: props.optionReservationType,
                label: "予約種類",
                hiddenButton: true,
            },
            {
                type: TYPE_COMMON.radio,
                option: optionOnlineReservationType,
                label: "ネット予約種類",
                name: "frontend_reservation_type",
            },
            {
                type: TYPE_COMMON.radio,
                option: optionProxyReservationReservationType,
                label: "代理予約 予約種別",
                name: "proxy_reservation_type",
            },
            {
                type: TYPE_COMMON.radio,
                option: optionYesOrNo,
                label: "飲食手配相談",
                iconPrev: "fa fa-level-up mr-1",
            },
            {
                type: TYPE_COMMON.radio,
                option: optionYesOrNo,
                label: "PR枠経由",
                iconPrev: "fa fa-level-up mr-1",
            },
            {
                type: TYPE_COMMON.radio,
                option: optionYesOrNo,
                label: "トラッキングリンク（スペなび）",
                iconPrev: "fa fa-level-up mr-1",
            },
            {
                type: TYPE_COMMON.radio,
                option: optionYesOrNo,
                label: "トラッキングリンク（オーナー）",
                iconPrev: "fa fa-level-up mr-1",
            },
            {
                type: TYPE_COMMON.radio,
                option: optionYesOrNo,
                label: "クーポン",
                iconPrev: "fa fa-level-up mr-1",
                name: "coupon_status",
            },
            {
                type: TYPE_COMMON.radio,
                option: optionUserCategory,
                label: " 利用者区分",
                iconPrev: "fa fa-level-up mr-1",
            },
            {
                type: TYPE_COMMON.text,
                label: "予約ID",
                name: "id",
            },
            {
                type: TYPE_COMMON.text,
                label: "お名前",
                name: "coupon_name",
            },
            {
                type: TYPE_COMMON.text,
                label: "ユーザーEmail",
                name: "email",
            },
            {
                type: TYPE_COMMON.text,
                label: "ユーザー電話番号",
                name: "phone_number",
            },
            {
                type: TYPE_COMMON.text,
                label: "スペース名",
            },
            {
                type: TYPE_COMMON.text,
                label: "スペースID",
                name: "rental_space_id",
            },
            {
                type: TYPE_COMMON.text,
                label: "スペースID除外",
                name: "space_id_exclusion",
            },
            {
                type: TYPE_COMMON.text,
                label: "トラッキングリンク テキスト",
                name: "tracking_reference_id",
            },
            {
                type: TYPE_COMMON.numberOfPeople,
                label: "人数",
                iconPrev: "fa fa-user-plus mr-1",
                name: "people_count",
                labelInputLeft: "人から",
                labelInputRight: "人まで",
                optionCheckBox: [
                    {
                        label: "１人の場合も含む",
                        value: 1,
                    },
                ],
            },
            {
                type: TYPE_COMMON.datePicker,
                label: "利用予定日 (期間)",
            },
            {
                type: TYPE_COMMON.datePicker,
                label: "予約完了日（期間）",
            },
        ];
        const handleEmitFilter = () => {
            context.emit("filter", formData);
        };
        return {
            updateValueInput,
            startDatePicker,
            endDatePicker,
            listInput,
            TYPE_COMMON,
            formData,
            handleEmitFilter,
        };
    },
};
</script>

<style lang="scss" scoped></style>
