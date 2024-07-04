<template>
  <div :class="`w-full border border-solid ${style.colorBorder} mb-2`">
    <div :class="`flex justify-between px-2 py-2 border-b border-solid ${style.colorBorder} ${style.colorBackground}`">
      <div class="flex items-center">
        <span class="fa-stack fa-lg block mr-1" v-if="style.iconClass === 'Success'">
          <i :class="`fa fa-circle-thin fa-stack-2x ${style.colorIcon}`"></i>
          <i :class="`fa-stack-1x fa fa-check ${style.colorIcon}`"></i>
        </span>
        <span class="fa-stack fa-lg block mr-1" v-if="style.iconClass === 'Warning'">
          <i :class="`fa fa-circle-thin fa-stack-2x ${style.colorIcon}`"></i>
          <i :class="`fa-stack-1x fa fa-hourglass-half ${style.colorIcon}`"></i>
        </span>
        <div :class="style.colorText">{{ detailGroup.plan_group_name }}</div>
      </div>
      <button class="block rounded border border-solid border-[#ccc] bg-white p-2" @click="handleEditGroup">
        <i class="fa fa-pencil text-[#2d708f] mr-1"></i>
        <span class="text-[#2d708f]">{{ $t("system_group_add.edit_plan") }}</span>
      </button>
    </div>
    <div class="p-3">
      <div v-if="style.iconClass === 'Warning'" :class="`m-2 text-center ${style.colorText}`">
        {{ $t("box_group.please_select_a_plan") }}
      </div>
      <div v-for="(item, index) in detailGroup.rental_plans" :key="index">{{ item.plan_name }}</div>
      <div v-if="detailGroup.rental_plans.length === 1" class="m-2 text-center text-[#737373]">
        {{ $t("box_group.please_select_a_linked_plan") }}
      </div>
    </div>
  </div>
</template>

<script>
import { reactive } from "@vue/reactivity";
import { ROUTER_PATH } from "@/const";
import { useRoute, useRouter } from "vue-router";
export default {
  props: { detailGroup: Object },
  setup(props) {
    const route = useRoute();
    const router = useRouter();
    const idSpace = route.params.id || route.query.id;
    const style = reactive({
      colorBorder: "",
      colorBackground: "",
      colorIcon: "",
      colorText: "",
      iconClass: "",
    });
    switch (true) {
      case props.detailGroup.rental_plans.length > 0:
        style.colorBorder = "border-[#27e1fb]";
        style.colorBackground = "bg-[#bcf6ff]";
        style.colorIcon = "text-[#2d708f]";
        style.colorText = "text-[#2d708f]";
        style.iconClass = "Success";
        break;
      case props.detailGroup.rental_plans.length == 0:
        style.colorBorder = "border-[#d23042]";
        style.colorBackground = "bg-[#ffd9d9]";
        style.colorIcon = "text-[#b30000]";
        style.colorText = "text-[#b30000]";
        style.iconClass = "Warning";
        break;
      default:
        break;
    }
    const idGroup = props.detailGroup?.plan_group_id;
    const handleEditGroup = () =>
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${idSpace}/${ROUTER_PATH.SPACE.GROUP_EDIT}/${idGroup}`
      );
    return { style, handleEditGroup };
  },
};
</script>

<style></style>
