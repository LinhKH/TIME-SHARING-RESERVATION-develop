<template>
    <LayoutModal :isShowModal="isShowModal" @onClose="handleClose">
        <div class="w-[600px] bg-white rounded shadow">
            <div class="leading-7 break-words p-3 border-b border-solid border-[#ddd]">
                <span class="text-[18px]"> {{ $t("reservation_confirmation.requesting_cancellation.title") }}</span>
                <hr />
                <ButtonCommon :text="$t('reservation_confirmation.close_up')" :style="`p-[3px]`" @click="handleClose" />
                <ButtonCommon :text="$t('reservation_confirmation.requesting_cancellation.cancel')"
                    :style="`p-[3px] m-[2%]`" @click="hadleUpdateStatusReservation" />
            </div>
        </div>
    </LayoutModal>
</template>

<script>
import LayoutModal from "@/components/Layouts/LayoutModal.vue";
import { ref, inject } from "vue";
import ButtonCommon from "@/components/Buttons/ButtonCommon";
import { updatStatusReservation } from "@/api";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import { MODULE_STORE, ROUTER_PATH, STATUS_RESERVATION } from "@/const";
import { useI18n } from "vue-i18n";

export default {
    name: "ModalDenyRequest",
    props: {
        infoReservation: { type: Object, required: true },
    },
    components: { ButtonCommon, LayoutModal },
    emits: ["close"],
    setup(_, context) {
        const isShowModal = ref(true);
        const reason = ref();
        const router = useRouter();
        const { t } = useI18n();
        const store = useStore();
        const route = useRoute();
        const toast = inject("$toast");
        const handleClose = () => {
            isShowModal.value = false;
            context.emit("close");
        };
        const idReservation = route.query.idReservation;
        const hadleUpdateStatusReservation = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

                const status = STATUS_RESERVATION.PENDING;
                await updatStatusReservation(idReservation, { status });
                router.push(
                    `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.RESERVATIONS_CONFIRMATION}?idReservation=${idReservation}`
                );
                handleClose();
                context.emit("updateStatus");
            } catch (errors) {
                console.log(errors);
                return toast.error(t("common.has_error"));
            } finally {
                // store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };

        return { isShowModal, reason, handleClose, hadleUpdateStatusReservation };
    },
};
</script>
