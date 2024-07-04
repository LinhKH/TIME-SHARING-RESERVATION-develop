<template>
    <div v-if="isShowModal" class="fixed top-0 left-0 right-0 bottom-0">
        <div @click="handleClose" class="absolute w-full h-full top-0 left-0 bg-[rgba(0,0,0,0.5)]"></div>
        <div class="absolute rounded left-1/2 -translate-x-1/2 -translate-y-1/2 -top-1/2 slipUp" :class="customCss"
            ref="modalBody">
            <slot></slot>
        </div>
    </div>
</template>
<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { ref } from "vue";

export default {
    name: "ModalPlanInterval",
    props: {
        isShowModal: { type: Boolean, default: false },
        customCss: String,
    },
    emits: ["onClose"],
    components: { LayoutInput },
    setup(props, context) {
        const modalBody = ref(null);
        const handleClose = () => {
            modalBody.value.classList.remove("slipUp");
            modalBody.value.classList.add("slipDown");
            setTimeout(() => {
                context.emit("onClose");
            }, 300);
        };
        return {
            handleClose,
            modalBody,
        };
    },
};
</script>
<style scoped>
@keyframes slipUpAnimation {
    to {
        top: 50%;
    }
}

@keyframes slipDownAnimation {
    from {
        top: 50%;
    }

    to {
        top: -50%;
    }
}

.slipUp {
    animation: slipUpAnimation linear 0.3s;
    animation-fill-mode: forwards;
}

.slipDown {
    animation: slipDownAnimation linear 0.3s;
}
</style>
