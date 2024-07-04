<template>
  <LayoutForm :title="$t('equipment_information_components.general_equipment')">
    <LayoutInput
      v-for="(item, index) in listFormGeneralEquipment"
      :key="index"
      customCss="mt-5"
      :labelText="item.label"
      :isRequired="item.isRequired"
    >
      <template v-if="item.type === 'radio'">
        <div class="flex">
          <div v-for="(option, index) in item.options" class="flex items-center h-[15px]" :key="index">
            <input
              type="radio"
              :id="`${item.name}_${index}`"
              :value="option.value"
              v-model.lazy="modelValue[item.name]"
            />
            <label :for="`${item.name}_${index}`" class="ml-1 mr-4 font-bold">{{ option.label }}</label>
          </div>
        </div>
      </template>

      <template v-if="item.type === 'checkbox'">
        <div class="flex items-center h-[15px]">
          <input type="checkbox" :id="item.name" v-model.lazy="modelValue[item.name]" :value="false" />
          <label :for="item.name" class="ml-1 font-bold">{{ item.labelCheckbox }}</label>
        </div>
      </template>
    </LayoutInput>
  </LayoutForm>
</template>

<script>
import LayoutForm from "@/components/Layouts/LayoutForm.vue";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import useEquipmentInformation from "@/uses/equipmentInformation";

export default {
  name: "GeneralEquipment",
  components: {
    LayoutForm,
    LayoutInput,
  },
  props: ["modelValue"],
  setup() {
    const { listFormGeneralEquipment } = useEquipmentInformation();
    return { listFormGeneralEquipment };
  },
};
</script>

<style scoped></style>
