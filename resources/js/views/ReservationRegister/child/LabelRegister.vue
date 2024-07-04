<template>
    <div class="w-full h-full flex mb-[10px]">
        <div v-if="icon">
            <i :class="icon" class="my-0.5"></i>
        </div>
        <div class="font-bold text-[12px] m-1">{{ label }}</div>
        <div v-if="condition">
            <div class="px-[10px] mx2 text-[#ffffff] bg-[#fe5457] text-center text-[12px] rounded">{{ condition }}</div>
        </div>
    </div>
</template>

<script>
export default {
    name: "LabelRegister",
    props: {
        label: String,
        condition: String,
        icon: String,
    },
};
</script>

<style></style>
