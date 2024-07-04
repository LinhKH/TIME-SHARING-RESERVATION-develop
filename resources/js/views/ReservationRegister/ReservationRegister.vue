<template>
    <div v-show="isForm === true">
        <form class="max-w-[1200px] h-full m-auto">
            <div class="flex items-center justify-center py-[15px] mb-[50px]">
                <span class="font-semibold text-[30px]">{{ $t("reservation_register.title", { title: spaceTitle })
                    }}</span>
            </div>
            <div v-if="isConfirm" class="p-[10px] my-[10px] bg-[#f2dede] text-[#a94442]">
                {{ $t("reservation_register.confirm_form") }}
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.label.type_reservation`)"
                        :condition="$t(`reservation_register.condition`)" />
                </div>
                <div>
                    <div class="flex">
                        <div class="flex items-center border-2 border-solid border-[#eeeeee] rounded mr-[50px]">
                            <div class="h-full items-center bg-[#eeeeee] font-[12px] p-2">
                                <Field type="radio" id="1" value="web" class="h-full" name="proxy_reservation_type" />
                            </div>
                            <label for="1" class="text-center mx-4">
                                <i class="fa fa-cloud-upload"></i>
                                <span class="text-[12px]">{{ $t(`reservation_register.radio.web`) }}</span>
                            </label>
                        </div>
                        <div class="flex items-center border-2 border-solid border-[#eeeeee] rounded mr-[50px]">
                            <div class="h-full items-center bg-[#eeeeee] font-[12px] p-2">
                                <Field type="radio" id="2" value="new_apply" class="h-full"
                                    name="proxy_reservation_type" />
                            </div>
                            <label for="2" class="text-center mx-4">
                                <i class="fa fa-phone"></i>
                                <span class="text-[12px]">{{ $t(`reservation_register.radio.phone`) }}</span>
                            </label>
                        </div>
                        <div class="flex items-center border-2 border-solid border-[#eeeeee] rounded mr-[50px]">
                            <div class="h-full items-center bg-[#eeeeee] font-[12px] p-2">
                                <Field type="radio" id="3" value="extending" class="h-full"
                                    name="proxy_reservation_type" />
                            </div>
                            <label for="3" class="text-center mx-4">
                                <i class="fa fa-cloud-upload"></i>
                                <span class="text-[12px]">{{ $t(`reservation_register.radio.extern_phone`) }}</span>
                            </label>
                        </div>
                    </div>
                    <ErrorMessage class="text-[red]" name="proxy_reservation_type"></ErrorMessage>
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.label.use_date`)"
                        :condition="$t(`reservation_register.condition`)" />
                </div>
                <div class="mb-1">
                    <div class="flex items-center justify-center border rounded">
                        <div class="mr-4 mx-3 my-2">
                            <Datepicker v-model="date" :lowerLimit="new Date()"
                                class="px-2 h-full w-full outline-none text-center text-sm" />
                        </div>
                        <div class="h-full p-3 bg-[#eeeeee] border-r border-[#eeeeee] flex items-center justify-center">
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>
                    <MessageErrors class="mt-2" v-if="error.date" :messages="error.date" />
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.label.time`)"
                        :condition="$t(`reservation_register.condition`)" />
                </div>
                <div class="mb-1">
                    <TimePickRegister model="plan_less_start_time" :label="$t(`reservation_register.pick_time.from`)"
                        @onInput="handleUpdateTime" />
                    <MessageErrors v-if="error.plan_less_start_time" :messages="error.plan_less_start_time" />
                </div>
                <span class="mx-[20px] items-center">~</span>
                <div class="mb-1">
                    <TimePickRegister model="plan_less_end_time" :label="$t(`reservation_register.pick_time.to`)"
                        @onInput="handleUpdateTime" />
                    <MessageErrors v-if="error.plan_less_end_time" :messages="error.plan_less_end_time" />
                </div>
            </div>

            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.label.number_people`)"
                        :condition="$t(`reservation_register.condition`)" />
                </div>
                <div>
                    <Field as="select" name="people_count" v-model="people_count"
                        class="bg-white w-96 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50">
                        <option value="" disabled>選択して下さい</option>
                        <option v-for="people_count in numberPeople" :key="people_count" :value="people_count.value">
                            {{ people_count.label }}
                        </option>
                    </Field>
                    <div>
                        <ErrorMessage class="text-[red]" name="people_count"></ErrorMessage>
                    </div>
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.label.use_type`)"
                        :condition="$t(`reservation_register.condition`)" />
                </div>
                <div>
                    <div class="flex">
                        <div class="flex items-center border-2 border-solid border-[#eeeeee] rounded mr-[50px]">
                            <div class="h-full items-center bg-[#eeeeee] font-[12px] p-2">
                                <Field type="radio" id="4" value="organization" class="h-full"
                                    name="business_structure" />
                            </div>
                            <label for="4" class="text-center mx-4">
                                <i class="fa fa-building"></i>
                                <span class="text-[12px]">{{ $t(`reservation_register.radio.company`) }}</span>
                            </label>
                        </div>
                        <div class="flex items-center border-2 border-solid border-[#eeeeee] rounded mr-[50px]">
                            <div class="h-full items-center bg-[#eeeeee] font-[12px] p-2">
                                <Field type="radio" id="5" value="indivisual" class="h-full"
                                    name="business_structure" />
                            </div>
                            <label for="5" class="text-center mx-4">
                                <i class="fa fa-user"></i>
                                <span class="text-[12px]">{{ $t(`reservation_register.radio.your_self`) }}</span>
                            </label>
                        </div>
                    </div>
                    <ErrorMessage class="text-[red]" name="business_structure"></ErrorMessage>
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.label.purpose_use`)"
                        :condition="$t(`reservation_register.condition`)" />
                </div>
                <div>
                    <Field name="use_purpose_category" as="select"
                        class="bg-white w-96 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50">
                        <option value="" disabled>選択して下さい</option>
                        <option v-for="item in usePurpose" :key="item.id" :value="item.id">
                            {{ item.title_ja }}
                        </option>
                    </Field>
                    <div>
                        <ErrorMessage class="text-[red]" name="use_purpose_category"></ErrorMessage>
                    </div>
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.label.purpose_use_other`)"
                        :condition="$t(`reservation_register.condition`)" />
                </div>
                <div>
                    <Field type="text" name="use_purpose_for_other"
                        class="bg-white w-96 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                    <div>
                        <ErrorMessage class="text-[red]" name="use_purpose_for_other" />
                    </div>
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.price.price`)"
                        :condition="$t(`reservation_register.condition`)" />
                </div>
                <div class="w-5/6">
                    <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.price.space_price`)" />
                        </div>
                        <div class="flex">
                            <div>
                                <Field type="number" name="total_price_override_sans_tax"
                                    v-model="total_price_override_sans_tax" @input="handleCalculationPrice"
                                    class="bg-white w-60 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                                    min="0" />
                                <div>
                                    <ErrorMessage class="text-[red]" name="total_price_override_sans_tax" />
                                </div>
                            </div>
                            <span
                                class="h-8 flex items-center px-3 bg-[#eeeeee] rounded-tr-[4px] rounded-br-[4px] border border-[#ccc] text-[#555] text-[14px] text-[400]">{{
                                    $t(`reservation_register.price.yen`) }}</span>
                            <span class="mx-4 p-1">{{ $t(`reservation_register.price.no_vat_price`) }} </span>
                            <span class="mx-4 p-1"> {{ spacePriceVat }} {{ $t(`reservation_register.price.vat_price`)
                                }}</span>
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] item-center m-auto w-full">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.price.options`)" />
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] item-center m-auto w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.price.total`)" />
                        </div>
                        <div class="flex justify-around items-center">
                            <div class="w-full">
                                <span class="">{{ totalNoVAT }}</span>
                                <span class="mx-8 p-1">{{ $t(`reservation_register.price.yen`) }}{{
                                    $t(`reservation_register.price.no_vat_price`) }}</span>
                            </div>
                            <div class="w-full">
                                <span class="">{{ totalVAT }}</span>
                                <span class="mx-8 p-1">{{ $t(`reservation_register.price.vat_price`) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] item-center m-auto w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.price.ticket`)" />
                        </div>
                        <div class="flex">
                            <span
                                class="h-8 flex items-center px-3 bg-[#eeeeee] rounded-tl-[4px] rounded-bl-[4px] border border-[#ccc] text-[#555] text-[14px] text-[400]">
                                {{ $t(`reservation_register.price.key`) }}
                            </span>
                            <input type="text" v-model="codeCouponCustomer"
                                @input="(event) => getCouponCustomerFilter(event.target.value)"
                                class="bg-white w-60 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                            <span class="mr-4 p-1">{{ $t(`reservation_register.price.discount`) }} </span>
                            {{ vatDiscountPrice }}
                            <span class="mr-4 p-1">{{ $t(`reservation_register.price.discount_vat`) }} </span>
                            {{ totalDiscountPrice }}
                            <span class="mr-4 p-1">{{ $t(`reservation_register.price.discount_total`) }} </span>
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] item-center m-auto w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.price.money_discount`)" />
                        </div>
                        <div>
                            <div class="flex">
                                <Field type="number" name="limited_discount_price_sans_tax"
                                    v-model="limited_discount_price_sans_tax" @input="handleCalculationDiscountSpecial"
                                    class="bg-white w-60 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                                    min="0" />
                                <span
                                    class="flex items-center px-3 bg-[#eeeeee] rounded-tr-[4px] rounded-br-[4px] border border-[#ccc] text-[#555] text-[14px] text-[400]">
                                    {{ $t(`reservation_register.price.key`) }}
                                </span>
                                <span class="p-1">{{ $t(`reservation_register.price.no_vat_price`) }} </span>
                                <span class="ml-4 p-1">{{ moneyBeforeDiscount }} </span>
                                <span class="p-1">{{ $t(`reservation_register.price.vat_price`) }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] item-center m-auto w-full">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.price.total_final`)" />
                        </div>
                        <div class="flex justify-around items-center">
                            <div class="w-full">
                                <span class="ml-8 p-1">{{ totalNoVATFinal }}</span>
                                <span class="p-1">{{ $t(`reservation_register.price.yen`) }}{{
                                    $t(`reservation_register.price.no_vat_price`) }}</span>
                            </div>
                            <div class="w-full">
                                <span class="ml-8 p-1">{{ totalVATFinal }}</span>
                                <span class="p-1">{{ $t(`reservation_register.price.vat_price`) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.information_customer.label`)" />
                </div>
                <div class="w-5/6">
                    <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.information_customer.name`)"
                                :icon="`fa fa-user`" />
                        </div>
                        <div class="flex">
                            <div class="">
                                <div class="">{{ $t("reservation_register.information_customer.first_name") }}</div>
                                <input type="text" disabled
                                    class="bg-[#eeeeee] w-60 h-8 px-2 rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                            </div>
                            <div class="mx-[15px]">
                                <div class="">{{ $t("reservation_register.information_customer.last_name") }}</div>
                                <input type="text" disabled
                                    class="bg-[#eeeeee] w-60 h-8 px-2 rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                            </div>
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.information_customer.name_conpany`)"
                                :icon="`fa fa-font`" />
                        </div>
                        <div class="flex">
                            <input type="text" disabled
                                class="bg-[#eeeeee] w-60 h-8 px-2 rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.information_customer.name_conpany_Kana`)"
                                :icon="`fa fa-font`" />
                        </div>
                        <div class="flex">
                            <input type="text" disabled
                                class="bg-[#eeeeee] w-60 h-8 px-2 rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.information_customer.email`)"
                                :condition="$t(`reservation_register.condition`)" :icon="`fa fa-envelope-o`" />
                        </div>
                        <div class="">
                            <Field type="text" name="customer_email"
                                class="bg-[#fff] w-60 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                            <div>
                                <ErrorMessage class="text-[red]" name="customer_email" />
                                <MessageErrors v-if="error.email_customer" :messages="error.email_customer" />
                            </div>
                        </div>
                    </div>
                    <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                        <div class="w-1/5">
                            <label-register :label="$t(`reservation_register.information_customer.phone`)"
                                :icon="`fa fa-phone`" />
                        </div>
                        <div class="flex">
                            <input type="text" disabled
                                class="bg-[#eeeeee] w-60 h-8 px-2 rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                            <span class="">{{ $t("reservation_register.information_customer.note") }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.note`)" />
                </div>
                <div class="">
                    <Field name="memo_owner" v-slot="{ field }">
                        <textarea v-bind="field" id=""
                            class="bg-[#fff] w-[100%] h-[48px] px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50">
            </textarea>
                    </Field>
                    <div class="text-[12px]">{{ $t("reservation_register.note_text") }}</div>
                    <Field name="memo_customer" v-slot="{ field }">
                        <textarea v-bind="field" id=""
                            class="bg-[#fff] w-[100%] h-[48px] px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50">
            </textarea>
                    </Field>
                </div>
            </div>
            <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
                <div class="w-1/6">
                    <label-register :label="$t(`reservation_register.owner_person`)" />
                </div>
                <div class="">{{ $t(`reservation_register.person`) }}</div>
            </div>
            <div class="my-3">
                <div @click="submitForm"
                    class="flex items-center justify-center w-[50%] h-full p-[18px] m-auto bg-[#2ad6a3] cursor-pointer">
                    <button class="text-[#fff] text-center">
                        {{ $t(`reservation_register.submit`) }}
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div v-show="isForm === false">
        <ConfirmReservationRegister :dataForm="dataForm" :dataCustomer="dataCustomer" @handleBack="isForm = true"
            :idSpace="idSpace" :listPurpose="usePurpose" :title="spaceTitle" />
    </div>
</template>

<script>
import * as Yup from "yup";
import { useI18n } from "vue-i18n";
import { MODULE_STORE } from "@/const";
import Datepicker from "vue3-datepicker";
import { useStore } from "vuex";
import { useRoute, useRouter } from "vue-router";
import { ref, inject, reactive, watch, computed } from "vue";
import { Field, useForm, ErrorMessage } from "vee-validate";
import TimePickRegister from "./child/TimePickRegister.vue";
import LabelRegister from "./child/LabelRegister.vue";
import ConfirmReservationRegister from "@/views/ReservationRegister/child/ConfirmReservationRegister/ConfirmReservationRegister.vue";
import { numberPeople } from "@/const/options";
import MessageErrors from "@/components/Atoms/MessageErrors.vue";
import { isRequired } from "@/utils";
import {
    getFilterCustomerByEmailApi,
    getCouponCustomerFilterApi,
    getListPurposeOfUseByCategory,
    getPublicSpacePreview,
} from "@/api";

export default {
    name: "ReservationRegister",
    components: {
        LabelRegister,
        Datepicker,
        TimePickRegister,
        Field,
        ErrorMessage,
        MessageErrors,
        ConfirmReservationRegister,
    },
    setup() {
        const isForm = ref(true);
        const isConfirm = ref(false);
        const timePicker = ref();
        const date = ref(new Date());
        const formTime = reactive({});
        const route = useRoute();
        const router = useRouter();
        const store = useStore();
        const { t } = useI18n();
        const toast = inject("$toast");
        const totalNoVAT = ref(0);
        const totalVAT = ref(0);
        const codeCouponCustomer = ref();
        const spacePriceVat = ref(0);
        const people_count = ref(numberPeople[0].value);
        const idSpace = route.query.id;

        const vatDiscountPrice = ref(0);
        const totalDiscountPrice = ref(0);
        const limited_discount_price_sans_tax = ref(0);
        const moneyBeforeDiscount = ref(0);

        const total_price_override_sans_tax = ref(0);
        const totalNoVATFinal = ref(0);
        const totalVATFinal = ref(0);
        const dataPrice = ref({
            totalNoVATFinal: totalNoVATFinal.value,
            totalVATFinal: totalVATFinal.value,
            moneyBeforeDiscount: moneyBeforeDiscount.value,
            totalDiscountPrice: totalDiscountPrice.value,
            vatDiscountPrice: vatDiscountPrice.value,
            spacePriceVat: spacePriceVat.value,
            totalNoVAT: totalNoVAT.value,
            totalVAT: totalVAT.value,
            codeCouponCustomer: codeCouponCustomer.value,
        });
        const handleCalculationDiscountSpecial = () => {
            const valueDiscountSpecial = Number(limited_discount_price_sans_tax.value);
            moneyBeforeDiscount.value = Math.floor(valueDiscountSpecial * 0.1 + valueDiscountSpecial);
        };
        const handleCalculationPrice = () => {
            if (total_price_override_sans_tax) {
                const spaceValue = Number(total_price_override_sans_tax.value);
                spacePriceVat.value = Math.floor(spaceValue * 0.1 + spaceValue);
            }
        };
        const initUpdate = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getPublicSpacePreview(idSpace);
                if (res?.data) {
                    store.commit(`${MODULE_STORE.RENTAL_SPACES.NAME}/SET_PREVIEWED_SPACE`, res.data);
                }
            } catch (error) {
                toast.error(error.msg);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const spaceInformation = computed(() => store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/getPreviewedSpace`]);
        const spaceTitle = computed(() => spaceInformation.value?.general?.general_basic_space_name_ja || "");
        initUpdate();
        watch(
            total_price_override_sans_tax && limited_discount_price_sans_tax,
            () => {
                totalVATFinal.value = spacePriceVat.value - moneyBeforeDiscount.value;
                totalNoVATFinal.value =
                    Number(total_price_override_sans_tax.value) - Number(limited_discount_price_sans_tax.value);
            },
            { immediate: true }
        );
        watch(
            total_price_override_sans_tax,
            () => {
                totalVATFinal.value = spacePriceVat.value;
                totalNoVATFinal.value = Number(total_price_override_sans_tax.value);
            },
            { immediate: true }
        );
        const error = reactive({
            date: "",
            plan_less_start_time: "",
            plan_less_end_time: "",
            confirm_email: "",
            email_customer: "",
        });
        const dataForm = ref({});
        const dataCustomer = reactive({
            first_name: "",
            last_name: "",
            company_name: "",
            company_name_kana: "",
            phone_number: "",
            email: "",
        });
        const time = ref({
            hours: new Date().getHours(),
            minutes: new Date().getMinutes(),
        });
        const usePurpose = ref();
        const { handleSubmit, errors } = useForm({
            initialValues: {},
            validationSchema: Yup.object().shape({
                proxy_reservation_type: Yup.string().required(t(`reservation_register.errors.required`)),
                use_purpose_category: Yup.string().required(t(`reservation_register.errors.required`)),
                use_purpose_for_other: Yup.string().required(t(`reservation_register.errors.required`)),
                people_count: Yup.string().required(t(`reservation_register.errors.required`)),
                business_structure: Yup.string().required(t(`reservation_register.errors.required`)),
                total_price_override_sans_tax: Yup.string().required(t(`reservation_register.errors.required`)).trim(),
                customer_email: Yup.string()
                    .required(t(`reservation_register.errors.email_required`))
                    .email(t(`reservation_register.errors.email_syntax`)),
            }),
        });
        const getPurposeUseAll = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getListPurposeOfUseByCategory(`use-purpose-category`, 1);
                if (res?.data && res.data.length) {
                    usePurpose.value = res.data;
                }
            } catch (errors) {
                const error = errors.msg || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        getPurposeUseAll();
        const getCouponCustomerFilter = async (value) => {
            value = value.trim();
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getCouponCustomerFilterApi({ code: value });
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const submitForm = (e) => {
            e.preventDefault();
            isRequired(
                {
                    date: date.value,
                    plan_less_start_time: formTime.plan_less_start_time,
                    plan_less_end_time: formTime.plan_less_end_time,
                },
                error
            );
            handleSubmit(async (value) => {
                const data = {
                    ...value,
                    ...formTime,
                    ...{ totalNoVATFinal: 0 },
                    ...{ totalVATFinal: 0 },
                    ...{ moneyBeforeDiscount: 0 },
                    ...{ totalDiscountPrice: 0 },
                    ...{ vatDiscountPrice: 0 },
                    ...{ spacePriceVat: 0 },
                    ...{ totalNoVAT: 0 },
                    ...{ totalVAT: 0 },
                    ...{ codeCouponCustomer: 0 },
                    ...{ day: "" },
                };
                data.day = formatDate(date.value);
                data.totalNoVATFinal = totalNoVATFinal.value;
                data.totalVATFinal = totalVATFinal.value;
                data.moneyBeforeDiscount = moneyBeforeDiscount.value;
                data.totalDiscountPrice = totalDiscountPrice.value;
                data.vatDiscountPrice = vatDiscountPrice.value;
                data.spacePriceVat = spacePriceVat.value;
                data.totalNoVAT = totalNoVAT.value;
                data.totalVAT = totalVAT.value;
                data.codeCouponCustomer = codeCouponCustomer.value;
                dataForm.value = data;
                dataForm.value.use_purpose_category = String(dataForm.value.use_purpose_category);
                try {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                    const res = await getFilterCustomerByEmailApi({ email: value.customer_email });
                    dataCustomer.first_name = res.first_name || "";
                    dataCustomer.last_name = res.last_name || "";
                    dataCustomer.company_name = res.company_name || "";
                    dataCustomer.company_name_kana = res.company_name_kana || "";
                    dataCustomer.phone_number = res.phone_number || "";
                    dataCustomer.email = res.email || "";
                    if (res.status == 400) {
                        error.email_customer = res.msg;
                        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
                        return;
                    }
                    isForm.value = false;
                } catch (errors) {
                    const error = errors.message || t("common.has_error");
                    toast.error(error);
                }
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            })();
        };
        watch(
            date,
            () => {
                error.date = "";
            },
            {
                immediate: true,
            }
        );
        const handleUpdateTime = (value) => {
            formTime[value.key] = value.value;
            if (value.value) {
                error[value.key] = "";
            }
        };
        const formatDate = (data) => {
            const date = new Date(data);
            let month = "" + (date.getMonth() + 1);
            let day = "" + date.getDate();
            const year = date.getFullYear();
            day = day < 10 ? `0${day}` : day;
            return `${year}-${month < 10 ? `0${month}` : month}-${day}`;
        };

        return {
            people_count,
            date,
            numberPeople,
            usePurpose,
            totalNoVAT,
            totalVAT,
            moneyBeforeDiscount,
            totalVATFinal,
            totalNoVATFinal,
            errors,
            inject,
            submitForm,
            timePicker,
            time,
            formatDate,
            idSpace,
            dataForm,
            getCouponCustomerFilter,
            error,
            formTime,
            MessageErrors,
            handleUpdateTime,
            isConfirm,
            isForm,
            dataCustomer,
            spacePriceVat,
            handleCalculationPrice,
            total_price_override_sans_tax,
            vatDiscountPrice,
            totalDiscountPrice,
            limited_discount_price_sans_tax,
            handleCalculationDiscountSpecial,
            dataPrice,
            codeCouponCustomer,
            // information
            spaceTitle,
        };
    },
};
</script>

<style></style>
