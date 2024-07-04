<template>
    <div class="w-full h-full">
        <div class="w-full h-full mt-[12px]">
            <div class="flex">
                <div class="w-[16.67%] mb-[5px] font-bold">{{ $t("rentail_detail.title") }}</div>
                <div class="w-full">
                    <div class="mb-[5px]">
                        <i :class="icon" class="mr-1 font-bold"></i>
                        <span class="font-bold"> {{ $t(`page_and_message.${title}`) }}</span>
                    </div>
                    <div class="my-[10px]">{{ $t(`sub_title_page_and_message.${title}`) }}</div>
                </div>
            </div>
            <div class="flex">
                <div class="w-[16.67%] mb-[5px] font-bold">{{ $t("rentail_detail.content") }}</div>
                <div class="w-full h-full flex border-2 border-gray-200">
                    <div class="h-auto py-[6px] px-[12px] bg-gray-300 border-r-2 border-gray-200">
                        <img :src="JapanIcon" class="w-6 h-6" alt="image" />
                    </div>
                    <textarea @input="resize" ref="textarea" v-model="textareaDetail"
                        class="w-full h-auto break-all p-2 whitespace-pre-line overflow-hidden outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50">
                    </textarea>
                </div>
            </div>
        </div>
        <div class="w-full h-full flex justify-center mt-[6px]">
            <button
                class="block w-fit p-2 bg-[#ffbd00] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
                @click="handleClick">
                {{ $t("rentail_detail.button") }}
            </button>
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import JapanIcon from "@/assets/images/japan.png";
export default {
    props: {
        title: String,
        textareaDetail: String,
    },
    emits: ["submit"],
    setup(props, context) {
        const handleClick = () => {
            context.emit("submit", props.textareaDetail);
        };
        const icon = ref(null);
        const listIcon = {
            term_of_use: "fa fa-check",
            cancellation_policy: "fa fa-times",
            prohibited_matter: "fa fa-question-circle",
            faq: "fa fa-newspaper-o",
            notices: "fa fa-ban",
            note_from_space: "fa fa-list-ul",
            questions_from_space: "fa fa-question-circle",
            reservation_creation: "fa fa-plus-circle",
            reservation_after_payment: "fa fa-money",
            tomorrows_reminder: "fa fa-star",
        };
        const textarea = ref(null);
        const resize = () => {
            textarea.value.style.height = "18px";
            textarea.value.style.height = textarea.value.scrollHeight + "px";
        };
        onMounted(() => {
            icon.value = listIcon[props.title];
            resize();
        });
        return { JapanIcon, handleClick, textarea, resize, icon };
    },
};
</script>

<style></style>
