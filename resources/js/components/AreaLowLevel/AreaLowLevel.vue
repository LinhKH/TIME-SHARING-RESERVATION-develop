<template>
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
        <tr v-for="item in dataTableAreaLow" :key="item.id" class="odd:bg-[#f9f9f9] group">
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start align-top" scope="row">
            <span>{{ item.idName }}</span>
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start align-top" scope="row">
            <div v-if="item.type == 'input'">
              <div v-for="itemInput in formData.inputSearch" :key="itemInput.id">
                <div v-if="!itemInput.isCheck" class="flex rounded border border-solid border-[#ddd]">
                  <div class="bg-[#eeeeee] border-r-[1px] px-3 py-2">
                    <i class="fa fa-search"></i>
                  </div>
                  <input
                    type="text"
                    name="name_area_ja"
                    placeholder="入力を始めると候補を表示します﻿"
                    :value="itemInput.valueInput"
                    class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded"
                  />
                </div>
                <div v-else class="flex rounded border border-solid border-[#ddd]">
                  <input
                    type="text"
                    name="name_area_ja"
                    :value="itemInput.valueInput"
                    class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded"
                  />
                  <div
                    class="bg-[#eeeeee] border-l-[1px] px-3 py-2 cursor-pointer"
                    @click="handleDelData(itemInput.id)"
                  >
                    <p class="font-bold">X</p>
                  </div>
                </div>
              </div>
              <div class="text-center">
                <div class="mt-2">
                  <button
                    class="bg-[#ffbd00] px-2 py-1 rounded hover:translate-y-[2px] transition-all"
                    @click="handleIncreaseZipMain"
                  >
                    <i class="fa fa-plus mr-1 text-white"></i>
                    <span class="text-white">
                      {{ $t("low_level_manager.btn_zip_code") }}
                    </span>
                  </button>
                </div>
              </div>
            </div>
            <div v-if="item.type == 'text'">
              {{ item.content }}
            </div>
            <div v-if="item.type == 'textArea'">
              <textarea
                rows="4"
                class="px-2 w-full outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
              ></textarea>
            </div>
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start align-top" scope="row">
            <div v-if="item.type == 'input'">
              <div v-for="itemInput in formData.inputSearchSubZip" :key="itemInput.id">
                <div class="flex rounded border border-solid border-[#ddd]">
                  <div class="bg-[#eeeeee] border-r-[1px] px-3 py-2">
                    <i class="fa fa-search"></i>
                  </div>
                  <input
                    type="text"
                    name="name_area_ja"
                    placeholder="入力を始めると候補を表示します﻿"
                    :value="itemInput.valueInputSubZip"
                    class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded"
                  />
                </div>
              </div>
              <div class="text-center">
                <div class="mt-2">
                  <button
                    class="bg-[#ffbd00] px-2 py-1 rounded hover:translate-y-[2px] transition-all"
                    @click="handleIncreaseSubZip"
                  >
                    <i class="fa fa-plus mr-1 text-white"></i>
                    <span class="text-white">
                      {{ $t("low_level_manager.btn_zip_code") }}
                    </span>
                  </button>
                </div>
              </div>
            </div>
            <div v-if="item.type == 'text'">
              {{ item.content }}
            </div>
            <div v-if="item.type == 'textArea'">
              <textarea
                rows="4"
                class="px-2 w-full outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
              ></textarea>
            </div>
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start align-top" scope="row">
            <div v-if="item.type == 'input'">
              <div v-for="itemInput in formData.inputSearchSearch" :key="itemInput.id">
                <div class="flex rounded border border-solid border-[#ddd]">
                  <input
                    type="text"
                    name="name_area_ja"
                    placeholder="キーワードを入力"
                    :value="itemInput.valueInputSearch"
                    class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded"
                  />
                  <div class="bg-[#eeeeee] border-l-[1px] px-3 py-2 cursor-pointer">
                    <p class="font-bold">X</p>
                  </div>
                </div>
              </div>
              <div class="text-">
                <div class="mt-2">
                  <button
                    class="bg-[#ffbd00] px-2 py-1 rounded hover:translate-y-[2px] transition-all"
                    @click="handleIncreaseSearch"
                  >
                    <i class="fa fa-plus mr-1 text-white"></i>
                    <span class="text-white">
                      {{ $t("low_level_manager.btn_zip_code") }}
                    </span>
                  </button>
                </div>
              </div>
            </div>
            <div v-if="item.type == 'text'">
              {{ item.content }}
            </div>
            <div v-if="item.type == 'textArea'">
              <textarea
                rows="4"
                class="px-2 w-full outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
              ></textarea>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="w-full h-full flex justify-center mt-[6px] gap-[50px]">
      <button
        class="block w-fit p-[8px] bg-[#ffbd00] text-white mr-3 rounded cursor-pointer hover:translate-y-1 transition-all"
        @click="handleChange"
      >
        {{ $t("medium_small_area_add.btn") }}
      </button>
    </div>
  </div>
</template>

<script>
import { ref, reactive } from "vue";
import { useI18n } from "vue-i18n";
import { ROUTER_PATH } from "@/const";
import { useRouter } from "vue-router";
import Input from "../Form/Input.vue";
export default {
  name: "AreaLowLevel",
  components: { Input },
  setup(props, context) {
    const { t } = useI18n();
    const router = useRouter();
    const hasValue = ref(false);
    const formData = reactive({
      inputSearch: [
        {
          id: 1,
          valueInput: "TEST",
          idName: "test",
          isCheck: true,
        },
        {
          id: 2,
          valueInput: "",
          isCheck: false,
        },
      ],
      inputSearchSubZip: [
        {
          id: 1,
          valueInputSubZip: "",
          isCheck: true,
        },
        {
          id: 2,
          valueInputSubZip: "",
          isCheck: false,
        },
      ],
      inputSearchSearch: [
        {
          id: 1,
          valueInputSearch: "",
          isCheck: true,
        },
        {
          id: 2,
          valueInputSearch: "",
          isCheck: false,
        },
      ],
    });
    const handleIncreaseZipMain = () => {
      const lastItem = formData.inputSearch[formData.inputSearch.length - 1];
      formData.inputSearch.push({
        id: lastItem.id + 1,
        valueInput: "",
      });
    };
    const handleIncreaseSubZip = () => {
      formData.inputSearchSubZip.push({
        valueInputSubZip: "",
      });
    };
    const handleIncreaseSearch = () => {
      formData.inputSearchSearch.push({
        valueInputSearch: "",
      });
    };
    const handleDelData = (id) => {
      formData.inputSearch.map((item) => {
        if ((item.id = id)) {
          item.isCheck = false;
          item.valueInput = "";
        }
      });
    };
    const tableHeader = [
      {
        id: 1,
        header: "",
        classWidth: "w-[20%]",
      },
      {
        id: 2,
        header: t("area_low_level_component.zip_code_main"),
        classWidth: "w-[30%]",
      },
      {
        id: 3,
        header: t("area_low_level_component.zip_code_sub"),
        classWidth: "w-[30%]",
      },
      {
        id: 4,
        header: t("area_low_level_component.search_key"),
        classWidth: "w-[20%]",
      },
    ];
    const dataTableAreaLow = ref([
      {
        id: 1,
        type: "input",
        idName: "test111",
      },
      {
        id: 2,
        type: "text",
        idName: "test111",
        content: "test",
      },
      {
        id: 3,
        type: "textArea",
        idName: "test111",
      },
    ]);
    const newDetail = ref({});
    const handleChange = () => {
      context.emit("update");
    };

    return {
      tableHeader,
      dataTableAreaLow,
      newDetail,
      formData,
      handleIncreaseSubZip,
      handleIncreaseZipMain,
      hasValue,
      handleDelData,
      handleIncreaseSearch,
      handleChange,
    };
  },
};
</script>

<style></style>
