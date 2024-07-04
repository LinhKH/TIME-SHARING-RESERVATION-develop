<template>
  <LayoutForm :title="$t('spaces_general_page.basic_information')" icon="fa fa-info-circle">
    <LayoutInput :labelText="$t('spaces_general_page.space_id')">
      <span>{{ idGeneral }}</span>
    </LayoutInput>

    <LayoutInput :labelText="$t('spaces_general_page.company_organization')">
      <span class="text-[#337ab7]">{{ $t("common.name_company") }}</span>
    </LayoutInput>

    <LayoutInput :labelText="$t('spaces_general_page.public_status')" icon="fa fa-question-circle text-[#337ab7] ml-1">
      <span v-if="idGeneral">
        <span v-if="statusValue === 'published'"> 公開中 </span>
        <span v-else>非公開</span>
      </span>
      <span v-else> {{ $t("spaces_general_page.private") }} </span>
      <i class="fa fa-question ml-1"></i>
    </LayoutInput>

    <LayoutInput
      :labelText="$t('spaces_general_page.space_name')"
      :isRequired="true"
      icon="fa fa-question-circle text-[#337ab7] ml-1"
    >
      <div class="w-[660px] border border-solid border-[#ddd] rounded flex h-8">
        <input
          type="text"
          v-model="formData.general_basic_space_name_ja"
          class="w-full h-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none rounded"
          :placeholder="$t('spaces_general_page.placeholder_1')"
        />
      </div>
      <div v-if="messagesFormError.general_basic_space_name_ja">
        <MessagesFormError :messages="messagesFormError.general_basic_space_name_ja" />
      </div>
    </LayoutInput>

    <LayoutInput
      :labelText="$t('spaces_general_page.space_name_kana')"
      icon="fa fa-question-circle text-[#337ab7] ml-1"
    >
      <div class="w-[660px] max-w-full h-8 border border-solid border-[#ddd] rounded">
        <input
          type="text"
          v-model="formData.general_basic_space_name_kana"
          class="w-full h-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none rounded"
          :placeholder="$t('spaces_general_page.placeholder_2')"
        />
      </div>
      <div class="mt-2">{{ $t("spaces_general_page.help_1") }}</div>
      <div>{{ $t("spaces_general_page.help_2") }}</div>
    </LayoutInput>

    <LayoutInput :labelText="$t('spaces_general_page.space_overview')" icon="fa fa-question-circle text-[#337ab7]">
      <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
        <input
          type="text"
          v-model="formData.general_basic_space_overview"
          class="w-full h-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none rounded"
          :placeholder="$t('spaces_general_page.placeholder_3')"
        />
      </div>
      <!-- <div v-if="messagesFormError.general_basic_space_overview">
        <MessagesFormError :messages="messagesFormError.general_basic_space_overview" />
      </div> -->
    </LayoutInput>

    <LayoutInput
      :labelText="$t('spaces_general_page.space_introduction')"
      :isRequired="true"
      icon="fa fa-question-circle text-[#337ab7] ml-1"
    >
      <div class="w-full border border-solid border-[#ddd] rounded flex h-20">
        <textarea
          type="text"
          v-model="formData.general_basic_space_introduction"
          class="w-full h-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none rounded resize-none py-1"
          :placeholder="$t('spaces_general_page.placeholder_4')"
        />
      </div>
      <div v-if="messagesFormError.general_basic_space_introduction">
        <MessagesFormError :messages="messagesFormError.general_basic_space_introduction" />
      </div>
    </LayoutInput>

    <div class="flex">
      <div class="w-64 mt-2">
        <LabelRequired />
        <i class="fa fa-puzzle-piece"></i>
        <span class="inline-block mx-1 font-bold">
          {{ $t("spaces_general_page.purpose_of_use") }}
        </span>
        <i class="fa fa-question-circle text-[#337ab7]" aria-hidden="true" data-reactid=".6.0"></i>
      </div>
      <div class="flex-1">
        <div v-for="(item, index) in formData.general_basic_space_purpose_of_uses.length" :key="index">
          <div class="flex mt-2">
            <select
              class="w-[420px] h-9 px-2 bg-white border border-solid border-[#ddd] rounded outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
              v-model="formData.general_basic_space_purpose_of_uses[index].main_category"
              @input="handleChange($event, index, formData.general_basic_space_purpose_of_uses[index].main_category)"
            >
              <option
                v-for="(itemMainCategory, indexMainCategory) in listMainCategoryPurposeOfUse"
                :key="indexMainCategory"
                :value="itemMainCategory.value"
                :selected="formData.general_basic_space_purpose_of_uses[index].main_category === itemMainCategory.value"
              >
                {{ itemMainCategory.label }}
              </option>
            </select>
            <select
              class="ml-2 w-[420px] h-9 px-2 bg-white border border-solid border-[#ddd] rounded outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
              v-model="formData.general_basic_space_purpose_of_uses[index].sub_category"
              :disabled="!formData.general_basic_space_purpose_of_uses[index].optionSubCategory?.length"
            >
              <option
                v-for="(itemSubCategory, indexSubCategory) in formData.general_basic_space_purpose_of_uses[index]
                  .optionSubCategory"
                :key="indexSubCategory"
                :value="itemSubCategory.value"
                :selected="formData.general_basic_space_purpose_of_uses[index].sub_category == itemSubCategory.value"
              >
                {{ itemSubCategory.label }}
              </option>
            </select>
            <div
              v-if="isShowBtnAddDelete"
              class="group ml-10 border-solid border border-[#d43f3a] rounded flex items-center justify-center h-9 w-9 hover:bg-[#d43f3a]"
              @click="() => ebbNumberPurpose(index)"
            >
              <i class="fa fa-trash text-[#d43f3a] group-hover:text-white" data-reactid=".e.0.$2.6.0.0"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--
    <div class="flex" v-if="messagesFormError.general_basic_space_introduction">
      <div class="w-64 mt-2"></div>
      <div class="flex-1">
        <MessagesFormError :messages="messagesFormError.general_basic_space_introduction" />
      </div>
    </div> -->

    <div class="flex mt-2">
      <div class="w-64"></div>
      <div class="">
        <button
          v-if="isShowBtnAddPurpose"
          class="bg-[#ffbd00] px-2 py-1 rounded hover:translate-y-[2px] transition-all"
          @click="handleIncreasePurpose"
        >
          <i class="fa fa-plus mr-1 text-white" data-reactid=".0.1.0"></i>
          <span class="text-white">
            {{ $t("spaces_general_page.add_purpose_of_use") }}
          </span>
        </button>
      </div>
    </div>
  </LayoutForm>
</template>

<script>
import LabelRequired from "@/components/LabelRequired";
import LayoutForm from "@/components/Layouts/LayoutForm.vue";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import MessagesFormError from "@/components/MessagesForm";
import { ref, watch, reactive, onMounted } from "vue";
import { OPTIONS_MAIN_CATEGORY, OPTIONS_SUB_CATEGORY } from "@/const";
import { getListPurposeOfUseByCategory } from "@/api";

export default {
  name: "BasicInformation",
  components: { LabelRequired, LayoutForm, LayoutInput, MessagesFormError },
  props: {
    messagesFormError: Object,
    modelValue: Object,
    idGeneral: [Number, String],
    statusValue: String,
  },
  emits: ["updateBasicInfo"],
  async setup(props, context) {
    const formData = reactive({
      general_basic_space_name_kana: null,
      general_basic_space_name_ja: null,
      general_basic_space_introduction: null,
      general_basic_space_overview: null,
      general_basic_space_purpose_of_uses: [
        {
          main_category: "",
          sub_category: "",
          optionSubCategory: [],
          title_ja: "",
        },
      ],
    });
    const listMainCategoryPurposeOfUse = reactive([
      {
        label: "-- メインカテゴリーを選択してください --",
        value: "",
      },
    ]);
    const handleChange = async (event, index, id) => {
      formData.general_basic_space_purpose_of_uses[index].optionSubCategory = [];
      const value = event ? event.target.value : id;
      const res = await getListPurposeOfUseByCategory(value, 1);
      if (value && res.data) {
        res.data.forEach((item) => {
          formData.general_basic_space_purpose_of_uses[index].optionSubCategory.push({
            label: item.title_ja,
            value: item.id,
          });
        });
      } else {
        formData.general_basic_space_purpose_of_uses[index].optionSubCategory = [];
      }
    };
    const handleGetDetailsPurposeOfUse = async () => {
      for (let i = 0; i < formData.general_basic_space_purpose_of_uses.length; i++) {
        await handleChange("", i, formData.general_basic_space_purpose_of_uses[i].main_category);
      }
    };
    const isShowBtnAddPurpose = ref(true);
    const isShowBtnAddDelete = ref(true);

    const handleIncreasePurpose = () => {
      if (formData.general_basic_space_purpose_of_uses.length == 4) return;
      formData.general_basic_space_purpose_of_uses.push({
        main_category: "",
        sub_category: "",
        optionSubCategory: [],
        title_ja: "",
      });
    };
    const ebbNumberPurpose = (index) => {
      if (formData.general_basic_space_purpose_of_uses.length == 1) return;
      formData.general_basic_space_purpose_of_uses.splice(index, 1);
    };
    async function getListPurposeOfUseByCategoryFromApi(id) {
      const res = await getListPurposeOfUseByCategory(id ? id : "use-purpose-category", 1);
      res.data
        .filter((item) => item.active == 1)
        .forEach((element) => {
          listMainCategoryPurposeOfUse.push({
            value: element.category_id + "-" + element.id,
            label: element.title_ja,
          });
        });
    }
    getListPurposeOfUseByCategoryFromApi();
    watch(
      formData,
      (val) => {
        if (val.general_basic_space_purpose_of_uses.length === 4) {
          isShowBtnAddPurpose.value = false;
          isShowBtnAddDelete.value = true;
        }
        if (val.general_basic_space_purpose_of_uses.length < 4) {
          isShowBtnAddPurpose.value = true;
          isShowBtnAddDelete.value = true;
        }
        if (val.general_basic_space_purpose_of_uses.length === 1) {
          isShowBtnAddDelete.value = false;
        }
        if (formData.general_basic_space_purpose_of_uses.length) {
          formData.general_basic_space_purpose_of_uses.forEach((item) => {
            item.title_ja = listMainCategoryPurposeOfUse.find((ele) => ele.value == item.main_category)
              ? listMainCategoryPurposeOfUse.find((ele) => ele.value == item.main_category).label
              : "";
          });
        }
      },
      { immediate: false, deep: true }
    );
    watch(
      () => props.modelValue,
      (val) => {
        formData.general_basic_space_name_kana = val.general_basic_space_name_kana;
        formData.general_basic_space_name_ja = val.general_basic_space_name_ja;
        formData.general_basic_space_introduction = val.general_basic_space_introduction;
        formData.general_basic_space_overview = val.general_basic_space_overview;
        if (!val.general_basic_space_purpose_of_uses.length) {
          return;
        }
        formData.general_basic_space_purpose_of_uses = val.general_basic_space_purpose_of_uses.map((item) => ({
          main_category: item.mainCategory,
          sub_category: item.subCategory,
          optionSubCategory: OPTIONS_SUB_CATEGORY[item.mainCategory],
        }));
      },
      { immediate: true }
    );
    onMounted(() => {
      watch(formData, () => {
        context.emit("updateBasicInfo", formData);
      });
    });
    await handleGetDetailsPurposeOfUse();
    return {
      handleIncreasePurpose,
      ebbNumberPurpose,
      isShowBtnAddPurpose,
      OPTIONS_SUB_CATEGORY,
      OPTIONS_MAIN_CATEGORY,
      formData,
      handleChange,
      isShowBtnAddDelete,
      getListPurposeOfUseByCategoryFromApi,
      listMainCategoryPurposeOfUse,
      handleGetDetailsPurposeOfUse,
    };
  },
};
</script>

<style scoped></style>
