<template>
    <div class="fixed top-0 left-0 right-0 bottom-0 z-40">
        <div class="absolute w-full h-full bg-[rgba(0,0,0,.3)] flex">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: "ModalCommon",
};
</script>
