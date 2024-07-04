<template>
  <LayoutInput
    :iconPrev="itemForm.iconPrev"
    :labelText="itemForm.label"
    v-for="(itemForm, index) in listForm"
    :key="index"
    :isRequired="itemForm.isRequired"
    :customCss="`mb-4`"
  >
    <template v-if="itemForm.type === TYPE_COMMON.twoSelect">
      <div class="flex">
        <Select
          class="mr-4"
          :inputKey="`main_category`"
          :optionsSelect="itemForm.optionLeft"
          @changeValue="(data) => (formData[data.key] = data.value)"
        ></Select>
        <Select
          :inputKey="`sub_category`"
          :optionsSelect="itemForm.optionRight"
          :disabled="itemForm.optionRight?.length == 0"
          @changeValue="(data) => (formData[data.key] = data.value)"
        ></Select>
      </div>
    </template>

    <template v-if="itemForm.type === TYPE_COMMON.select">
      <Select :inputKey="`test_key_333`" :optionsSelect="itemForm.option"></Select>
    </template>

    <template v-if="itemForm.type === TYPE_COMMON.text">
      <div class="min-w-fit w-3/5 relative">
        <Input class="cursor-pointer" />
      </div>
    </template>

    <template v-if="itemForm.type === TYPE_COMMON.multipleSelect">
      <Select
        class="mr-4"
        :inputKey="`test_key_1`"
        :optionsSelect="itemForm.option"
        @changeValue="(data) => (formData[data.key] = data.value)"
        :multiple="true"
        :size="10"
      ></Select>
    </template>

    <template v-if="itemForm.type === TYPE_COMMON.inputTextSelect">
      <div class="min-w-fit w-full relative">
        <Select
          class="mr-4"
          :inputKey="`main_category`"
          :optionsSelect="itemForm.option"
          @changeValue="(data) => (formData[data.key] = data.value)"
        ></Select>
      </div>
    </template>

    <template v-if="itemForm.type === TYPE_COMMON.radio">
      <InputRadio :optionProps="itemForm.option" />
    </template>

    <template v-if="itemForm.type === TYPE_COMMON.datePicker">
      <div class="flex h-8">
        <div class="min-w-[330px] mr-5 flex border border-solid border-[#ccc] rounded">
          <div
            class="w-8 border-r border-solid border-[#ccc] bg-[#eee] flex items-center justify-center rounded-tl rounded-bl"
          >
            <i class="fa fa-calendar"></i>
          </div>
          <div class="px-2 border-r border-solid border-[#ccc] bg-[#eee] leading-8">開始日</div>
          <div class="flex-1">
            <Datepicker v-model="formData.start_date" />
          </div>
        </div>
        <div class="min-w-[330px] mr-5 flex border border-solid border-[#ccc] rounded">
          <div
            class="w-8 border-r border-solid border-[#ccc] bg-[#eee] flex items-center justify-center rounded-tl rounded-bl"
          >
            <i class="fa fa-calendar"></i>
          </div>
          <div class="px-2 border-r border-solid border-[#ccc] bg-[#eee] leading-8">開始日</div>
          <div class="flex-1">
            <Datepicker v-model="formData.end_date" />
          </div>
        </div>
        <div class=""></div>
      </div>
    </template>

    <template v-if="itemForm.type === TYPE_COMMON.checkBox">
      <CheckBox :option="itemForm.option" />
    </template>
  </LayoutInput>
  <div class="flex justify-start mb-4">
    <button class="border border-solid border-[#ddd] rounded p-2 bg-white">
      <i class="fa fa-search mr-1" aria-hidden="true"></i>
      <span>検索</span>
    </button>
  </div>
  <hr />
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import Select from "@/components/Form/Select.vue";
import InputRadio from "@/components/Form/InputRadio.vue";
import CheckBox from "@/components/Form/CheckBox.vue";
import Input from "@/components/Form/Input.vue";
import { OPTIONS_MAIN_CATEGORY, OPTIONS_SUB_CATEGORY, TYPE_COMMON, MODULE_STORE, ROUTER_PATH } from "@/const";
import { reactive, ref, watch, computed, inject } from "vue";
import Datepicker from "vue3-datepicker";
import { getListLocation } from "@/api";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";

export default {
  name: "FormFilter",
  components: { Datepicker, LayoutInput, Select, Input, InputRadio, CheckBox },
  setup() {
    const store = useStore();
    const toast = inject("$toast");
    const formData = reactive({
      main_category: "",
      sub_category: "",
      start_date: new Date(),
      end_date: new Date(),
    });
    const convertObjectSubCategory = ref([]);
    const isShowOptionAddress = ref(false);
    watch(
      () => formData.main_category,
      () => {
        if (formData.main_category) {
          convertObjectSubCategory.value = OPTIONS_SUB_CATEGORY[formData.main_category];
        } else {
          convertObjectSubCategory.value = [];
          formData.sub_category = "";
        }
      }
    );
    const optionLocation = ref([]);
    const optionPrefectures = [
      {
        label: "北海道",
        value: "北海道",
      },
      {
        label: "青森県",
        value: "青森県",
      },
      {
        label: "岩手県",
        value: "岩手県",
      },
      {
        label: "宮城県",
        value: "宮城県",
      },
      {
        label: "秋田県",
        value: "秋田県",
      },
      {
        label: "山形県",
        value: "山形県",
      },
      {
        label: "福島県",
        value: "福島県",
      },
      {
        label: "茨城県",
        value: "茨城県",
      },
      {
        label: "栃木県",
        value: "栃木県",
      },
      {
        label: "群馬県",
        value: "群馬県",
      },
      {
        label: "埼玉県",
        value: "埼玉県",
      },
      {
        label: "千葉県",
        value: "千葉県",
      },
    ];
    const optionSpecialFeature = [
        {
        label: "あり（予約システム公開中のみ）",
        value: "1",
      },
      {
        label: "なし（予約システム非公開か、予約システム公開中で公開プランなし、予約システム公開中で公開プランあり公開予約枠なし",
        value: "2",
      },
      {
        label: "なし",
        value: "3",
      },
      {
        label: "すべて",
        value: "4",
      },
    ]
    const optionTest = [
      {
        label: "あり",
        value: "1",
      },
      {
        label: "なし",
        value: "2",
      },
      {
        label: "すべて",
        value: "3",
      },
    ];
    const optionPublicStatus =[
      {
        label: "公開",
        value: "1",
      },
      {
        label: "非公開",
        value: "2",
      },
      {
        label: "公開審査中",
        value: "3",
      },
    ]
    const optionSort = [
         {
        label: "最終更新日時（新しい順）",
        value: "最終更新日時（新しい順）",
      },
      {
        label: "最終更新日時（古い順）",
        value: "最終更新日時（古い順）",
      },
      {
        label: "ポイント合計（多い順）",
        value: "ポイント合計（多い順）",
      },
      {
        label: "ポイント合計（少ない順）",
        value: "ポイント合計（少ない順）",
      },
      {
        label: "合計金額",
        value: "合計金額",
      },
      {
        label: "口コミ数",
        value: "口コミ数",
      },
      {
        label: "画像枚数(多い順)",
        value: "画像枚数(多い順)",
      },
        {
        label: "スペースの表示順",
        value: "スペースの表示順",
      },
        {
        label: "ランキング順",
        value: "ランキング順",
      },
    ]
    const getLocation = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListLocation();
        optionLocation.value = res.data.map((e) => {
          return {
            label: e.name,
            value: e.id,
          };
        });
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getLocation();
    const listForm = computed(() => [
      {
        label: "利用目的",
        iconPrev: "fa fa-puzzle-piece mr-1",
        type: TYPE_COMMON.twoSelect,
        optionLeft: OPTIONS_MAIN_CATEGORY,
        optionRight: convertObjectSubCategory.value,
      },
      {
        label: "都道府県",
        iconPrev: "fa fa-map-marker mr-1",
        type: TYPE_COMMON.multipleSelect,
        option: optionPrefectures,
      },
      {
        label: "ロケーション範囲",
        iconPrev: "fa fa-map-marker mr-1",
        type: TYPE_COMMON.inputTextSelect,
        option: optionLocation.value,
      },
      {
        label: "キーワード",
        iconPrev: "fa fa-font mr-1",
        type: TYPE_COMMON.text,
      },
      {
        label: "会社・団体名",
        iconPrev: "fa fa-font mr-1",
        label: "スペース名",
        type: TYPE_COMMON.text,
      },
      {
        type: TYPE_COMMON.text,
        iconPrev: "fa fa-font mr-1",
        label: "スペース名",
      },
      {
        label: "スペース名（カナ）",
        iconPrev: "fa fa-font mr-1",
        type: TYPE_COMMON.text,
      },
      {
        label: "特集（予約システム導入 or HP埋込あり or スペなび限定価格）",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionSpecialFeature,
      },
      {
        label: "特集（女子会）",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "特集（ママ会）",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "特集（スペなびカメラマン撮影）",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "特集（カレンダー常時反映スペース）",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "特集（課金NG）",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "PartySpace掲載",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "特集（ケータリング推奨スペース）",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "スペなび内検索除外",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "Googleからの検索",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "問合せ代行",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "ネット予約",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "取材",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "HP埋め込み",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "公開ステータス",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionPublicStatus,
      },
      {
        label: "動画登録",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "360度写真",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "スペース名（カナ）",
        iconPrev: "fa fa-star-o mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "掲載経路",
        iconPrev: "fa fa-link mr-1",
        type: TYPE_COMMON.checkBox,
        option: optionTest,
      },
      {
        label: "予約方法",
        iconPrev: "fa fa-tasks mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "見学",
        iconPrev: "fa fa-eye mr-1",
        type: TYPE_COMMON.radio,
        option: optionTest,
      },
      {
        label: "支払い方法",
        iconPrev: "fa fa-money mr-1",
        type: TYPE_COMMON.checkBox,
        option: optionTest,
      },
      {
        label: "Googleカレンダー同期",
        iconPrev: "fa fa-calendar mr-1",
        type: TYPE_COMMON.checkBox,
        option: optionTest,
      },
      {
        label: "外観・入り口写真",
        iconPrev: "fa fa-photo mr-1",
        type: TYPE_COMMON.checkBox,
        option: optionTest,
      },
      {
        label: "図面写真",
        iconPrev: "fa fa-photo mr-1",
        type: TYPE_COMMON.checkBox,
        option: optionTest,
      },
      {
        label: "以下で並べ替え",
        iconPrev: "fa fa-sort mr-1",
        type: TYPE_COMMON.select,
        option: optionSort,
        isRequired: true,
      },
      {
        label: "最終更新日（期間）",
        type: TYPE_COMMON.datePicker,
      },
    ]);
    return {
      isShowOptionAddress,
      formData,
      OPTIONS_MAIN_CATEGORY,
      listForm,
      TYPE_COMMON,
      optionLocation,
      optionPrefectures,optionPublicStatus,optionSort
    };
  },
};
</script>

<style scoped>
/deep/ .v3dp__datepicker,
/deep/ .v3dp__input_wrapper,
/deep/ .v3dp__input_wrapper input {
  width: 100%;
  height: 100%;
  outline: none;
  padding-left: 4px;
}
/deep/ .v3dp__popout {
  bottom: 100%;
}
</style>
