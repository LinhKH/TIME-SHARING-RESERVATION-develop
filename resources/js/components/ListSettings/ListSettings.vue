<template>
  <table class="w-full">
    <tr>
      <th class="w-[95%] p-2 text-left">{{ $t("common.title") }}</th>
      <th class="w-[5%]"></th>
    </tr>
    <tr v-for="(item, index) in list" :key="index" class="even:bg-[#f9f9f9]">
      <td class="p-2 group">
        <div @click="() => handleDirection(item.id)" class="cursor-pointer">
          <div class="flex w-full justify-between">
            <div>
              <div>
                <i :class="item.info.icon" class="mr-1 text-[#337ab7]"></i>
                <span class="text-[#337ab7] group-hover:underline">
                  {{ $t(`page_and_message.${item.title}`) }}
                </span>
              </div>
              <div class="text-[#737373] mt-1 group-hover:underline">
                {{ $t(`sub_title_page_and_message.${item.title}`) }}
              </div>
            </div>
            <div>
              <i class="pull-right fa-lg fa fa-check-circle-o text-[#3c763d]"></i>
            </div>
          </div>
        </div>
      </td>
      <td class="p-2">
        <div class="cursor-pointer" @click="() => handleDirection(item.id)">
          <button class="px-3 py-2 bg-white border border-solid border-[#ddd] rounded block mx-auto">
            <i class="fa fa-pencil" aria-hidden="true"></i>
          </button>
        </div>
      </td>
    </tr>
  </table>
</template>

<script>
import { ROUTER_PATH } from "@/const";
import { useRouter, useRoute } from "vue-router";
export default {
  name: "ListSettings",
  props: {
    list: Object,
    path: {
      type: String,
      isRequired: true,
    },
  },
  setup(props) {
    const router = useRouter();
    const route = useRoute();
    const idSpace = route.params.id;
    const handleDirection = (id) => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${props.path}/${idSpace}?idPageAndMessage=${id}`
      );
    };
    return { idSpace, ROUTER_PATH, handleDirection };
  },
};
</script>

<style scoped>
th,
td {
  border: 1px solid #ddd;
}
</style>
