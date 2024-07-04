<template>
    <div>
        <ul
            class="flex justify-content-start align-items-center border-b border-solid border-[#ddd] pt-2.5 pl-2.5 mb-[5px]">
            <router-link v-for="(item, index) in listMenus" :key="index" :to="{ name: item.routeName }">
                <span class="block py-2.5 px-4 cursor-pointer bg-white"><i
                        class="mr-1 text-[14px] item_icon text-[#337ab7]" :class="[item.icon]"></i>
                    <span class="item_text text-[#337ab7]">
                        {{ item.text }}
                    </span>
                </span>
            </router-link>
        </ul>
        <router-view></router-view>
    </div>
</template>

<script>
import { ref } from "vue";
export default {
    name: "MenuForm",
    props: {
        listMenus: {
            type: Array,
            default: () => [],
        },
    },
};
</script>

<style scoped>
.router-link-active {
    margin-bottom: -1px;
}

.router-link>span {
    border-top-left-radius: 0.25rem;
    /* 4px */
    border-top-right-radius: 0.25rem;
    /* 4px */
}

.router-link-active>span {
    border: 1px solid #ddd;
    border-top-left-radius: 0.25rem;
    /* 4px */
    border-top-right-radius: 0.25rem;
    /* 4px */
    color: #555;
    border-bottom: transparent;
}

.router-link-active .item_icon,
.router-link-active .item_text {
    color: #555;
}
</style>
