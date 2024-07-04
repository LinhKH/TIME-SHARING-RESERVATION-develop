<template>
    <div @click.self="onCloseModal" class="fixed z-10 top-0 left-0 w-full h-full"
        style="background-color: rgba(0, 0, 0, 0.4)">
        <div class="max-w-[700px] my-[4.75rem] bg-[#ffffff] rounded items-center m-auto">
            <div>
                <slot name="title"> </slot>
            </div>
            <div>
                <slot name="content"> </slot>
            </div>
            <div>
                <slot name="foot"> </slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Modal",
    setup(props, context) {
        const onCloseModal = () => {
            context.emit("closeModal");
        };
        return {
            onCloseModal,
        };
    },
};
</script>

<style></style>
