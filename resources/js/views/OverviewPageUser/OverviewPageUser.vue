<template>
    <div class="relative">
        <header-overview-user class="fixed top-0 left-0 right-0 z-20" />
        <content-overview-user class="pt-[150px] left-0 right-0" />
        <root-overview-user class="bottom-0 left-0" />
    </div>
</template>

<script>
import HeaderOverviewUser from "./ChildComponet/HeaderOverviewUser.vue";
import ContentOverviewUser from "./ChildComponet/ContentOverviewUser.vue";
import RootOverviewUser from "./ChildComponet/RootOverviewUser.vue";

export default {
    name: "OverviewPageUser",
    components: {
        HeaderOverviewUser,
        ContentOverviewUser,
        RootOverviewUser,
    },
    setup() {
        return {};
    },
};
</script>

<style scoped></style>
