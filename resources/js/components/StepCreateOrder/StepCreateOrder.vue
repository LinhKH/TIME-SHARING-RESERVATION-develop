<template>
  <div class="h-20 flex justify-center items-center">
    <div class="flex">
      <div
        v-for="(step, index) in listSteps"
        :key="index"
        :class="{ active: step.active }"
        class="text-white px-2 py-1 h-full bg-[#dddddd] rounded-sm item-step relative"
      >
        {{ step.text }}
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import { MODULE_STORE } from "@/const";

export default {
  name: "StepCreateOrder",

  data() {
    return {};
  },
  computed: {
    ...mapGetters(MODULE_STORE.RENTAL_SPACES.NAME, {
      listSteps: MODULE_STORE.RENTAL_SPACES.GETTERS.GET_LIST_STEPS,
    }),
  },
  mounted() {},

  methods: {},
};
</script>

<style scoped>
.item-step + .item-step {
  margin-left: 20px;
}
.item-step + .item-step::before {
  content: "";
  display: block;
  position: absolute;
  width: 20px;
  height: 6px;
  background-color: #ddd;
  top: 50%;
  left: -20px;
  transform: translateY(-50%);
}
.item-step.active {
  background-color: #96c03d;
}
.item-step.active::before {
  background-color: #96c03d;
}
</style>
