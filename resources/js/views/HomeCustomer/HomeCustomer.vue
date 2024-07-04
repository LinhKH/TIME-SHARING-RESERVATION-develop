<template>
    <div></div>
</template>

<script>
import { ROUTER_PATH } from "@/const";

export default {
    name: "HomeCustomer",
    created() {
        this.$router.push(ROUTER_PATH.OVERVIEW_USER);
    },
};
</script>

<style scoped></style>
