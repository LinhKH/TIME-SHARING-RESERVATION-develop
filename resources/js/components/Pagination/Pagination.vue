<template>
    <div v-if="totalPage > 1" class="w-full flex justify-center mt-3">
        <div v-if="isShowPrev" class="px-2 py-1 bg-[#ddd] rounded cursor-pointer hover:opacity-60"
            @click="handleBack(pageCurrent - 1)">
            Prev
        </div>
        <div v-for="(item, index) in convertPage" :key="index"
            class="px-2 py-1 bg-[#ddd] rounded ml-1 cursor-pointer hover:opacity-60"
            :class="item == pageCurrent && 'bg-[#2a8ab1] text-white'" @click="() => handleChangePage(item)">
            {{ item }}
        </div>
        <div v-if="isShowNext" class="px-2 py-1 bg-[#ddd] rounded ml-1 cursor-pointer hover:opacity-60"
            @click="handleNext(pageCurrent + 1)">
            Next
        </div>
    </div>
</template>

<script>
import { watchEffect, ref } from "vue";
import { boolean } from "yup/lib/locale";

export default {
    name: "Pagination",
    props: {
        pageCurrent: Number,
        totalPage: Number,
        isShowPrev: boolean,
        isShowNext: boolean,
    },
    emits: ["onBack", "onNext"],
    setup(props, context) {
        const convertPage = ref([]);

        const addNext = (pageCurrent) => {
            if (pageCurrent + 3 <= props.totalPage) {
                for (let index = pageCurrent; index <= pageCurrent + 3; index++) {
                    if (index == pageCurrent + 2) {
                        convertPage.value.push("...");
                        continue;
                    }
                    if (index == pageCurrent + 3) {
                        convertPage.value.push(props.totalPage);
                        continue;
                    }
                    convertPage.value.push(index);
                }
                return;
            }
            for (let index = pageCurrent; index <= props.totalPage; index++) {
                convertPage.value.push(index);
            }
        };
        const addPrev = (pageCurrent) => {
            if (pageCurrent - 3 >= 1) {
                for (let index = pageCurrent; index >= pageCurrent - 3; index--) {
                    if (index == pageCurrent - 2) {
                        convertPage.value.unshift("...");
                        continue;
                    }
                    if (index == pageCurrent - 3) {
                        convertPage.value.unshift(1);
                        continue;
                    }
                    convertPage.value.unshift(index);
                }
                return;
            }
            for (let index = pageCurrent; index >= 1; index--) {
                convertPage.value.unshift(index);
            }
        };
        watchEffect(() => {
            convertPage.value = [];
            if (props.totalPage <= 5) {
                for (let index = 0; index < props.totalPage; index++) {
                    convertPage.value[index] = index + 1;
                }
            } else {
                convertPage.value.push(props.pageCurrent);
                addNext(props.pageCurrent + 1);
                addPrev(props.pageCurrent - 1);
            }
        });

        const handleBack = (page) => {
            context.emit("onBack", page);
        };
        const handleNext = (page) => {
            context.emit("onNext", page);
        };
        const handleChangePage = (page) => {
            if (Number(page) == NaN) {
                return;
            }
            if (Number(page) > props.pageCurrent) {
                handleNext(Number(page));
            }
            if (Number(page) < props.pageCurrent) {
                handleBack(Number(page));
            }
        };
        return { handleBack, handleNext, handleChangePage, convertPage };
    },
};
</script>

<style scoped></style>
