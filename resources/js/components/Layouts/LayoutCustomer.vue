<template>
    <SpinLoading v-if="isLoading" />
    <router-view></router-view>
</template>

<script>
import SpinLoading from "@/components/SpinLoading";
import { computed } from "vue";
import { useStore } from "vuex";
import { MODULE_STORE } from "@/const";

export default {
    name: "LayoutCustomer",
    components: { SpinLoading },
    setup() {
        const store = useStore();
        const isLoading = computed(
            () => store.getters[`${MODULE_STORE.COMMON.NAME}/${MODULE_STORE.COMMON.GETTERS.GET_IS_LOADING}`]
        );
        return { isLoading };
    },
};
</script>

<style scoped></style>
