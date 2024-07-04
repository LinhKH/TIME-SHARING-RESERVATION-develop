<template>
    <div class="fixed right-0 left-0 top-0 bottom-0 flex items-center justify-center z-50">
        <div class="absolute w-full h-full top-0 left-0 bg-[rgba(0,0,0,.1)]"></div>
        <clip-loader loader :loading="true" :color="`#2a8ab1`" :size="`100px`"></clip-loader>
    </div>
</template>

<script>
import ClipLoader from "vue-spinner/src/ClipLoader.vue";

export default {
    name: "SpinLoading",
    components: { ClipLoader },
};
</script>

<style></style>
