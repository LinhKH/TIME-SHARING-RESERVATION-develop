<template>
    <ModalCommon>
        <div class="w-[400px] p-6 bg-white shadow m-auto">
            <div v-if="infoReservation.status === 'pending-approval-from-owner'" class="">
                {{ $t("reservation_confirmation.approve_the_reservation") }}
            </div>
            <div v-else class="">{{ $t("reservation_confirmation.approve_the_reservation_step_2") }}</div>
            <div class="flex justify-end mt-5">
                <button class="p-2 hover:bg-[#efefef]" @click="$emit('close')">
                    {{ $t("reservation_confirmation.close_up") }}
                </button>
                <button class="p-2 hover:bg-[#efefef]"
                    @click="() => hadleUpdateStatusReservation(infoReservation.status)">
                    {{ $t("reservation_confirmation.approve") }}
                </button>
            </div>
        </div>
    </ModalCommon>
</template>

<script>
import ModalCommon from "@/components/ModalCommon";
import { updatStatusReservation } from "@/api";
import { useStore } from "vuex";
import { inject, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { MODULE_STORE, STATUS_RESERVATION, ROUTER_PATH } from "@/const";
import { useI18n } from "vue-i18n";

export default {
    name: "ModalConfirmApprove",
    props: {
        infoReservation: { type: Object, required: true },
    },
    components: { ModalCommon },
    emits: ["close", "updateStatus"],

    setup(props, context) {
        const store = useStore();
        const route = useRoute();
        const router = useRouter();

        const { t } = useI18n();
        const toast = inject("$toast");
        const idReservation = route.query.idReservation;
        const reason = ref();

        const hadleUpdateStatusReservation = async (status) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                if (status === "waiting-for-card-information-input") {
                    reason.value = STATUS_RESERVATION.COMPLETED;
                } else {
                    reason.value = STATUS_RESERVATION.WAITING;
                }

                await updatStatusReservation(idReservation, { status: reason.value });
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

        return { hadleUpdateStatusReservation };
    },
};
</script>
