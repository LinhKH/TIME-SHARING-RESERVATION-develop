<template>
  <div class="text-[#337ab7] cursor-pointer hover:underline">> {{ nameParent }}</div>
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
  <div v-if="isShowContent">
    <form @submit="submitForm">
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
                v-model="detailChildSmall.active"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
      </LayoutInput>
      <LayoutInput :labelText="$t('area_low_level.include_area_small')">
        {{ nameParent }}
      </LayoutInput>
      <LayoutInput :labelText="$t('area_low_level.area_small_en')">
        <div class="flex rounded border border-solid border-[#ddd] w-[40%]">
          <div class="bg-[#eeeeee] border-r-[1px] px-3.5 py-2">
            <i class="flag en"></i>
          </div>
          <Field
            type="text"
            name="name_area_us"
            v-model="detailChildSmall.title__en"
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
            type="text"
            name="name_area_ja"
            v-model="detailChildSmall.title__ja"
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
            type="text"
            name="sub_name_area"
            v-model="detailChildSmall.title__ja_kana"
            class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded"
          />
        </div>
        <div class="text-[#737373] my-1">{{ $t("medium_small_area_add.sub_name_area_input") }}</div>
      </LayoutInput>
      <LayoutInput :labelText="$t('area_low_level.describe')">
        <Field
          as="textarea"
          type="text"
          rows="4"
          name="describe"
          v-model="detailChildSmall.describe"
          class="px-2 w-[40%] outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
        />
        <div class="text-[#737373] my-1">{{ $t("area_low_level.sub_describe") }}</div>
      </LayoutInput>
      <LayoutInput :labelText="$t('medium_small_area_add.note')">
        <Field
          as="textarea"
          type="text"
          rows="4"
          name="note"
          v-model="detailChildSmall.note"
          class="px-2 w-[40%] outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
        />
        <div class="text-[#737373] my-1">{{ $t("medium_small_area_add.sub_node") }}</div>
      </LayoutInput>
      <LayoutInput :iconPrev="'fa fa-map-o'" :labelText="$t('area_low_level.address_to_use')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in addressUse" :key="idItem.id">
            <label :for="idItem.type" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.type"
                type="radio"
                name="address_to_use"
                :value="idItem.id"
                v-model="detailChildSmall.address_to_use"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
        <div class="text-[#737373] my-1">{{ $t("area_low_level.sub_address_to_use") }}</div>
      </LayoutInput>
      <LayoutInput :labelText="$t('area_low_level.letter_special')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in letterSpecial" :key="idItem.id">
            <label :for="idItem.type" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.type"
                type="checkbox"
                name="letter_special"
                :value="idItem.id"
                v-model="detailChildSmall.letterSpecial"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
        <div class="text-[#737373] my-1">{{ $t("area_low_level.sub_letter_special") }}</div>
      </LayoutInput>
      <LayoutInput :labelText="$t('area_low_level.special_support')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in specialSupport" :key="idItem.id">
            <label :for="idItem.type" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.type"
                type="checkbox"
                name="special_support"
                :value="idItem.id"
                v-model="detailChildSmall.specialSupport"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
        <div class="text-[#737373] my-1">{{ $t("area_low_level.sub_special_support") }}</div>
      </LayoutInput>
      <LayoutInput :labelText="$t('area_low_level.food_drink')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in food" :key="idItem.id">
            <label :for="idItem.type" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.type"
                type="checkbox"
                name="food_drink"
                :value="idItem.id"
                v-model="detailChildSmall.food"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
        <div class="text-[#737373] my-1">{{ $t("area_low_level.sub_food_drink") }}</div>
      </LayoutInput>
      <LayoutInput :labelText="$t('area_low_level.food_drink_area')">
        <div class="flex items-center justify-start break-words">
          <div v-for="idItem in foodArea" :key="idItem.id">
            <label :for="idItem.type" class="flex items-center mr-[20px] cursor-pointer">
              <Field
                :id="idItem.type"
                type="checkbox"
                name="food_drink_area"
                :value="idItem.id"
                v-model="detailChildSmall.foodArea"
                class="translate-y-[-1px] mr-[4px]"
              />
              {{ idItem.type }}
            </label>
          </div>
        </div>
        <div class="text-[#737373] my-1">{{ $t("area_low_level.sub_food_drink_area") }}</div>
      </LayoutInput>
      <LayoutInput>
        <div class="flex gap-4">
          <button
            class="block w-fit p-[8px] bg-[#ffbd00] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
            @click="handleSubmit"
          >
            {{ $t("medium_small_area_add.btn") }}
          </button>
          <button
            v-if="newChildId || idChildLowLevel"
            class="block w-fit p-[8px] bg-[#a94442] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
            @click="handleDeleteChildId"
          >
            {{ $t("space_equip_inform_add.btn_del") }}
          </button>
        </div>
      </LayoutInput>
    </form>
  </div>
  <div v-else class="my-2">
    <AreaLowLevel @update="updateZipCode" />
  </div>
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
import AreaLowLevel from "@/components/AreaLowLevel";
export default {
  name: "MediumSmallLowLevel",
  components: { LayoutInput, Field, ErrorMessage, AreaLowLevel },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const newChildId = ref();
    const detailChildSmall = ref({
      active: 2,
      letterSpecial: "1",
      address_to_use: "2",
    });
    const idName = "idTest";
    const itemClick = ref(1);
    const isShowUpdate = ref(false);
    const idParent = ref(route.query);
    const idParentForChild = route.query.idParent;
    const nameParent = route.query.nameParent;
    const idChildLowLevel = ref(route.query.idLowLevel);
    const isSuccess = ref(false);
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
    const addressUse = [
      {
        id: "1",
        type: t("area_low_level.no"),
      },
      {
        id: "2",
        type: t("area_low_level.yes"),
      },
    ];
    const letterSpecial = [
      {
        id: "1",
        type: t("area_low_level.can"),
      },
    ];
    const foodArea = [
      {
        id: "1",
        type: t("area_low_level.can"),
      },
    ];
    const food = [
      {
        id: "1",
        type: t("area_low_level.can"),
      },
    ];
    const specialSupport = [
      {
        id: "1",
        type: t("area_low_level.can"),
      },
    ];
    const listMenuEdit = ref([
      {
        id: 1,
        icon: "fa fa-info-circle",
        name: t("medium_small_area_add.content"),
      },
      {
        id: 2,
        icon: "fa fa-envelope-o",
        name: t("area_low_level.post_code"),
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
        name_area_us: Yup.string().required(t("medium_small_area_add.required")),
        name_area_ja: Yup.string().required(t("medium_small_area_add.required")),
      }),
    });
    const createSmallLowLevel = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await createSmallAreaApi({
          active: val.type,
          title__en: val.name_area_us,
          title__ja: val.name_area_ja,
          parent_id: idParent.value.idParent,
          title__ja_kana: val.sub_name_area,
          attribute: {
            describe: val.describe,
            note: val.note,
            address_to_use: val.address_to_use,
            letterSpecial: val.letter_special,
            specialSupport: val.special_support,
            food: val.food_drink,
            foodArea: val.food_drink_area,
          },
        });
        newChildId.value = res.data.id;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const deleteChildApi = async (event) => {
      event.preventDefault();
      if (confirm("お知らせを削除してよろしいですか？")) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          await deleteSmallAreaApi(newChildId.value || idChildLowLevel.value);
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    const updateSmallLowLevel = async (val) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateSmallAreaApi(idChildLowLevel.value, {
          active: val.type,
          title__en: val.name_area_us,
          title__ja: val.name_area_ja,
          parent_id: idParent.value.idParent,
          title__ja_kana: val.sub_name_area,
          attribute: {
            describe: val.describe,
            note: val.note,
            address_to_use: val.address_to_use,
            letterSpecial: val.letter_special,
            specialSupport: val.special_support,
            food: val.food_drink,
            foodArea: val.food_drink_area,
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
    const getDetailChildSmallArea = async () => {
      if (idChildLowLevel.value) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const res = await getDetailSmallAreaApi(idChildLowLevel.value);
          detailChildSmall.value = res.data;
          res.data.area_group_eavs.forEach((item) => {
            detailChildSmall.value[item.attribute] = item.value;
          });
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    getDetailChildSmallArea();
    const submitForm = handleSubmit(async (val) => {
      if (idChildLowLevel.value) {
        updateSmallLowLevel(val);
      } else {
        createSmallLowLevel(val);
      }
    });
    const handleDeleteChildId = (e) => {
      deleteChildApi(e);
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_LOW_LEVER_MANAGE}?id=${idParentForChild}`
      );
    };
    const updateZipCode = () => {
      isShowUpdate.value = true;
      isShowContent.value = true;
      itemClick.value = 1;
    };
    return {
      errors,
      listMenuEdit,
      typeList,
      detailChildSmall,
      idName,
      submitForm,
      itemClick,
      activeNav,
      isShowContent,
      addressUse,
      letterSpecial,
      foodArea,
      food,
      specialSupport,
      updateZipCode,
      isShowUpdate,
      newChildId,
      idParent,
      handleDeleteChildId,
      idChildLowLevel,
      isSuccess,
      nameParent,
    };
  },
};
</script>

<style scoped></style>
