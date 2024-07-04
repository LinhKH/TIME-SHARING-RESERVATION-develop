<template>
  <LayoutForm :title="$t('equipment_information_components.share')">
    <LayoutInput
      v-for="(item, index) in listFormShare"
      :key="index"
      customCss="mt-5"
      :labelText="item.label"
      :isRequired="item.isRequired"
    >
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
  name: "Share",
  components: {
    LayoutForm,
    LayoutInput,
  },
  props: ["modelValue"],
  setup() {
    const { listFormShare } = useEquipmentInformation();
    return {
      listFormShare,
    };
  },
};
</script>

<style scoped></style>
