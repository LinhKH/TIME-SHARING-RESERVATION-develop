<template>
    <div class="max-w-[1200px] h-full m-auto">
        <div class="flex items-center justify-center py-[15px] mb-[50px]">
            <span class="font-semibold text-[30px]">{{ $t("reservation_register.title", { title: spaceTitle }) }}</span>
        </div>
        <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
            <div class="w-1/6">
                <label-register :label="$t(`reservation_register.label.type_reservation`)"
                    :condition="$t(`reservation_register.condition`)" />
            </div>
            <div>
                <div class="flex">
                    {{ convertType(dataForm.proxy_reservation_type) }}
                </div>
            </div>
        </div>
        <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
            <div class="w-1/6">
                <label-register :label="$t(`reservation_register.label.use_date`)"
                    :condition="$t(`reservation_register.condition`)" />
            </div>
            <div class="mb-1">
                {{ dataForm.day }}
            </div>
        </div>
        <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
            <div class="w-1/6">
                <label-register :label="$t(`reservation_register.label.time`)"
                    :condition="$t(`reservation_register.condition`)" />
            </div>
            <div class="mb-1">
                {{ dataForm.plan_less_start_time }}
            </div>
            <span class="mx-[20px] items-center">~</span>
            <div class="mb-1">
                {{ dataForm.plan_less_end_time }}
            </div>
        </div>

        <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
            <div class="w-1/6">
                <label-register :label="$t(`reservation_register.label.number_people`)"
                    :condition="$t(`reservation_register.condition`)" />
            </div>
            <div>{{ dataForm.people_count }} 名</div>
        </div>
        <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
            <div class="w-1/6">
                <label-register :label="$t(`reservation_register.label.use_type`)"
                    :condition="$t(`reservation_register.condition`)" />
            </div>
            <div>
                {{ convertBusiness(dataForm.business_structure) }}
            </div>
        </div>
        <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
            <div class="w-1/6">
                <label-register :label="$t(`reservation_register.label.purpose_use`)"
                    :condition="$t(`reservation_register.condition`)" />
            </div>
            <div>
                {{ getPurposeLabel(dataForm.use_purpose_category) }}
            </div>
        </div>
        <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
            <div class="w-1/6">
                <label-register :label="$t(`reservation_register.label.purpose_use_other`)"
                    :condition="$t(`reservation_register.condition`)" />
            </div>
            <div>
                {{ dataForm.use_purpose_for_other }}
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
                            <div disabled
                                class="bg-[#eeeeee] w-60 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50">
                                {{ dataForm.total_price_override_sans_tax }}
                            </div>
                        </div>
                        <span
                            class="h-8 flex items-center px-3 bg-[#eeeeee] rounded-tr-[4px] rounded-br-[4px] border border-[#ccc] text-[#555] text-[14px] text-[400]">{{
                                $t(`reservation_register.price.yen`) }}</span>
                        <span class="mx-4 p-1">{{ $t(`reservation_register.price.no_vat_price`) }} </span>
                        <span class="mx-4 p-1"> {{ dataForm.spacePriceVat }} {{
                            $t(`reservation_register.price.vat_price`) }}</span>
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
                            <span class="">{{ dataForm.totalNoVAT }}</span>
                            <span class="mx-8 p-1">{{ $t(`reservation_register.price.yen`) }}{{
                                $t(`reservation_register.price.no_vat_price`) }}</span>
                        </div>
                        <div class="w-full">
                            <span class="">{{ dataForm.totalVAT }}</span>
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
                        <input disabled v-model="dataForm.codeCouponCustomer"
                            class="bg-[#eeeeee] w-60 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                        <span class="mr-4 p-1">{{ $t(`reservation_register.price.discount`) }} </span>
                        {{ dataForm.vatDiscountPrice }}
                        <span class="mr-4 p-1">{{ $t(`reservation_register.price.discount_vat`) }} </span>
                        {{ dataForm.totalDiscountPrice }}
                        <span class="mr-4 p-1">{{ $t(`reservation_register.price.discount_total`) }} </span>
                    </div>
                </div>
                <div class="flex pb-[10px] my-[10px] item-center m-auto w-full border-b-2 border-gray-200">
                    <div class="w-1/5">
                        <label-register :label="$t(`reservation_register.price.money_discount`)" />
                    </div>
                    <div>
                        <div class="flex">
                            <input type="number" disabled v-model="dataForm.limited_discount_price_sans_tax"
                                name="limited_discount_price_sans_tax"
                                class="bg-[#eeeeee] w-60 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                                min="0" />
                            <span
                                class="flex items-center px-3 bg-[#eeeeee] rounded-tr-[4px] rounded-br-[4px] border border-[#ccc] text-[#555] text-[14px] text-[400]">
                                {{ $t(`reservation_register.price.key`) }}
                            </span>
                            <span class="p-1">{{ $t(`reservation_register.price.no_vat_price`) }} </span>
                            <span class="ml-4 p-1">{{ dataForm.moneyBeforeDiscount }} </span>
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
                            <span class="mx-8 p-1">{{ dataForm.totalNoVATFinal }}</span>
                            <span class="mx-8 p-1">{{ $t(`reservation_register.price.yen`) }}{{
                                $t(`reservation_register.price.no_vat_price`) }}</span>
                        </div>
                        <div class="w-full">
                            <span class="mx-8 p-1">{{ dataForm.totalVATFinal }}</span>
                            <span class="mx-8 p-1">{{ $t(`reservation_register.price.vat_price`) }}</span>
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
                            <input :value="dataCustomer.first_name" type="text" disabled
                                class="bg-[#eeeeee] w-60 h-8 px-2 rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                        </div>
                        <div class="mx-[15px]">
                            <div class="">{{ $t("reservation_register.information_customer.last_name") }}</div>
                            <input :value="dataCustomer.last_name" type="text" disabled
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
                        <input :value="dataCustomer.company_name" type="text" disabled
                            class="bg-[#eeeeee] w-60 h-8 px-2 rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                    </div>
                </div>
                <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                    <div class="w-1/5">
                        <label-register :label="$t(`reservation_register.information_customer.name_conpany_Kana`)"
                            :icon="`fa fa-font`" />
                    </div>
                    <div class="flex">
                        <input :value="dataCustomer.company_name_kana" type="text" disabled
                            class="bg-[#eeeeee] w-60 h-8 px-2 rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                    </div>
                </div>
                <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                    <div class="w-1/5">
                        <label-register :label="$t(`reservation_register.information_customer.email`)"
                            :condition="$t(`reservation_register.condition`)" :icon="`fa fa-envelope-o`" />
                    </div>
                    <div class="">
                        <input :value="dataCustomer.email" disabled type="text"
                            class="bg-[#eeeeee] w-60 h-8 px-2 border border-solid border-[#eeeeee] rounded outline-none text-[12px] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                    </div>
                </div>
                <div class="flex pb-[10px] my-[10px] w-full border-b-2 border-gray-200">
                    <div class="w-1/5">
                        <label-register :label="$t(`reservation_register.information_customer.phone`)"
                            :icon="`fa fa-phone`" />
                    </div>
                    <div class="flex">
                        <input :value="dataCustomer.phone_number" type="text" disabled
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
                {{ dataForm.total_price_override_sans_tax }}
                <div class="text-[12px]">{{ $t("reservation_register.note_text") }}</div>
                {{ dataForm.total_price_override_sans_tax }}
            </div>
        </div>
        <div class="flex pb-[10px] my-[10px] border-b-2 border-gray-200">
            <div class="w-1/6">
                <label-register :label="$t(`reservation_register.owner_person`)" />
            </div>
            <div class="">{{ $t(`reservation_register.person`) }}</div>
        </div>
        <div class="my-3 flex gap-4">
            <div @click="handleBackToChance"
                class="flex items-center justify-center w-[50%] h-full p-[18px] m-auto bg-[#aaa] cursor-pointer">
                <button class="text-[#fff] text-center">
                    {{ $t(`reservation_register.change_content`) }}
                </button>
            </div>
            <div @click="submitForm(dataForm)"
                class="flex items-center justify-center w-[50%] h-full p-[18px] m-auto bg-[#2ad6a3] cursor-pointer">
                <button class="text-[#fff] text-center">
                    {{ $t(`reservation_register.sure`) }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { useI18n } from "vue-i18n";
import { MODULE_STORE, ROUTER_PATH } from "@/const";
import { inject } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";
import LabelRegister from "@/views/ReservationRegister/child/LabelRegister.vue";
import { postReservationRegisterFromApi } from "@/api";

export default {
    name: "ConfirmReservationRegister",
    components: {
        LabelRegister,
    },
    props: {
        dataForm: Object,
        dataCustomer: Object,
        idSpace: [Number, String],
        listPurpose: Array,
        title: String,
    },
    setup(props, context) {
        const handleBackToChance = () => {
            context.emit("handleBack");
        };

        const store = useStore();
        const { t } = useI18n();
        const toast = inject("$toast");
        const route = useRoute();
        const router = useRouter();
        const spaceTitle = props.title;
        const convertType = (value) => {
            if (value == "web") {
                return value ? t("reservation_register.radio.web") : "";
            }
            if (value == "new_apply") {
                return value ? t("reservation_register.radio.phone") : "";
            }
            if (value == "extending") {
                return value ? t("reservation_register.radio.extern_phone") : "";
            }
        };
        const convertBusiness = (val) => {
            if (val == "organization") {
                return val ? t("reservation_register.radio.company") : "";
            }
            if (val == "indivisual") {
                return val ? t("reservation_register.radio.your_self") : "";
            }
        };
        const postReservationRegister = async (id, params, data) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await postReservationRegisterFromApi(id, params);

                router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATION_REGISTER_RESERVED}?id=${res.reservation_id}`);
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const submitForm = (data) => {
            const dataSubmit = { ...props.dataForm };

            postReservationRegister(props.idSpace, dataSubmit, data);
        };
        const getPurposeLabel = (id) => {
            return props.listPurpose?.find((c) => c.id == id)?.title_ja || "";
        };

        return { handleBackToChance, submitForm, convertBusiness, convertType, getPurposeLabel, spaceTitle };
    },
};
</script>

<style></style>
