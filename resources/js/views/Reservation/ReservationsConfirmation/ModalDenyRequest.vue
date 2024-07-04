<template>
    <LayoutModal :isShowModal="isShowModal" @onClose="handleClose">
        <div class="w-[600px] bg-white rounded shadow">
            <div class="text-[18px] leading-7 break-words p-3 border-b border-solid border-[#ddd]">
                {{ $t("reservation_confirmation.deny_the_reservation_request") }}
            </div>
            <div class="p-3">
                <div class="mb-2">
                    <LabelRequired />
                    <span> {{ $t("reservation_confirmation.rejection_reason") }}</span>
                </div>
                <InputRadio name="test" @onInput="(value) => (reason = value)" />
                <div class="font-bold my-2">{{ $t("reservation_confirmation.messages_to_users") }}</div>
                <InputArea class="w-full mb-2" rows="4" :placeholder="$t('reservation_confirmation.placeholder')" />
                <div class="flex">
                    <ButtonCommon :text="$t('reservation_confirmation.close_up')" :style="`p-2 mr-1`"
                        @click="handleClose" />
                    <ButtonCommon :text="$t('reservation_confirmation.deny_request')" :style="`p-2 mr-1`"
                        @click="hadleUpdateStatusReservation()" />
                </div>
            </div>
        </div>
    </LayoutModal>
</template>

<script>
import LayoutModal from "@/components/Layouts/LayoutModal.vue";
import { ref, inject } from "vue";
import LabelRequired from "@/components/LabelRequired";
import InputRadio from "./InputRadio.vue";
import InputArea from "@/components/Form/InputArea.vue";
import ButtonCommon from "@/components/Buttons/ButtonCommon";
import { MODULE_STORE, STATUS_RESERVATION, ROUTER_PATH } from "@/const";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { updatStatusReservation } from "@/api";

export default {
    name: "ModalDenyRequest",
    components: { ButtonCommon, LayoutModal, LabelRequired, InputRadio, InputArea },
    emits: ["close", "updateStatus"],
    setup(_, context) {
        const isShowModal = ref(true);
        const reason = ref();
        const route = useRoute();
        const router = useRouter();
        const store = useStore();
        const { t } = useI18n();
        const toast = inject("$toast");
        const handleClose = () => {
            isShowModal.value = false;
            context.emit("close");
        };

        const idReservation = route.query.idReservation;
        const hadleUpdateStatusReservation = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

                const status = STATUS_RESERVATION.REQUESTING_CANCELLATION;
                await updatStatusReservation(idReservation, { status });
                router.push(
                    `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.RESERVATIONS_CONFIRMATION}?idReservation=${idReservation}`
                );

                context.emit("close");
                context.emit("updateStatus");
            } catch (errors) {
                return toast.error(t("common.has_error"));
            } finally {
                // store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };

        return { isShowModal, reason, handleClose, hadleUpdateStatusReservation };
    },
};
</script>
