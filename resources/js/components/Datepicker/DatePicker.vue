<template>
    <div class="flex h-8 border rounded mr-4">
        <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
            <i class="fa fa-calendar"></i>
        </div>
        <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
            {{ $t("list_user_manage_page.start_date") }}
        </div>
        <div class="flex items-center justify-center">
            <datepicker class="px-2 w-40 outline-none text-center" v-model="date" />
        </div>
    </div>
</template>
<script>
import { ref, computed, watch, inject } from "vue";
import Datepicker from "vue3-datepicker";
export default {
    components: {
        Datepicker,
    },
    props: {
        date: { type: Date, default: "" },
    },
};
</script>
