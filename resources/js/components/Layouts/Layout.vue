<template>
    <Header :isShowHeader="isShowHeader" />
    <div class="flex w-full">
        <div class="w-[14%]">
            <SideBar />
        </div>
        <div class="flex-1">
            <slot></slot>
        </div>
    </div>
</template>
<script>
import Header from "@/components/Header";
import SideBar from "@/components/SideBar";

export default {
    name: "Home",
    components: { Header, SideBar },
    setup() {
        const isShowHeader = true;
        return {
            isShowHeader,
        };
    },
};
</script>
