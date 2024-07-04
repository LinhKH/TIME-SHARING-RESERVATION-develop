<template>
  <div v-if="isSuccess" class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-[10px] py-[12px] my-3">
    <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
    <span class="text-[12px] text-[#3c763d]">{{ $t("form_setting_news.success") }}</span>
  </div>
  <div class="flex flex-wrap mx-auto">
    <div>
      <button
        @click="() => activeNav(item.id)"
        v-for="item in listMenuEdit"
        :key="item.id"
        class="cursor-pointer p-2 min-w-[75px] border-b border-solid border-[#ddd] hover:bg-[#eee] transition-all duration-200"
        :class="[itemClick === item.id ? 'border-[#75c8be] border-b-2' : '']"
      >
        <i :class="item.icon" class="mr-1"></i>
        <span>{{ item.name }}</span>
      </button>
    </div>
  </div>
  <form>
    <ErrorMessage class="text-[red] font-bold" name="name_area_us" />
    <LayoutInput :labelText="$t('medium_small_area_add.type')">
      <div class="flex items-center justify-start break-words">
        <div v-for="idItem in typeList" :key="idItem.id">
          <label :for="idItem.type" class="flex items-center mr-[20px] cursor-pointer">
            <Field
              :id="idItem.type"
              type="radio"
              name="type"
              :value="idItem.id"
              v-model="detailSmallArea.active"
              class="translate-y-[-1px] mr-[4px]"
            />
            {{ idItem.type }}
          </label>
        </div>
      </div>
    </LayoutInput>
    <LayoutInput :labelText="$t('medium_small_area_add.province')">
      <Field
        v-model="detailSmallArea.address_specifier"
        name="province"
        as="select"
        class="bg-[#fff] px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
      >
        <option v-for="idItem in province" :key="idItem.id" :value="idItem.id">
          {{ idItem.type }}
        </option>
      </Field>
      <ErrorMessage class="text-[red] font-bold" name="province" />
    </LayoutInput>
    <LayoutInput :labelText="$t('medium_small_area_add.name_area_us')">
      <div class="flex rounded border border-solid border-[#ddd] w-[40%]">
        <div class="bg-[#eeeeee] border-r-[1px] px-3.5 py-2">
          <i class="flag en"></i>
        </div>
        <Field
          v-model="detailSmallArea.title__en"
          type="text"
          name="name_area_us"
          class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded"
        />
      </div>
    </LayoutInput>
    <LayoutInput :isRequired="true" :labelText="$t('medium_small_area_add.name_area_ja')">
      <div class="flex rounded border border-solid border-[#ddd] w-[40%]">
        <div class="bg-[#eeeeee] border-r-[1px] px-3 py-2">
          <i class="flag ja"></i>
        </div>
        <Field
          v-model="detailSmallArea.title__ja"
          type="text"
          name="name_area_ja"
          class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded"
        />
      </div>
      <ErrorMessage class="text-[red] font-bold" name="name_area_ja" />
    </LayoutInput>
    <LayoutInput :labelText="$t('medium_small_area_add.sub_name_area')">
      <div class="flex rounded border border-solid border-[#ddd] w-[40%]">
        <div class="bg-[#eeeeee] border-r-[1px] px-3 py-2">
          <i class="flag ja"></i>
        </div>
        <Field
          v-model="detailSmallArea.title__ja_kana"
          type="text"
          name="sub_name_area"
          class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded"
        />
      </div>
      <div class="text-[#737373] my-1">{{ $t("medium_small_area_add.sub_name_area_input") }}</div>
    </LayoutInput>
    <LayoutInput :labelText="$t('medium_small_area_add.address_map')">
      <Field
        v-model="detailSmallArea.type"
        type="text"
        name="address_map"
        class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
      />
      <div class="text-[#737373] my-1">{{ $t("medium_small_area_add.sub_address_map") }}</div>
    </LayoutInput>
    <LayoutInput :labelText="$t('medium_small_area_add.note')">
      <Field
        v-model="detailSmallArea.content"
        as="textarea"
        type="text"
        rows="5"
        name="note"
        class="px-2 w-[40%] outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
      />
      <div class="text-[#737373] my-1">{{ $t("medium_small_area_add.sub_node") }}</div>
    </LayoutInput>
    <LayoutInput>
      <div class="flex gap-4">
        <button
          class="block w-fit p-[8px] bg-[#ffbd00] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
          @click="submitForm"
        >
          {{ $t("medium_small_area_add.btn") }}
        </button>
        <button
          v-if="(detailSmallArea.area_groups.length == 0 && isDelete) || (newId && isDelete)"
          class="block w-fit p-[8px] bg-[#a94442] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
          @click="handleDeleteParentId"
        >
          {{ $t("space_equip_inform_add.btn_del") }}
        </button>
        <!-- <button
          v-if="newId"
          class="block w-fit p-[8px] bg-[#a94442] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
          @click="handleDeleteParentId"
        >
          {{ $t("space_equip_inform_add.btn_del") }}
        </button> -->
      </div>
      <div class="my-2 text-[#a94442]" v-if="detailSmallArea.area_groups.length !== 0">
        {{ $t("footer_link.required") }}
      </div>
    </LayoutInput>
  </form>
</template>

<script>
import * as Yup from "yup";
import { ref, inject } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { createSmallAreaApi, deleteSmallAreaApi, getDetailSmallAreaApi, updateSmallAreaApi } from "@/api";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { Field, useForm, ErrorMessage } from "vee-validate";
export default {
  name: "MediumSmallAreaAdd",
  components: { LayoutInput, Field, ErrorMessage },
  props: { isDelete: { type: Boolean, default: true } },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const newId = ref();
    const isSuccess = ref(false);
    const parentID = ref(route.query.id);
    const detailSmallArea = ref({
      active: 2,
      area_groups: [],
    });
    const idTitle = "idTest";
    const itemClick = ref(1);
    const typeList = [
      {
        id: 1,
        type: t("medium_small_area_add.individual"),
      },
      {
        id: 2,
        type: t("medium_small_area_add.general"),
      },
    ];

    const province = [
      {
        type: t("medium_small_area_add.default"),
      },
      {
        id: "1",
        type: t("medium_small_area_add.Hokkaido"),
      },
      {
        id: "2",
        type: t("medium_small_area_add.iwate_prefecture"),
      },
      {
        id: "3",
        type: t("medium_small_area_add.miyagi_prefecture"),
      },
      {
        id: "4",
        type: t("medium_small_area_add.akita"),
      },
      {
        id: "5",
        type: t("medium_small_area_add.yamagata"),
      },
    ];
    const listMenuEdit = ref([
      {
        id: 1,
        icon: "fa fa-info-circle",
        name: t("medium_small_area_add.content"),
      },
    ]);
    const isShowContent = ref(true);
    const activeNav = (id) => {
      itemClick.value = id;
      if (id == 1) {
        isShowContent.value = true;
      } else {
        isShowContent.value = false;
      }
    };
    const { handleSubmit, errors } = useForm({
      initialValues: {},
      validationSchema: Yup.object().shape({
        province: Yup.string().required(t("medium_small_area_add.required")),
        // name_area_us: Yup.string().required(t("medium_small_area_add.required")).trim(),
        name_area_ja: Yup.string().required(t("medium_small_area_add.required")).trim(),
      }),
    });
    const countCreate = ref(0);

    const createSmallArea = async (val) => {
      try {
        if (countCreate.value > 0) {
        } else {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const res = await createSmallAreaApi({
            active: val.type,
            title__en: val.name_area_us,
            title__ja: val.name_area_ja,
            title__ja_kana: val.sub_name_area,
            address_specifier: val.province,
            attribute: {
              type: val.address_map,
              content: val.note,
            },
          });
          countCreate.value = countCreate.value + 1;
          newId.value = res.data.id;
          router.push(
            `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_GROUP_EDIT}?id=${newId.value}`
          );
        }

        isSuccess.value = true;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const deleteParentApi = async (event) => {
      event.preventDefault();

      if (confirm("お知らせを削除してよろしいですか？")) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          await deleteSmallAreaApi(newId.value || parentID.value);
          router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_GROUP}`);
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    const updateSmallArea = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateSmallAreaApi(parentID.value, {
          active: val.type,
          title__en: val.name_area_us,
          title__ja: val.name_area_ja,
          title__ja_kana: val.sub_name_area,
          address_specifier: val.province,
          attribute: {
            type: val.address_map,
            content: val.note,
          },
        });
        isSuccess.value = true;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const getDetailSmallArea = async () => {
      if (parentID.value) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const res = await getDetailSmallAreaApi(parentID.value);
          detailSmallArea.value = res.data;
          res.data.area_group_eavs.forEach((item) => {
            detailSmallArea.value[item.attribute] = item.value;
          });
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    getDetailSmallArea();
    const submitForm = handleSubmit(async (val) => {
      if (parentID.value) {
        updateSmallArea(val);
      } else {
        createSmallArea(val);
      }
    });
    const handleDeleteParentId = (id) => {
      deleteParentApi(id);
    };
    return {
      errors,
      listMenuEdit,
      typeList,
      detailSmallArea,
      idTitle,
      submitForm,
      itemClick,
      activeNav,
      isShowContent,
      province,
      newId,
      handleDeleteParentId,
      parentID,
      isSuccess,
      countCreate,
    };
  },
};
</script>

<style scoped></style>
