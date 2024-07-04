<template>
  <div class="font-serif">
    <div class="flex-1 mt-5 items-start">
      <button
        v-for="item in titleList"
        @click="handelStepTitle(item.category_id)"
        :key="item.id"
        class="border border-solid border-[#ccc] p-[5px] m-[5px] rounded group text-[#337ab7]"
        :class="[stepTitle === item.category_id ? 'text-[#fff] bg-[#337ab7]' : '']"
      >
        {{ item.title }}
      </button>
    </div>
    <div class="flex justify-end hover:translate-y-0.5 my-1">
      <ButtonAddNew :text="$t('static_Page.text_button')" @clickBtn="goToCreateNew" />
    </div>
    <div class="">
      <table class="table w-full border border-solid border-[#ddd] border-collapse" cellspacing="1">
        <thead>
          <tr>
            <th class="border border-solid border-[#ccc] border-collapse p-[8px] text-start" scope="col">
              {{ $t("footer_link.title") }}
            </th>
            <th class="border border-solid border-[#ccc] border-collapse p-[8px] text-start" scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd:bg-[#f9f9f9] group" v-for="(itemData, index) in dataTable" :key="index">
            <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start w-[85%]" scope="row">
              <span @click="handleEditFooter(itemData.id)" class="text-[#337ab7] cursor-pointer hover:underline">{{
                itemData.title_jp
              }}</span>
            </td>
            <td class="border-collapse p-2.5 text-start flex justify-center" scope="row">
              <button
                @click="() => handleUp(index)"
                class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded mb-1.5 group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad] mr-[5px]"
              >
                <i class="fa fa-chevron-up"></i>
              </button>
              <button
                @click="() => handleDown(index)"
                class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded mb-1.5 group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad]"
              >
                <i class="fa fa-chevron-down"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- <Pagination
        v-if="pagination"
        :pageCurrent="pagination.current_page"
        :totalPage="pagination.total_page"
        @onBack="handleBackPage"
        @onNext="handleNextPage"
      /> -->
    </div>
  </div>
</template>

<script>
import { ref, inject } from "vue";
import { useStore } from "vuex";
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import { useI18n } from "vue-i18n";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import { useRouter } from "vue-router";
import { getListEquipInformationByCategoryApi } from "@/api";
export default {
  name: "SpaceEquipmentInformation",
  components: { ButtonAddNew },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const store = useStore();
    const toast = inject("$toast");
    const titleList = [
      {
        id: 1,
        category_id: "basic",
        title: t("space_equip_inform.information"),
      },
      {
        id: 2,
        category_id: "general",
        title: t("space_equip_inform.equipment"),
      },
      {
        id: 3,
        category_id: "conference",
        title: t("space_equip_inform.equipment_broad"),
      },
      {
        id: 4,
        category_id: "photography",
        title: t("space_equip_inform.equipment_make_video"),
      },
      {
        id: 5,
        category_id: "events",
        title: t("space_equip_inform.event_equipment"),
      },
      {
        id: 6,
        category_id: "party",
        title: t("space_equip_inform.party_equipment"),
      },
      {
        id: 7,
        category_id: "share",
        title: t("space_equip_inform.repos"),
      },
      {
        id: 8,
        category_id: "radio-options",
        title: t("space_equip_inform.radio_option"),
      },
    ];
    const dataTable = ref([]);
    const stepTitle = ref("basic");
    const handelStepTitle = (id) => {
      stepTitle.value = id;
      getListEquipInformationByCategory(id);
    };
    const handleUp = (index) => {
      if (!dataTable.value[index - 1]) return;
      const arrayCurrent = [...dataTable.value];
      dataTable.value[index - 1] = arrayCurrent[index];
      dataTable.value[index] = arrayCurrent[index - 1];
    };
    const handleDown = (index) => {
      if (!dataTable.value[index + 1]) return;
      const arrayCurrent = [...dataTable.value];
      dataTable.value[index + 1] = arrayCurrent[index];
      dataTable.value[index] = arrayCurrent[index + 1];
    };
    // const pageCurrent = computed(() => {
    //   if (route.query.page) {
    //     return route.query.page;
    //   } else {
    //     return PAGE_DEFAULT;
    //   }
    // });
    const goToCreateNew = () => {
      router.push(`${ROUTER_PATH.RENTAL_SPACE_EQUIPMENT_INFORMATION_ADD}?id=${stepTitle.value}`);
    };
    const handleEditFooter = (id) => {
      router.push(`${ROUTER_PATH.RENTAL_SPACE_EQUIPMENT_INFORMATION_EDIT}?id=${id}`);
    };
    const getListEquipInformationByCategory = async (id) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListEquipInformationByCategoryApi(id);
        dataTable.value = res.data;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getListEquipInformationByCategory("basic");
    return {
      titleList,
      stepTitle,
      handelStepTitle,
      dataTable,
      goToCreateNew,
      handleEditFooter,
      handleUp,
      handleDown,
    };
  },
};
</script>

<style></style>
