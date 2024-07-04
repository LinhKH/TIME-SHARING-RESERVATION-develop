<template>
  <div class="flex justify-end hover:translate-y-0.5 mb-2">
    <ButtonAddNew :text="$t('medium_small_area.add')" @clickBtn="goToCreateNew" />
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
        <tr v-for="item in dataTable" :key="item.id" class="odd:bg-[#f9f9f9] group">
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start" scope="row">
            <span @click="() => goToEdit(item)" class="hover:underline">
              <span class="text-[#337ab7] cursor-pointer">#{{ item.id }} - </span>
              <span class="text-[#337ab7] cursor-pointer">{{ item.title__ja }}</span>
            </span>
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start" scope="row">
            <div v-if="item.area_groups">
              <div class="inline" v-for="itemChild in item.area_groups" :key="itemChild.id">
                <span
                  @click="() => goToEditLowLevel(itemChild.id, item.id, item.title__ja)"
                  class="text-[#337ab7] cursor-pointer hover:underline"
                  >{{ itemChild.title__ja }} ,
                </span>
              </div>
            </div>
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start" scope="row">
            <span @click="() => goToManager(item.id)" class="text-[#337ab7] cursor-pointer hover:underline">{{
              $t("medium_small_area.detail")
            }}</span>
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
import { getListSmallAreaApi } from "@/api";
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
export default {
  name: "MediumSmallArea",
  components: { ButtonAddNew },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const tableHeader = [
      {
        id: 1,
        header: t("medium_small_area.name_area_large"),
        classWidth: "w-[15%]",
      },
      {
        id: 2,
        header: t("medium_small_area.name_area_small"),
        classWidth: "w-[65%]",
      },
      {
        id: 3,
        header: t("medium_small_area.name_manger"),
        classWidth: "",
      },
    ];
    const dataTable = ref([]);
    const getListSmallArea = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListSmallAreaApi();
        dataTable.value = res;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    const goToCreateNew = () => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_GROUP_ADD}`);
    };
    const goToEdit = (item) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_GROUP_EDIT}?id=${item.id}`);
    };
    const goToEditLowLevel = (id, idParent, nameParent) => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_GROUP_LOW_LEVEL_EDIT}?idLowLevel=${id}&idParent=${idParent}&nameParent=${nameParent}`
      );
    };
    const goToManager = (id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_LOW_LEVER_MANAGE}?id=${id}`);
    };
    getListSmallArea();

    return { tableHeader, dataTable, goToCreateNew, goToEdit, goToManager, goToEditLowLevel };
  },
};
</script>

<style></style>
