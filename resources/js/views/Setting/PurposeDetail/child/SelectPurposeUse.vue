<template>
  <div
    class="w-full border border-solid border-[#ddd] rounded flex justify-start items-center h-8"
    @click="toggleListOption"
  >
    <span
      v-for="(equipmentInfoItem, index) in listEquipmentInfo"
      :key="index"
      @click="closeEquipmentInfo($event, equipmentInfoItem)"
      class="transition-all hover:bg-[#aba6a6] border border-solid border-[#aaa] bg-[#e4e4e4] rounded py-[2px] pr-[16px] flex justify-center items-center ml-[8px] cursor-pointer relative"
    >
      <i class="fa fa-close px-[5px]"></i
      >{{ equipmentInfoItem.title_ja || equipmentInfoItem.title_en || equipmentInfoItem.title_jp }}
    </span>
  </div>
  <div
    v-if="isListOption"
    class="border border-solid border-[#ddd] w-full mt-[2px] rounded transition-all absolute bottom-[100%] bg-[#fff] z-10 shadow"
  >
    <ul v-for="(equipmentList, indexEquipmentList) in Object.keys(optionEquipment)" :key="indexEquipmentList">
      <li class="px-1 py-3 font-bold">
        {{ equipmentList }}
      </li>
      <div v-for="(equipmentItem, indexEquipmentItem) in optionEquipment[equipmentList]" :key="indexEquipmentItem">
        <li
          @click="handleOption(equipmentItem)"
          class="p-3 list-none cursor-pointer hover:bg-[#e5cce1] transition-all"
          v-if="equipmentItem.active === 2"
        >
          {{ equipmentItem.title_ja || equipmentItem.title_en || equipmentItem.title_jp }}
        </li>
      </div>
    </ul>
  </div>
</template>

<script>
import { useI18n } from "vue-i18n";
import { ref, watch, watchEffect } from "vue";

export default {
  name: "SelectPurposeUse",
  props: {
    optionEquipment: Object,
    formData: Object,
  },
  emits: ["updateModelValue"],
  setup(props, context) {
    const { t } = useI18n();
    const isListOption = ref(false);
    const listEquipmentInfo = ref([]);
    const toggleListOption = () => {
      isListOption.value = !isListOption.value;
    };
    watch(
      () => listEquipmentInfo,
      () => {
        context.emit("updateModelValue", listEquipmentInfo.value);
      },
      { immediate: true, deep: true }
    );
    watchEffect(() => {
      if (props.formData.length && props.optionEquipment) {
        props.formData.forEach((itemFormData) => {
          Object.values(props.optionEquipment).forEach((itemOptionEquipment) => {
            itemOptionEquipment.forEach((item) => {
              if (item.id == itemFormData) {
                listEquipmentInfo.value = [...listEquipmentInfo.value, item];
              }
            });
          });
        });
      }
    });
    const handleOption = (valueTitle) => {
      if (listEquipmentInfo.value.length) {
        let check = true;
        for (let index = 0; index < listEquipmentInfo.value.length; index++) {
          if (listEquipmentInfo.value[index].id == valueTitle.id) {
            listEquipmentInfo.value.splice(index, 1);
            check = false;
            break;
          }
        }
        if (check) {
          listEquipmentInfo.value.push(valueTitle);
        }
      } else {
        listEquipmentInfo.value.push(valueTitle);
      }
      isListOption.value = false;
    };
    const closeEquipmentInfo = (event, valueEquipmentInfo) => {
      event.stopPropagation();
      if (listEquipmentInfo.value.length) {
        listEquipmentInfo.value.forEach((item, index) => {
          if (item === valueEquipmentInfo) {
            listEquipmentInfo.value.splice(index, 1);
          }
        });
      }
    };
    return {
      isListOption,
      toggleListOption,
      listEquipmentInfo,
      handleOption,
      closeEquipmentInfo,
    };
  },
};
</script>

<style></style>
