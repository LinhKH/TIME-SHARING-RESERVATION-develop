<template>
    <div class="flex items-center">
        <div class="">
            <i class="fa fa-search mr-1" aria-hidden="true"></i>
            <span class="">
                {{ $t("list_user_manage_page.search_and_sort") }}
            </span>
        </div>
        <div class="border border-solid border-[#dbdbdb] h-full px-2 ml-2 rounded hover:bg-[#f1efef] cursor-pointer"
            @click="handleClick">
            <i v-if="!isShowIcon" class="fa fa-angle-double-down mr-1" aria-hidden="true"></i>
            <i v-else class="fa fa-angle-double-up mr-1" aria-hidden="true"></i>
            <span class="leading-8 select-none">
                {{ $t("list_user_manage_page.search_and_sort_functions") }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: "ButtonFilter",

    data() {
        return {
            isShowIcon: false,
        };
    },

    mounted() { },

    methods: {
        handleClick() {
            this.isShowIcon = !this.isShowIcon;
            this.$emit("clickBtn");
        },
    },
};
</script>

<style scoped></style>
