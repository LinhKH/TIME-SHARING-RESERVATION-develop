<template>
  <LayoutForm :title="$t('equipment_information_components.party_equipment')">
    <LayoutInput
      v-for="(item, index) in listFromPartyEquipment"
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

      <template v-if="item.type === 'textarea'">
        <textarea
          class="w-full h-14 px-2 py-1 resize-none outline-none border border-solid border-[#ddd] rounded focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
          v-model.lazy="modelValue[item.name]"
        />
      </template>
    </LayoutInput>
  </LayoutForm>
</template>

<script>
import LayoutForm from "@/components/Layouts/LayoutForm.vue";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import useEquipmentInformation from "@/uses/equipmentInformation";

export default {
  name: "PartyEquipment",
  components: {
    LayoutForm,
    LayoutInput,
  },
  props: ["modelValue"],
  setup() {
    const { listFromPartyEquipment } = useEquipmentInformation();
    return { listFromPartyEquipment };
  },
};
</script>

<style scoped></style>
