<template>
    <button :class="style" class="cursor-pointer border border-solid border-[#ccc] rounded" @click="$emit('click')">
        <i v-if="icon" :class="`mr-1 ${icon}`"></i>
        {{ text || "" }}
    </button>
</template>

<script>
export default {
    name: "ButtonCommon",
    emits: ["click"],
    props: { style: String, text: String, icon: String },
};
</script>
