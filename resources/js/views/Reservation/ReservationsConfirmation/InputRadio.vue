<template>
    <div v-for="(item, index) in optionRadioDenyReservation" :key="index" class="mb-1">
        <input type="radio" class="mr-1" :value="item.value" v-model="value" />
        <label for="">{{ item.label }}</label>
    </div>
    <InputText :disabled="isDisabledInput" class="w-full h-9" :placeholder="$t('reservation_confirmation.please_state')"
        @input="(event) => $emit('onInput', event.target.value)" />
</template>

<script>
import { watch, ref } from "vue";
import InputText from "@/components/Form/InputText.vue";
export default {
    name: "InputRadio",
    emits: ["onInput"],
    components: { InputText },
    props: {
        name: String,
    },
    setup(props, context) {
        const optionRadioDenyReservation = [
            {
                label: "先約があったため",
                value: "1",
            },
            {
                label: "休業日の設定ができていなかったため",
                value: "2",
            },
            {
                label: "プラン登録にミスがあったため",
                value: "3",
            },
            {
                label: "閉店予定のため",
                value: "4",
            },
            {
                label: "ご希望の用途では利用できないため",
                value: "5",
            },
            {
                label: "ご希望の条件と合わないため",
                value: "6",
            },
            {
                label: "ユーザーの予約内容が変更になったため",
                value: "7",
            },
            {
                label: "ユーザーへの連絡がつかないため",
                value: "8",
            },
            {
                label: "その他",
                value: "0",
            },
        ];
        const value = ref(optionRadioDenyReservation[0].value);
        const isDisabledInput = ref(true);
        watch(
            value,
            () => {
                if (value.value != 0) {
                    isDisabledInput.value = true;
                    context.emit("onInput", value.value);
                } else {
                    context.emit("onInput", "");
                    isDisabledInput.value = false;
                }
            },
            { immediate: true }
        );

        return { isDisabledInput, optionRadioDenyReservation, value };
    },
};
</script>

<style lang="scss" scoped></style>
