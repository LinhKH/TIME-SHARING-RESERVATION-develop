<template>
    <div>Page Home</div>
</template>

<script>
import { ROUTER_PATH } from "@/const";
import { useRoute, useRouter } from "vue-router";

export default {
    name: "Home",

    data() {
        return {};
    },

    mounted() { },

    methods: {},

    setup() {
        const router = useRouter();
        const route = useRoute();
        if (route.path === `${ROUTER_PATH.ADMIN}`) {
            router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.DASHBOARD}`);
        }
    }
};
</script>

<style scoped></style>
