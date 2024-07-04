<template>
    <div class="flex items-center cursor-pointer">
        <router-link :to="`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.DASHBOARD}`">
            <img :src="logoTimeSharing" alt="logoTimeSharing" class="w-4/5 h-4/5 object-contain" />
        </router-link>
    </div>
</template>

<script>
import logoTimeSharing from "@/assets/images/time_sharing_logo.png";
import { ROUTER_PATH } from "@/const";

export default {
    name: "Logo",
    components: {},
    setup() {
        return { ROUTER_PATH, logoTimeSharing };
    },
};
</script>

<style lang="scss" scoped></style>
