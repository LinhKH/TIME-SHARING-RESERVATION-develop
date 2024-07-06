<template>
    <div class="p-3">
        <StepCreateOrder />
        <div class="h-2 w-full" />
        <Suspense>
            <router-view v-if="!isLoading" :maxPlan="maxPlan" />
        </Suspense>
    </div>
</template>

<script>
import StepCreateOrder from "@/components/StepCreateOrder";
import { useRoute } from "vue-router";
import { MODULE_STORE, STEP_SPACE_CREATED } from "@/const";
import { useStore } from "vuex";
import { getCurrentStep } from "@/api";
import { useI18n } from "vue-i18n";
import { ref, inject, onUnmounted } from "vue";

export default {
    name: "AddOrder",
    components: { StepCreateOrder },
    setup() {
        const route = useRoute();
        const store = useStore();
        const idSpace = route.params.id || route.query.id;
        const toast = inject("$toast");
        const maxPlan = ref(0);
        const { t } = useI18n();
        const isLoading = ref(true);
        const initData = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                if (
                    idSpace &&
                    !store.getters[
                    `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_STEP_SPACE_CREATED}`
                    ]
                ) {
                    const response = await getCurrentStep(idSpace);
                    if (response) {
                        store.commit(
                            `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
                            STEP_SPACE_CREATED[response.data.current_draft_step]
                        );
                        maxPlan.value = response.data?.max_rental_plans_count || 0;
                    }
                    if (response.data.rental_plan_id) {
                        store.commit(
                            `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_ID_PLAN}`,
                            response.data.rental_plan_id
                        );
                    }
                }
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                isLoading.value = false;
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        initData();
        onUnmounted(() => {
            console.log('onUnmounted');
            store.commit(
                `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
                null
            );
            store.commit(`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_ID_PLAN}`, null);
        });
        return { isLoading, maxPlan };
    },
};
</script>

<style scoped></style>
