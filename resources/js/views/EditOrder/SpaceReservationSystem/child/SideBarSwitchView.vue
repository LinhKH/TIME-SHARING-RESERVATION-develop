<template>
  <div>
    <div class="flex items-center gap-[10px] py-3">
      <div
        class="rounded-[4px] border border-[#ddd] cursor-pointer"
        v-for="(item, index) in listTabView"
        :key="index"
        @click="() => handleChangeStep(item)"
      >
        <div v-if="index == 0" class="bg-[#ffbd00] text-[#ffffff] py-2 px-2">
          <div class="flex text-[#ffffff] items-center justify-center gap-1 mb-1">
            <i v-if="item.classIcon" :class="item.classIcon" class="text-[#ffffff]" aria-hidden="true"></i>
            <h3 class="text-[#ffffff]">{{ item.title }}</h3>
          </div>
          {{ item.subTitle }}
        </div>
        <div v-else class="hover:bg-[#e6e6e6] hover:text-[#333] py-2 px-2">
          <div class="flex justify-center items-center gap-1 mb-1">
            <i v-if="item.classIcon" :class="item.classIcon" aria-hidden="true"></i>
            <h3>{{ item.title }}</h3>
          </div>
          {{ item.subTitle }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ROUTER_PATH } from "@/const";
import { useRouter } from "vue-router";
export default {
  name: "SideBarSwitchView",
  props: {
    idSpace: String,
    canAddMore: { type: Boolean, default: () => true },
  },
  setup(props) {
    const router = useRouter();
    const handleChangeStep = (item) => {
      if (
        item.url.includes(`${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.RENTAL_PLAN_EDIT_ROUTER.RENTAL_PLAN_ADD}`)
      ) {
        if (props.canAddMore) router.push(`${item.url}/${props.idSpace}`);
      } else {
        router.push(`${item.url}/${props.idSpace}`);
      }
    };
    let listTabView = [
      {
        title: "新規プラン追加",
        subTitle: "(予約枠の新規作成)",
        classIcon: "fa fa-plus",
        url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.RENTAL_PLAN_EDIT_ROUTER.RENTAL_PLAN_ADD}`,
      },
      {
        title: "カレンダー",
        subTitle: "(特別日設定 (料金・人数の変更))",
        classIcon: "fa fa-calendar",
        url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.RENTAL_INTERVAL_CONFIG_OVERRIDE}`,
      },
      {
        title: "詳細予約設定",
        subTitle: "(直前割引、トラッキングURLなど)",
        classIcon: "fa fa-cog",
        url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.BOOKING_SYSTEM_ADVANCED_SETTINGS}`,
      },
      {
        title: "オプション",
        subTitle: "(設備と備品)",
        classIcon: "fa fa-glass",
        url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.RESERVATION_SYSTEM_RESERVATION_OPTIONS}`,
      },
      {
        title: "複数プラン自動ブロック",
        subTitle: "(プランを紐づけて枠在庫管理)",
        url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.GROUP_MANAGE}`,
      },
    ];
    return { listTabView, handleChangeStep };
  },
};
</script>

<style scoped></style>
