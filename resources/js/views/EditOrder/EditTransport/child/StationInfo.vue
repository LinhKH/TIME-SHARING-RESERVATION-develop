<template>
  <div class="grid grid-cols-3 gap-2" v-if="listStationInfo.length">
    <div
      v-for="(stationInfo, indexStationInfo) in listStationInfo"
      :key="indexStationInfo"
      class="border border-solid border-[#ccc] w-full"
    >
      <div
        class="flex justify-between items-center text-[12px] bg-[#f5f5f5] border-b border-b-solid border-b-[#ccc] px-[15px] py-[3px]"
      >
        <div>
          <i :class="stationInfo.icon"></i>
          <span>{{ stationInfo.type_station || $t("transport.nearest_station_or_bus_stop") }}</span>
        </div>
        <div class="flex justify-between items-center">
          <div @click="changePosition('left', indexStationInfo)">
            <i
              class="fa fa-arrow-left py-[9px] px-[10px] border border-solid border-[#ccc] cursor-pointer rounded bg-white hover:bg-[#f5f5f5] mr-[5px]"
            ></i>
          </div>
          <div @click="changePosition('right', indexStationInfo)">
            <i
              class="fa fa-arrow-right py-[9px] px-[10px] border border-solid border-[#ccc] cursor-pointer rounded bg-white hover:bg-[#f5f5f5] mr-[5px]"
            ></i>
          </div>
          <div @click="() => handleAddListDelete(indexStationInfo)">
            <i
              class="fa fa-trash py-[9px] px-[10px] border border-solid border-[#ccc] cursor-pointer rounded bg-white hover:bg-[#f5f5f5] mr-[5px]"
            ></i>
          </div>
        </div>
      </div>
      <div class="p-[15px]">
        <div class="flex justify-between">
          <span class="flex-[1_1_0%] font-bold">{{
            stationInfo.type_station || $t("transport.nearest_station_or_bus_stop")
          }}</span>
          <div class="flex-[2_2_0%] h-16">
            <div class="w-full h-full relative" v-if="stationInfo.hasOwnProperty('is_new') && !!stationInfo.is_new">
              <InputArea
                class="w-full h-full"
                @input="(event) => getSuggestTransportFromApi(indexStationInfo, event.target.value)"
              />
              <ul
                class="absolute top-full w-full bg-white z-10 shadow"
                v-if="listStationFound[indexStationInfo].length"
              >
                <li
                  v-for="(itemStationFound, indexStationFound) in listStationFound[indexStationInfo]"
                  :key="indexStationFound"
                  class="p-2 hover:bg-[#eee] cursor-pointer"
                  @click="() => handleSelectStation(itemStationFound, indexStationInfo)"
                >
                  {{ itemStationFound.transportation_name }}
                </li>
              </ul>
            </div>
            <div v-else class="flex w-full h-full bg-white border border-solid border-[#ddd] rounded">
              <div class="flex-1 flex items-center px-2">
                {{ stationInfo.transportation_name }}
              </div>
              <div
                class="px-3 flex items-center border-l border-solid border-[#ddd] cursor-pointer"
                @click="() => handleRemoveSelect(indexStationInfo)"
              >
                <i class="fa fa-remove text-[15px] text-[#555]"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="flex justify-between mt-[5px]">
          <span class="flex-[1_1_0%] font-bold">{{ $t("transport.walking_time") }}</span>
          <div class="border border-solid border-[#ccc] rounded flex flex-[2_2_0%] justify-between">
            <InputNumber
              class="flex-1 border-none"
              :value="stationInfo.walking_duration"
              @onInput="(value) => (stationInfo.walking_duration = value)"
            />
            <div class="px-3 flex items-center border-l border-solid border-[#ccc]">
              {{ $t("transport.minutes") }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <button
    v-if="isShowButtonAddStation"
    class="p-2 border border-solid border-[#ddd] rounded bg-white block mt-2"
    @click="handleAddListStation"
  >
    <i class="fa fa-plus mr-1"></i>
    <span>{{ $t("transport.add_nearest_station") }}</span>
  </button>
  <div class="text-center w-[100%] mt-[8px]">
    <button
      class="border border-solid border-[#ccc] bg-[#ffbd00] rounded text-white p-[8px] hover:transition-all hover:translate-y-0.5 hover:opacity-1"
      @click="handlePostTransportation"
    >
      {{ $t("transport.keep") }}
    </button>
  </div>
</template>

<script>
import InputArea from "@/components/Form/InputArea.vue";
import InputNumber from "@/components/Form/InputNumber.vue";
import { getSuggestTransport, updateAndCreateTransportation, getAllTransportation, deleteTransportation } from "@/api";
import { TYPE_COMMON, MODULE_STORE, LIMIT_TRANSPORTATION } from "@/const";
import { useI18n } from "vue-i18n";
import { inject, ref, watch, reactive } from "vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";

export default {
  name: "StationInfo",
  components: { InputArea, InputNumber },

  setup() {
    const { t } = useI18n();
    const toast = inject("$toast");
    const listStationFound = reactive({});
    const listStationInfo = ref([]);
    const listStationDelete = ref([]);
    const store = useStore();
    const route = useRoute();
    const isShowButtonAddStation = ref(true);
    const idSpace = route.params.id;

    const initDataStation = {
      id_station: null,
      icon: "fa fa-question-circle mr-1",
      type_station: null,
      transportation_name: null,
      is_new: true,
      walking_duration: "",
      ref: "",
    };
    const handleAddListStation = () => {
      listStationFound[listStationInfo.value.length] = [];
      listStationInfo.value = [...listStationInfo.value, { ...initDataStation }].sort(
        (a, b) => b.walking_duration - a.walking_duration
      );
    };
    const handleAddListDelete = (indexStationInfo) => {
      if (listStationInfo.value[indexStationInfo]?.near_transportation_id) {
        listStationDelete.value.push({
          ...listStationInfo.value[indexStationInfo],
        });
      }
      listStationInfo.value.splice(indexStationInfo, 1);
    };
    watch(
      listStationInfo,
      () => {
        if (listStationInfo.value.length >= LIMIT_TRANSPORTATION) {
          isShowButtonAddStation.value = false;
        } else {
          isShowButtonAddStation.value = true;
        }
      },
      { immediate: true }
    );
    const getSuggestTransportFromApi = async (indexStationInfo, value) => {
      value = value.trim();
      if (!value) {
        listStationFound[indexStationInfo] = [];
        return;
      }
      try {
        const res = await getSuggestTransport({ name_transportation: value });
        if (res) {
          listStationFound[indexStationInfo] = res.data;
        }
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    const getInfoStation = (type) => {
      if (type == TYPE_COMMON.bus || type == TYPE_COMMON.tram)
        return {
          icon: "fa fa-bus text-[#06f] mr-1",
          type_station: t("transport.station_stop"),
        };
      if (type == TYPE_COMMON.subway || type == TYPE_COMMON.train || type == TYPE_COMMON.monorail)
        return {
          icon: "fa fa-subway text-[#0a0] mr-1",
          type_station: t("transport.station"),
        };
    };
    const handleSelectStation = (dataStationSelect, indexInListStation) => {
      const { icon, type_station } = getInfoStation(dataStationSelect.route);
      listStationInfo.value[indexInListStation] = {
        icon,
        type_station,
        transportation_name: dataStationSelect.transportation_name,
        is_new: false,
        walking_duration: "",
        id_station: dataStationSelect.id,
        ref: dataStationSelect.ref,
      };
      listStationFound[indexInListStation] = [];
    };

    const handleRemoveSelect = (indexStation) => {
      listStationInfo.value[indexStation] = { ...initDataStation };
    };
    const changePosition = (position, index) => {
      switch (position) {
        case "left":
          if (index) {
            const temp = JSON.parse(JSON.stringify(listStationInfo.value[index]));
            listStationInfo.value[index] = JSON.parse(JSON.stringify(listStationInfo.value[index - 1]));
            listStationInfo.value[index - 1] = JSON.parse(JSON.stringify(temp));
          }
          break;
        case "right":
          if (index < listStationInfo.value.length - 1) {
            const temp = JSON.parse(JSON.stringify(listStationInfo.value[index]));
            listStationInfo.value[index] = JSON.parse(JSON.stringify(listStationInfo.value[index + 1]));
            listStationInfo.value[index + 1] = JSON.parse(JSON.stringify(temp));
          }
          break;
      }
    };
    const deleteListStation = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await Promise.all(
          listStationDelete.value.map((item) => {
            const run = async () => await deleteTransportation(idSpace, item.near_transportation_id);
            return run();
          })
        );
        listStationDelete.value = [];
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const handlePostTransportation = async () => {
      if (listStationDelete.value.length) {
        deleteListStation();
      }
      if (listStationInfo.value.length) {
        const transportations = listStationInfo.value.map((item) => ({
          transportation_station_id: item.id_station,
          walking_duration: String(item.walking_duration),
          ref: item.ref,
        }));
        const params = {
          transportations,
        };
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          await updateAndCreateTransportation(idSpace, params);
        } catch (errors) {
          const error = errors.length ? errors[0]?.title : t("common.has_error");
          toast.error(error);
        }
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const initData = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getAllTransportation(idSpace);
        if (res.near_transportations.length) {
          const listStationConvert = res.near_transportations.map((item, index) => {
            const { icon, type_station } = getInfoStation(item.route);
            listStationFound[index] = [];
            return {
              icon,
              type_station,
              transportation_name: item.transportation_name,
              is_new: false,
              walking_duration: String(item.walking_duration),
              id_station: item.transportation_id,
              ref: "",
              near_transportation_id: item.near_transportation_id,
            };
          });
          listStationInfo.value = [...listStationInfo.value, ...listStationConvert];
        }
      } catch (errors) {
        const error = errors.msg || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    initData();
    return {
      handleRemoveSelect,
      getSuggestTransportFromApi,
      listStationFound,
      handleSelectStation,
      handleAddListStation,
      listStationInfo,
      handlePostTransportation,
      isShowButtonAddStation,
      handleAddListDelete,
      listStationDelete,
      changePosition,
    };
  },
};
</script>

<style></style>
