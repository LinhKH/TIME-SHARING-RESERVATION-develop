<template>
    <div class="flex flex-wrap" :class="customCss">
        <div class="w-64">
            <LabelRequired v-if="isRequired" />
            <i v-if="iconPrev" :class="iconPrev" aria-hidden="true"></i>
            <span v-if="labelText" class="font-bold">
                {{ labelText }}
            </span>
            <i v-if="icon" :class="icon" aria-hidden="true"></i>
        </div>
        <div class="flex-1">
            <slot></slot>
        </div>
    </div>
</template>

<script>
import LabelRequired from "@/components/LabelRequired";

export default {
    name: "LayoutInput",
    components: { LabelRequired },
    props: {
        labelText: {
            type: String,
            default: "",
        },
        icon: {
            type: String,
            default: "",
        },
        iconPrev: {
            type: String,
            default: "",
        },
        isRequired: {
            type: Boolean,
            default: false,
        },
        customCss: {
            type: String,
            default: "mt-2",
        },
    },
    data() {
        return {};
    },

    mounted() { },

    methods: {},
};
</script>

<style scoped></style>
