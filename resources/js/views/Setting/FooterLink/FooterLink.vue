<template>
  <div class="font-serif">
    <div class="text-end mb-2">
      <button
        @click="handleAddNew"
        class="bg-[#fff] px-3 py-1.5 rounded border border-solid border-[#ccc] shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all group hover:bg-[#e6e6e6] hover:border-[#adadad]"
      >
        <i class="fa fa-plus text-[14px] text-[#333] mr-[3px]"></i>
        <span class="text-[14px] text-[#333]">{{ $t("form_setting_news.add_new") }}</span>
      </button>
    </div>
    <div class="flex items-start" v-if="footerLinkNav && footerLinkNav.length">
      <div>
        <button
          @click="() => activeNav(navItemFooter.id)"
          v-for="(navItemFooter, index) in footerLinkNav"
          :key="index"
          class="border border-solid border-[#ccc] py-1.5 px-2.5 min-w-[250px] flex justify-start items-center rounded hover:bg-[#eee] mb-[6px] inline shadow-sm group"
          :class="[itemClick === navItemFooter.id ? 'active' : '']"
        >
          <i
            class="mr-[3px] text-[12px] text-[#337ab7] group-hover:text-[#23527c]"
            :class="[navItemFooter.icon, itemClick === navItemFooter.id ? 'activeText' : '']"
          ></i>
          <span
            class="text-[12px] text-[#337ab7] group-hover:text-[#23527c]"
            :class="[itemClick === navItemFooter.id ? 'activeText' : '']"
            >{{ navItemFooter.title }}</span
          >
        </button>
      </div>
      <div class="flex-1 ml-2">
        <div v-if="isShowFooter && categoryList.length">
          <button
            v-for="itemCategory in categoryList"
            @click="handelSelectCategory(itemCategory.id)"
            :key="itemCategory.id"
            class="border border-solid border-[#ccc] py-1.5 px-2.5 rounded mb-1.5 group text-[#337ab7]"
            :class="[stepCategory === itemCategory.id ? 'text-[#fff] bg-[#337ab7]' : '']"
          >
            {{ itemCategory.name }}
          </button>
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
              <tr
                class="odd:bg-[#f9f9f9] group"
                v-for="(itemData, index) in footerLinkByCategoryList"
                :key="itemData.id"
              >
                <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start w-[85%]" scope="row">
                  <span @click="handleEditFooter(itemData.id)" class="text-[#337ab7] cursor-pointer hover:underline">{{
                    itemData.title
                  }}</span>
                </td>
                <td class="border-collapse p-2.5 text-start flex justify-center" scope="row">
                  <button
                    class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded mb-1.5 group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad] mr-[5px]"
                    @click="moveUpFooterLink(itemData, index)"
                  >
                    <i class="fa fa-chevron-up"></i>
                  </button>
                  <button
                    class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded mb-1.5 group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad]"
                    @click="moveDownFooterLink(itemData, index)"
                  >
                    <i class="fa fa-chevron-down"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div v-else>
          <table class="table w-full border border-solid border-[#ddd] border-collapse" cellspacing="1">
            <thead>
              <tr>
                <th class="border border-solid border-[#ccc] border-collapse p-2 text-start" scope="col">
                  {{ $t("footer_link.title") }}
                </th>
                <th class="border border-solid border-[#ccc] border-collapse p-2 text-start" scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr class="odd:bg-[#f9f9f9] group" v-for="(item, idx) in categoryList" :key="item.id">
                <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start w-[85%]" scope="row">
                  <span @click="handleEditCategory(item.id)" class="text-[#337ab7] cursor-pointer hover:underline">{{
                    item.name
                  }}</span>
                </td>
                <td class="border-collapse p-2.5 text-start flex justify-center" scope="row">
                  <button
                    class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded mb-[6px] group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad] mr-[5px]"
                    @click="moveUpCategory(item, idx)"
                  >
                    <i class="fa fa-chevron-up"></i>
                  </button>
                  <button
                    class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded mb-[6px] group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad]"
                    @click="moveDownCategory(item, idx)"
                  >
                    <i class="fa fa-chevron-down"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { ref, inject } from "vue";
import {
  getListCategoryFooterApi,
  getListFooterLinkByCategoryApi,
  updateCategoryFooterApi,
  updateFooterLinksApi,
} from "@/api";
export default {
  name: "FooterLink",
  components: {},
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const store = useStore();
    const toast = inject("$toast");
    const itemClick = ref(1);
    const stepCategory = ref(0);
    const isShowFooter = ref(true);
    const categoryList = ref([]);
    const footerLinkByCategoryList = ref([]);
    const footerLinkNav = [
      {
        id: 1,
        icon: "fa fa-list",
        active: false,
        title: t("footer_link.link_footer"),
      },
      {
        id: 2,
        icon: "fa fa-tags fa fa-white",
        active: false,
        title: t("footer_link.category"),
      },
    ];
    const activeNav = (id) => {
      itemClick.value = id;
      if (id == 1) {
        isShowFooter.value = true;
      } else {
        isShowFooter.value = false;
      }
    };
    const getListCategoryFooter = async (page = PAGE_DEFAULT) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListCategoryFooterApi(page);
        categoryList.value = res.data;
        if (categoryList.value.length) {
          categoryList.value.sort((a, b) => b.order_number - a.order_number || b.id - a.id);
          stepCategory.value = categoryList.value[0].id;
        }
      } catch (errors) {
        const error = errors.msg || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getListCategoryFooter();
    const getListFooterLinkByCategory = async (id) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListFooterLinkByCategoryApi(id);
        footerLinkByCategoryList.value = res.data;
        if (categoryList.value.length) {
          footerLinkByCategoryList.value.sort((a, b) => b.order_number - a.order_number || b.id - a.id);
        }
      } catch (errors) {
        const error = errors.msg || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getListFooterLinkByCategory(1);
    const handleAddNew = () => {
      if (isShowFooter.value) {
        router.push(`${ROUTER_PATH.FOOTER_LINKS_ADD}`);
      } else {
        router.push(`${ROUTER_PATH.FOOD_CATEGORY_ADD}`);
      }
    };
    const handleEditFooter = (id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.FOOTER_LINKS_ADD}?id=${id}`);
    };
    const handleEditCategory = (id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.FOOD_CATEGORY_ADD}?id=${id}`);
    };
    const handelSelectCategory = (id) => {
      stepCategory.value = id;
      getListFooterLinkByCategory(id);
    };
    const updateCategory = async (payload) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateCategoryFooterApi(payload.id, payload.data);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const moveUpCategory = async (item, idx) => {
      if (idx != 0) {
        const payload = {
          id: item.id,
          data: {
            name: item.name,
            status: item.status,
            order_number: categoryList.value[idx - 1].order_number,
          },
        };
        await updateCategory(payload);
        const payload2 = {
          id: categoryList.value[idx - 1].id,
          data: {
            name: categoryList.value[idx - 1].name,
            status: categoryList.value[idx - 1].status,
            order_number: item.order_number,
          },
        };
        await updateCategory(payload2);
        await getListCategoryFooter();
      }
    };
    const moveDownCategory = async (item, idx) => {
      if (idx < categoryList.value.length - 1) {
        const payload = {
          id: item.id,
          data: {
            name: item.name,
            status: item.status,
            order_number: categoryList.value[idx + 1].order_number,
          },
        };
        await updateCategory(payload);
        const payload2 = {
          id: categoryList.value[idx + 1].id,
          data: {
            name: categoryList.value[idx + 1].name,
            status: categoryList.value[idx + 1].status,
            order_number: item.order_number,
          },
        };
        await updateCategory(payload2);
        await getListCategoryFooter();
      }
    };
    const updateFooterLink = async (payload) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateFooterLinksApi(payload.id, payload.data);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const moveUpFooterLink = async (item, idx) => {
      if (idx != 0) {
        const payload = {
          id: item.id,
          data: {
            status: item.status,
            title: item.title,
            link: item.link,
            category_id: item.category_id,
            target_person: item.target_person,
            link_destination: item.link_destination,
            tracking_category: item.tracking_category,
            tracking_label: item.tracking_label,
            order_number: footerLinkByCategoryList.value[idx - 1].order_number,
          },
        };
        await updateFooterLink(payload);
        const payload2 = {
          id: footerLinkByCategoryList.value[idx - 1].id,
          data: {
            status: footerLinkByCategoryList.value[idx - 1].status,
            title: footerLinkByCategoryList.value[idx - 1].title,
            link: footerLinkByCategoryList.value[idx - 1].link,
            category_id: footerLinkByCategoryList.value[idx - 1].category_id,
            target_person: footerLinkByCategoryList.value[idx - 1].target_person,
            link_destination: footerLinkByCategoryList.value[idx - 1].link_destination,
            tracking_category: footerLinkByCategoryList.value[idx - 1].tracking_category,
            tracking_label: footerLinkByCategoryList.value[idx - 1].tracking_label,
            order_number: item.order_number,
          },
        };
        await updateFooterLink(payload2);
        await getListFooterLinkByCategory(item.category_id);
      }
    };
    const moveDownFooterLink = async (item, idx) => {
      if (idx < footerLinkByCategoryList.value.length - 1) {
        const payload = {
          id: item.id,
          data: {
            status: item.status,
            title: item.title,
            link: item.link,
            category_id: item.category_id,
            target_person: item.target_person,
            link_destination: item.link_destination,
            tracking_category: item.tracking_category,
            tracking_label: item.tracking_label,
            order_number: footerLinkByCategoryList.value[idx + 1].order_number,
          },
        };
        await updateFooterLink(payload);
        const payload2 = {
          id: footerLinkByCategoryList.value[idx + 1].id,
          data: {
            status: footerLinkByCategoryList.value[idx + 1].status,
            title: footerLinkByCategoryList.value[idx + 1].title,
            link: footerLinkByCategoryList.value[idx + 1].link,
            category_id: footerLinkByCategoryList.value[idx + 1].category_id,
            target_person: footerLinkByCategoryList.value[idx + 1].target_person,
            link_destination: footerLinkByCategoryList.value[idx + 1].link_destination,
            tracking_category: footerLinkByCategoryList.value[idx + 1].tracking_category,
            tracking_label: footerLinkByCategoryList.value[idx + 1].tracking_label,
            order_number: item.order_number,
          },
        };
        await updateFooterLink(payload2);
        await getListFooterLinkByCategory(item.category_id);
      }
    };
    return {
      footerLinkNav,
      activeNav,
      isShowFooter,
      itemClick,
      handleAddNew,
      categoryList,
      getListCategoryFooter,
      handleEditCategory,
      handelSelectCategory,
      stepCategory,
      footerLinkByCategoryList,
      handleEditFooter,
      moveUpCategory,
      moveDownCategory,
      moveUpFooterLink,
      moveDownFooterLink,
    };
  },
};
</script>

<style scoped>
.active {
  background-color: #337ab7;
  border: 1px solid #337ab7;
}
.activeText {
  color: #fff;
}
</style>
