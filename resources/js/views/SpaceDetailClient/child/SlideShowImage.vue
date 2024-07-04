<template>
  <div class="w-3/4 h-full bg-[#151515]">
    <div class="">
      <div class="w-full h-full relative">
        <img
          :src="imageShow.img"
          alt="SpaceDetailClient"
          class="p-2 w-full h-full object-contain"
          v-if="arrayImage.length"
        />
        <div class="w-full px-4 flex justify-between absolute top-[200px]">
          <div class="cursor-pointer" @click="changeSlides('prev')">❮</div>
          <div class="cursor-pointer" @click="changeSlides('next')">❯</div>
        </div>
      </div>
    </div>
    <div class="flex flex-nowrap gap-0 items-stretch">
      <div
        class="w-[20%] h-full object-contain mt-[16px] hover:cursor-pointer"
        v-for="(item, idx) in arrayImage"
        :key="item.id"
        :class="{ active: arrayImage.length && item.id == imageShow.id }"
        @click="selectImage(idx)"
      >
        <img :src="item.img" alt="" class="p-2 w-full h-full object-contain opacity-70" />
      </div>
    </div>
  </div>
</template>

<script>
import { computed } from "@vue/runtime-core";
import { ref } from "vue";
export default {
  name: "SlideShowImage",
  props: {
    information: {
      type: Object,
    },
  },
  setup(props) {
    const indexShow = ref(0);
    const arrayImage = computed(
      () =>
        props.information?.image?.map((c) => {
          return {
            id: c.id,
            img: c.path_image,
          };
        }) || []
    );
    const imageShow = computed(() => arrayImage.value[indexShow.value] || {});
    const changeSlides = (action) => {
      if (arrayImage.value.length) {
        switch (action) {
          case "prev":
            if (indexShow.value >= 1) {
              indexShow.value -= 1;
            }
            break;
          case "next":
            if (indexShow.value < arrayImage.value.length - 1) {
              indexShow.value += 1;
            }
            break;
        }
      }
    };
    const selectImage = (index) => {
      indexShow.value = index;
    };
    return {
      arrayImage,
      indexShow,
      imageShow,
      changeSlides,
      selectImage,
    };
  },
};
</script>

<style scoped>
.active {
  position: relative;
}
.active::before {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  content: "";
  background: rgba(2, 135, 74, 0.4);
}
</style>
