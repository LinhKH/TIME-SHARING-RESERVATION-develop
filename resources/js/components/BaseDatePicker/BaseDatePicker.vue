<template>
    <div class="flex items-center">
        <div class="flex h-8 border rounded mr-4">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
                <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
                <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="datePicker.start" />
            </div>
        </div>
        <div class="py-[6px] px-[12px]">〜</div>
        <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
                <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
                <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="datePicker.end" />
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from "vue3-datepicker";
export default {
    name: "BaseDatePicker",
    components: {
        Datepicker,
    },
    props: {
        datePicker: Object,
    },
    setup() {
        const datePicker = {
            start: "",
            end: "",
        };
        return { datePicker };
    },
};
</script>

<style></style>
