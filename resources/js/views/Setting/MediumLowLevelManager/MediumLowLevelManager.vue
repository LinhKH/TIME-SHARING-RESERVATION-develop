<template>
  <div class="text-[#337ab7] cursor-pointer hover:underline">> {{ dataTable.title__ja }}</div>
  <div class="flex justify-end hover:translate-y-0.5 mb-2">
    <ButtonAddNew :text="$t('medium_small_area.add')" @clickBtn="goToLowLevelAdd(dataTable)" />
  </div>
  <div>
    <table class="table w-full border border-solid border-[#ccc] border-collapse" cellspacing="1">
      <thead>
        <tr>
          <th
            class="border border-solid border-[#ccc] border-collapse p-[8px] text-start"
            v-for="item in tableHeader"
            scope="col"
            :key="item.id"
            :class="item.classWidth"
          >
            {{ item.header }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr class="bg-[#fcf4d8] group" v-for="(itemData, index) in dataTable.area_groups" :key="index">
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start w-[15%]" scope="row">
            <span @click="handleEditManager(itemData.id, dataTable.id, dataTable.title__ja)" class="hover:underline">
              <span class="text-[#337ab7] cursor-pointer">#{{ itemData.id }} - </span>
              <span class="text-[#337ab7] cursor-pointer">{{ itemData.title__ja }}</span></span
            >
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start w-[25%]" scope="row">
            {{ itemData.mainZip }}
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start w-[25%]" scope="row">
            {{ itemData.subZip }}
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start w-[25%]" scope="row">
            {{ itemData.search }}
          </td>
          <td class="border-collapse p-2.5 text-start flex justify-center" scope="row">
            <button
              @click="() => handleUp(index)"
              class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded mb-1.5 group bg-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad] mr-[5px]"
            >
              <i class="fa fa-chevron-up"></i>
            </button>
            <button
              @click="() => handleDown(index)"
              class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded mb-1.5 group bg-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad]"
            >
              <i class="fa fa-chevron-down"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref, inject } from "vue";
import { useStore } from "vuex";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import { useI18n } from "vue-i18n";
import { useRouter, useRoute } from "vue-router";
import { getDetailSmallAreaApi } from "@/api";
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
export default {
  name: "MediumLowLevelManager",
  components: { ButtonAddNew },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const parentID = ref(route.query.id);
    const tableHeader = [
      {
        id: 1,
        header: t("low_level_manager.small_area_name"),
        classWidth: "w-[15%]",
      },
      {
        id: 2,
        header: t("low_level_manager.zip_code_main"),
        classWidth: "w-[25%]",
      },
      {
        id: 3,
        header: t("low_level_manager.zip_code_sub"),
        classWidth: "w-[25%]",
      },
      {
        id: 4,
        header: t("low_level_manager.search_key"),
        classWidth: "w-[25%]",
      },
      {
        id: 5,
        header: "",
        classWidth: "w-[10%]",
      },
    ];
    const dataTable = ref([]);
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
    const getDetailSmallArea = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailSmallAreaApi(parentID.value);
        dataTable.value = res.data;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getDetailSmallArea();
    const goToLowLevelAdd = (data) => {
      router.push({
        path: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_GROUP_LOW_LEVEL}`,
        query: {
          idParent: data.id,
          nameParent: data.title__ja,
        },
      });
    };
    const handleEditManager = (data, idParent, nameParent) => {
      router.push({
        path: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_GROUP_LOW_LEVEL_EDIT}`,
        query: {
          idLowLevel: data,
          idParent: idParent,
          nameParent: nameParent,
        },
      });
    };
    return { tableHeader, dataTable, handleEditManager, goToLowLevelAdd, parentID, handleDown, handleUp };
  },
};
</script>

<style></style>
