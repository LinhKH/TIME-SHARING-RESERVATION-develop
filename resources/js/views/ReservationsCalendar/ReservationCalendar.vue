<template>
    <div class="max-w-[1200px] h-full mx-auto relative">
        <div class="w-full bg-[#555] items-center py-[4px] px-[10px]">
            <router-link :to="backPage">
                <div class="w-full h-full py-[10px] text-center text-[#fff] text-[20px] leading-6">
                    {{ $t("reservation_calendar.label") }}
                </div>
            </router-link>
        </div>
        <div class="w-full p-[5px]">
            <div class="flex items-center justify-between">
                <div class="w-full h-full px-[16px] text-left cursor-pointer" @click="prev">
                    <i class="fa fa-chevron-left text-[24px] text-[#fc5759]"></i>
                </div>
                <div class="w-full h-full px-[5px] text-center">
                    <span class="text-[24px] text-[#b7b7b9]">
                        {{ currentYear }}
                        {{ $t("reservation_calendar.year") }}
                        {{ currentMonthInNumber }}
                        {{ $t("reservation_calendar.month") }}
                    </span>
                </div>
                <div class="w-full h-full px-[16px] text-right cursor-pointer" @click="next">
                    <i class="fa fa-chevron-right text-[#fc5759] text-[24px]"></i>
                </div>
            </div>
            <div class="w-full h-full flex items-center ]">
                <div class="w-[14.28%] text-[14px] p-[8px] text-center" v-for="(day, index) in days" :key="index">
                    {{ day }}
                </div>
            </div>
            <div class="w-full h-full">
                <div class="flex flex-wrap items-stretch">
                    <div class="w-[14.28%] h-full text-center" v-for="day in startDay()" :key="day"></div>
                    <div class="w-[14.28%] h-full text-center cursor-pointer hover:bg-[#ddd] border-solid border-[1px] border-[#ddd]"
                        v-for="date in daysInMonth(currentYear, currentMonthInNumber)" :key="date" ref="date"
                        @click="getDate">
                        <div class="h-[50px] relative">
                            <div class="absolute top-0 left-0 p-[6px]">
                                {{ date }}
                            </div>
                            <i class="fa fa-circle-o text-[#626262] items-center absolute top-[50%]"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div></div>
        <teleport to="body">
            <modal v-if="isShowModal" @closeModal="getDate">
                <template v-slot:title>
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray break-all">
                            {{ $t("reservation_calendar.modal.modal_lable") }}
                        </h3>
                        <button @click="getDate" class=" text-gray-900 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <span>X</span>
                        </button>
                    </div>
                </template>
                <template v-slot:content>
                    <div class="p-6 space-y-6">
                        <p class="text-base leading-relaxed break-all">
                            {{ $t("reservation_calendar.modal.sub_lable") }}
                        </p>
                    </div>
                </template>
                <template v-slot:foot>
                    <div class="flex items-center p-6 space-x-2 rounded-b break-all">
                        <button @click="onModalConfirm" class=" text-white bg-blue-600 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            {{ $t("reservation_calendar.modal.close_reservation") }}
                        </button>
                        <button @click="getDate" class=" text-white bg-blue-600 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            {{ $t("reservation_calendar.modal.set_unavailable") }}
                        </button>
                    </div>
                </template>
            </modal>
        </teleport>
        <teleport to="body">
            <modal v-if="isShowModalConfirm" @closeModal="onModalConfirm">
                <template v-slot:content>
                    <div class="p-6 space-y-6">
                        <p class="text-base leading-relaxed break-all">{{ $t("reservation_calendar.modal.Want_to_block")
                            }}</p>
                    </div>
                </template>
                <template v-slot:foot>
                    <div class="flex items-center p-6 space-x-2 rounded-b break-all">
                        <button @click="onConfirmFinal" class=" text-white bg-blue-600 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            {{ $t("reservation_calendar.modal.access") }}
                        </button>
                        <button @click="onModalConfirm" class=" text-white bg-blue-600 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            {{ $t("reservation_calendar.modal.cancel") }}
                        </button>
                    </div>
                </template>
            </modal>
        </teleport>
        <teleport to="body">
            <modal v-if="isConfirmFinal" @closeModal="onConfirmFinal">
                <template v-slot:content>
                    <div class="p-6 space-y-6">
                        <p class="text-centers leading-relaxed break-all whitespace-pre-line">
                            {{ $t("reservation_calendar.modal.access_commit") }}
                        </p>
                    </div>
                </template>
                <template v-slot:foot>
                    <div class="flex items-center p-6 space-x-2 rounded-b break-all">
                        <button @click="onConfirmFinal" class=" text-white bg-blue-600 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            OK
                        </button>
                    </div>
                </template>
            </modal>
        </teleport>
        <div class="w-full pt-[50px]]">
            <div class="flex justify-end py-[6px]">
                <div class="text-[14px] mx-2">
                    <i class="fa fa-circle-o text-[#626262]"></i>
                    <span class="ml-1 text-[#626262]">{{ $t("reservation_calendar.reserve_now") }}</span>
                </div>
                <div class="text-[14px] mx-2">
                    <i class="fa fa-caret-up text-[#626262]"></i>
                    <span class="ml-1 text-[#626262]">{{ $t("reservation_calendar.time_reservation") }}</span>
                </div>
                <div class="text-[14px] mx-2">
                    <i class="fa fa-remove text-[#626262]"></i>
                    <span class="ml-1 text-[#626262]">{{ $t("reservation_calendar.dont_access_reserve") }}</span>
                </div>
                <div class="text-[14px] mx-2">
                    <i class="fa fa-star-o text-[#626262]"></i>
                    <span class="ml-1 text-[#626262]">{{ $t("reservation_calendar.required") }}</span>
                </div>
            </div>
        </div>
        <div v-if="showSelectRegister">
            <div class="flex justify-end items-center mx-[20px]">
                <button @click="handleShowAllCheck"
                    class="h-full text-[14px] text-[#ffffff] bg-[#97d077] p-[5px] items-center rounded">
                    {{ $t("reservation_calendar.text_button") }}
                </button>
            </div>
            <div class="w-full flex justify-center mt-[12px]">
                <check-plan-in-week :isCheck="ShowAllCheckRegister"
                    @ShowAllCheckRegister="ShowAllCheckRegister = true" />
                <check-plan-money :isCheck="ShowAllCheckRegister" @ShowAllCheckRegister="ShowAllCheckRegister = true" />
            </div>
            <div v-if="ShowAllCheckRegister" class="w-full m-auto border-t-2 border-solid border-[#626262] my-3">
                <div class=" py-[10px] px-[30px] text-[20px] mt-[5px] arounded text-[#ffffff] items-center text-center bg-[#31B11D] cursor-pointer" @click="onConfirmFinal">
                    {{ $t("reservation_calendar.no_inform") }}
                </div>
                <div class=" py-[10px] px-[30px] text-[20px] mt-[5px] arounded text-[#ffffff] items-center text-center bg-[#f16a99] cursor-pointer" @click="onConfirmFinal">
                    {{ $t("reservation_calendar.set_unavailable") }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ROUTER_PATH } from "@/const";
import { ref } from "vue";
import Modal from "./child/Modal.vue";
import CheckPlanInWeek from "./child/CheckPlanInWeek.vue";
import CheckPlanMoney from "./child/CheckPlanMoney.vue";
export default {
    components: { Modal, CheckPlanInWeek, CheckPlanMoney },
    name: "ReservationCalendar",
    setup() {
        const backPage = `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}`;
        const days = ["日", "月", "火", "水", "木", "金", "土"];
        const currentMonthInNumber = ref(new Date().getMonth());
        const currentYear = ref(new Date().getFullYear());
        const showModal = ref(false);
        const showWantToBlock = ref(false);
        const showSelectRegister = ref(false);
        const ShowAllCheckRegister = ref(false);
        const isShowModal = ref(false);
        const isShowModalConfirm = ref(false);
        const isConfirmFinal = ref(false);

        const daysInMonth = (year, month) => {
            return new Date(year, month, 0).getDate();
        };
        const startDay = () => {
            return new Date(currentYear.value, currentMonthInNumber.value, 1).getDay();
        };
        const next = () => {
            if (currentMonthInNumber.value === 12) {
                currentYear.value++;
                currentMonthInNumber.value = 1;
            } else {
                currentMonthInNumber.value++;
            }
        };
        const prev = () => {
            if (currentMonthInNumber.value === 1) {
                currentYear.value--;
                currentMonthInNumber.value = 12;
            } else {
                currentMonthInNumber.value--;
            }
        };
        const getDate = () => {
            isShowModal.value = !isShowModal.value;
            showSelectRegister.value = true;
        };
        const handleDelModal = () => {
            showModal.value = false;
        };
        const handleSetUnavailable = () => {
            showModal.value = false;
        };
        const handleShowWantToBlock = () => {
            showWantToBlock.value = true;
        };
        const handleShowAllCheck = () => {
            ShowAllCheckRegister.value = !ShowAllCheckRegister.value;
        };
        const onModalConfirm = () => {
            isShowModal.value = false;
            isShowModalConfirm.value = !isShowModalConfirm.value;
        };
        const onConfirmFinal = () => {
            isShowModalConfirm.value = false;
            isConfirmFinal.value = !isConfirmFinal.value;
        };
        const handleFocusSelect = () => { };
        return {
            backPage,
            days,
            currentMonthInNumber,
            currentYear,
            isShowModal,
            isShowModalConfirm,
            isConfirmFinal,
            daysInMonth,
            startDay,
            next,
            prev,
            getDate,
            showModal,
            handleDelModal,
            handleSetUnavailable,
            handleShowWantToBlock,
            showSelectRegister,
            ShowAllCheckRegister,
            handleShowAllCheck,
            handleFocusSelect,
            onModalConfirm,
            onConfirmFinal,
        };
    },
};
</script>

<style></style>