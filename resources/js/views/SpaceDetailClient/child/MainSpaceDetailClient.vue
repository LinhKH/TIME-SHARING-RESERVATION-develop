<template>
  <div class="mt-[12px] w-full h-full" id="images">
    <SlideShowImage :information="information" class="mb-[12px]" v-if="list_image.length" />
    <layout-lable :text="$t(`space_detail_client.space_introduction`)" />
    <div class="my-2">
      {{ space_introduction }}
    </div>
    <layout-lable :text="$t(`space_detail_client.use_type`)" />
    <div class="my-2">
      {{ purpose_of_uses }}
    </div>
    <layout-lable :text="$t(`space_detail_client.price_packet`)" />
    <div class="my-2">
      {{ price_plan }}
    </div>
    <template v-if="list_plan.length" id="payment_methods">
      <layout-lable :text="$t(`space_detail_client.payment_methods`)" />
      <div class="my-2">
        <table class="w-[100%]">
          <template v-for="plan in list_plan" :key="plan.rental_plan_id">
            <tr v-for="(payment, idx) in plan.payment_method" :key="idx">
              <td :rowspan="plan.payment_method.length" v-if="idx === 0" class="w-[50%] align-top">
                {{ plan.rental_plan_name }}
              </td>
              <td class="w-[50%]">{{ payment }}</td>
            </tr>
          </template>
        </table>
      </div>
    </template>
    <layout-lable :text="$t(`space_detail_client.space_information`)" id="space_information" />
    <div class="flex flex-wrap items-stretch my-2">
      <table class="w-[100%]">
        <tr v-if="getNearStationLabel && Object.keys(getNearStationLabel).length">
          <td>{{ $t("space_detail_client.space_info_descs.near_station") }}</td>
          <td>
            <div>
              <i :class="getInfoStation(getNearStationLabel.route)"></i>
              <span>{{
                `${getNearStationLabel.transportation_name} ${getNearStationLabel.walking_duration} ${$t(
                  "space_equip_inform_add.minutes"
                )}`
              }}</span>
              <a href="#show-map" class="ml-[4px]">
                <i class="fa fa-arrow-circle-o-down text-[#06f]"></i>
              </a>
            </div>
          </td>
        </tr>
        <tr>
          <td>{{ $t("space_detail_client.space_info_descs.available_people") }}</td>
          <td>{{ available_people }}</td>
        </tr>
        <tr>
          <td>{{ $t("spaces_general_page.breadth") }}</td>
          <td>{{ breadth_info }}</td>
        </tr>
        <template v-for="key in Object.keys(space_information)">
          <tr :key="key" v-if="typeof space_information[key] === 'string'">
            <td class="w-[50%]">
              {{ getSpaceInfoLabel(key) }}
            </td>
            <td class="w-[50%]">
              {{ getSpaceInfoValue(key, space_information[key]) }}
            </td>
          </tr>
        </template>
      </table>
    </div>
    <div class="m-[10px]">
      <div class="w-full h-full border-4 boder-solid border-[#ffbd00] py-[3px] px-[10px] rounded">
        <layout-lable :text="$t(`space_detail_client.access_map`)" id="show-map" />
        <div class="my-2">
          <div class="flex items-center mb-3">
            <span>{{ getAddress }}</span>
            <button class="button_copy ml-[]" id="btn-copy-to-clipboard" @click="copyAddressToClipboard()">
              {{ $t("common.copy_to_clipboard") }}
            </button>
          </div>
          <div class="flex items-center flex-wrap mb-[4px]">
            <div v-for="station in list_subway" :key="station.id">
              <i :class="getInfoStation(station.route)"></i>
              <span>{{
                `${station.transportation_name} ${station.walking_duration} ${$t("space_equip_inform_add.minutes")}`
              }}</span>
            </div>
          </div>
          <div class="flex items-center flex-wrap mb-[4px]">
            <div v-for="station in list_bus" :key="station.id">
              <i :class="getInfoStation(station.route)"></i>
              <span>{{
                `${station.transportation_name} ${station.walking_duration} ${$t("space_equip_inform_add.minutes")}`
              }}</span>
            </div>
          </div>
          <p v-if="getGoogleMap.length">
            <iframe
              :src="getGoogleMap"
              class="w-[100%] h-[600px]"
              style="border: 0"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </p>
        </div>
      </div>
    </div>
    <div class="m-[10px]">
      <div class="w-full h-full border-4 boder-solid border-[#ffbd00] py-[3px] px-[10px] rounded">
        <layout-lable :text="$t(`space_detail_client.schedule`)" />
        <div class="">
          {{ way_from_station }}
        </div>
      </div>
    </div>
    <div class="mb-[32px]" id="equip" v-if="Object.keys(general_equipment).length">
      <layout-lable :text="$t(`space_detail_client.general_equipment`)" />
      <div class="flex flex-wrap gap-[1%] items-stretch mt-[16px]">
        <template v-for="key in Object.keys(general_equipment)">
          <div
            class="w-[23%] h-full my-1 mr-[1%] py-[3px] text-[12px] md:w-[32%] lg:w-[23%] sm:w-[48%] euip-item"
            :class="{ false: !general_equipment[key] }"
            :key="key"
            v-if="typeof general_equipment[key] === 'boolean'"
          >
            <i class="fa mr-[5px]" :class="!general_equipment[key] ? 'fa-times' : 'fa-circle-o'"></i>
            <span :class="{ 'line-through': !general_equipment[key] }">{{ getGeneralEquipmentLabel(key) }}</span>
          </div>
        </template>
      </div>
    </div>
    <div class="mb-[32px]" v-if="Object.keys(broad_equipment).length">
      <layout-lable :text="$t(`space_detail_client.broad_equiment`)" />
      <div class="flex flex-wrap gap-[1%] items-stretch mt-[16px]">
        <template v-for="key in Object.keys(broad_equipment)">
          <div
            class="w-[23%] h-full my-1 mr-[1%] py-[3px] text-[12px] md:w-[32%] lg:w-[23%] sm:w-[48%] euip-item"
            :class="{ false: !broad_equipment[key] }"
            :key="key"
            v-if="typeof broad_equipment[key] === 'boolean'"
          >
            <i class="fa mr-[5px]" :class="!broad_equipment[key] ? 'fa-times' : 'fa-circle-o'"></i>
            <span :class="{ 'line-through': !broad_equipment[key] }">{{ getBroadEquipmentLabel(key) }}</span>
          </div>
        </template>
      </div>
    </div>
    <div class="mb-[32px]" v-if="Object.keys(film_equipment).length">
      <layout-lable :text="$t(`space_detail_client.film_equiment`)" />
      <div class="flex flex-wrap gap-[1%] items-stretch mt-[16px]">
        <template v-for="key in Object.keys(film_equipment)">
          <div
            class="w-[23%] h-full my-1 mr-[1%] py-[3px] text-[12px] md:w-[32%] lg:w-[23%] sm:w-[48%] euip-item"
            :class="{ false: !film_equipment[key] }"
            :key="key"
            v-if="typeof film_equipment[key] === 'boolean'"
          >
            <i class="fa mr-[5px]" :class="!film_equipment[key] ? 'fa-times' : 'fa-circle-o'"></i>
            <span :class="{ 'line-through': !film_equipment[key] }">{{ getFilmEquipmentLabel(key) }}</span>
          </div>
        </template>
      </div>
    </div>
    <div class="mb-[32px]" v-if="Object.keys(event_equipment).length">
      <layout-lable :text="$t(`space_detail_client.even_equiment`)" />
      <div class="flex flex-wrap gap-[1%] items-stretch mt-[16px]">
        <template v-for="key in Object.keys(event_equipment)">
          <div
            class="w-[23%] h-full my-1 mr-[1%] py-[3px] text-[12px] md:w-[32%] lg:w-[23%] sm:w-[48%] euip-item"
            :class="{ false: !event_equipment[key] }"
            :key="key"
            v-if="typeof event_equipment[key] === 'boolean'"
          >
            <i class="fa mr-[5px]" :class="!event_equipment[key] ? 'fa-times' : 'fa-circle-o'"></i>
            <span :class="{ 'line-through': !event_equipment[key] }">{{ getEventEquipmentLabel(key) }}</span>
          </div>
        </template>
      </div>
    </div>
    <div class="mb-[32px]" v-if="Object.keys(party_equipment).length">
      <layout-lable :text="$t(`space_detail_client.party_equiment`)" />
      <div class="flex flex-wrap gap-[1%] items-stretch mt-[16px]">
        <template v-for="key in Object.keys(party_equipment)">
          <div
            class="w-[23%] h-full my-1 mr-[1%] py-[3px] text-[12px] md:w-[32%] lg:w-[23%] sm:w-[48%] euip-item"
            :class="{ false: !party_equipment[key] }"
            :key="key"
            v-if="typeof party_equipment[key] === 'boolean'"
          >
            <i class="fa mr-[5px]" :class="!party_equipment[key] ? 'fa-times' : 'fa-circle-o'"></i>
            <span :class="{ 'line-through': !party_equipment[key] }">{{ getPartyEquipmentLabel(key) }}</span>
          </div>
        </template>
      </div>
    </div>
    <div class="mb-[32px]" v-if="Object.keys(share_equipment).length">
      <layout-lable :text="$t(`space_detail_client.share`)" />
      <div class="flex flex-wrap gap-[1%] items-stretch mt-[16px]">
        <template v-for="key in Object.keys(share_equipment)">
          <div
            class="w-[23%] h-full my-1 mr-[1%] py-[3px] text-[12px] md:w-[32%] lg:w-[23%] sm:w-[48%] euip-item"
            :class="{ false: !share_equipment[key] }"
            :key="key"
            v-if="typeof share_equipment[key] === 'boolean'"
          >
            <i class="fa mr-[5px]" :class="!share_equipment[key] ? 'fa-times' : 'fa-circle-o'"></i>
            <span :class="{ 'line-through': !share_equipment[key] }">{{ getShareEquipmentLabel(key) }}</span>
          </div>
        </template>
      </div>
    </div>
    <div v-if="list_page.length">
      <template v-for="page in list_page" :key="page.id">
        <div class="mb-[32px]" v-if="page.content.length" :id="page.title">
          <layout-lable :text="$t(`list_page.${page.title}`)">
            <i :class="[list_icons[page.title], 'fa-lg', 'mr-[8px]']"></i>
          </layout-lable>
          <span class="w-full h-full text-[14px] px-[15px] my-[30px] mt-[16px] leading-7 whitespace-pre-line break-all">
            {{ page.content }}
          </span>
        </div>
      </template>
    </div>
    <div v-else>
      <div class="mb-[32px]" id="term_of_use">
        <layout-lable :text="$t(`list_page.term_of_use`)">
          <i :class="[list_icons['term_of_use'], 'fa-lg', 'mr-[8px]']"></i>
        </layout-lable>
        <span class="w-full h-full text-[14px] px-[15px] my-[30px] mt-[16px] leading-7 whitespace-pre-line break-all">
          {{ term_of_use }}
        </span>
      </div>
      <div class="mb-[32px]" id="cancellation_policy">
        <layout-lable :text="$t(`list_page.cancellation_policy`)">
          <i :class="[list_icons['cancellation_policy'], 'fa-lg', 'mr-[8px]']"></i>
        </layout-lable>
        <span class="w-full h-full text-[14px] px-[15px] my-[30px] mt-[16px] leading-7 whitespace-pre-line break-all">
          {{ cancellation_policy }}
        </span>
      </div>
    </div>
    <div v-if="listSpace.length" class="mb-5">
      <layout-lable :text="$t(`space_detail_client.space_same_oner`)" />
      <div class="list-space-item flex flex-wrap mt-[24px]">
        <SpaceListItem :information="space" class="item-space" v-for="space in listSpace" :key="space.id" />
      </div>
    </div>
  </div>
</template>

<script>
import LayoutLable from "./LayoutLable.vue";
import SlideShowImage from "./SlideShowImage.vue";
import { computed } from "@vue/runtime-core";
import { OPTIONS_MAIN_CATEGORY, TYPE_COMMON } from "@/const";
import useEquipmentInformation from "@/uses/equipmentInformation";
import { useI18n } from "vue-i18n";
import { paymentMethodList } from "@/const/options";
import SpaceListItem from "./SpaceListItem.vue";
export default {
  name: "MainSpaceDetailClient",
  props: {
    information: {
      type: Object,
      default: () => ({}),
    },
    listSpace: {
      type: Array,
      default: () => [],
    },
  },
  components: {
    LayoutLable,
    SlideShowImage,
    SpaceListItem,
  },
  setup(props) {
    const { t } = useI18n();
    // icon
    const list_icons = {
      term_of_use: "fa fa-check",
      cancellation_policy: "fa fa-ban",
      prohibited_matter: "fa fa-times",
      faq: "fa fa-question-circle",
      notices: "fa fa-newspaper-o",
      note_from_space: "fa fa-list-ul",
      questions_from_space: "fa fa-question-circle",
    };

    // label equipment
    const {
      listFormBasicInformation,
      listFormGeneralEquipment,
      listFormConferenceEquipment,
      listFormShootingEquipment,
      listFormEventEquipment,
      listFromPartyEquipment,
      listFormShare,
    } = useEquipmentInformation();
    const fullLabel = [
      ...listFormBasicInformation,
      ...listFormGeneralEquipment,
      ...listFormShootingEquipment,
      ...listFromPartyEquipment,
    ];
    const getGeneralEquipmentLabel = (key) => listFormGeneralEquipment.find((c) => c.name == key)?.label || "";
    const getBroadEquipmentLabel = (key) => listFormConferenceEquipment.find((c) => c.name == key)?.label || "";
    const getFilmEquipmentLabel = (key) => listFormShootingEquipment.find((c) => c.name == key)?.label || "";
    const getEventEquipmentLabel = (key) => listFormEventEquipment.find((c) => c.name == key)?.label || "";
    const getPartyEquipmentLabel = (key) => listFromPartyEquipment.find((c) => c.name == key)?.label || "";
    const getShareEquipmentLabel = (key) => listFormShare.find((c) => c.name == key)?.label || "";
    const getSpaceInfoLabel = (key) => fullLabel.find((c) => c.name == key)?.label || "";
    const getSpaceInfoValue = (key, value) => {
      let result = "";
      const options = fullLabel.find((c) => c.name == key && c.options)?.options;
      if (options) {
        result = options.find((e) => e.value == value)?.label;
      } else {
        result = value;
      }
      return result;
    };

    // basic info
    const list_image = computed(() => props.information?.image || []);
    const space_introduction = computed(() => props.information?.general?.general_basic_space_introduction || "");
    const purpose_of_uses = computed(() => {
      let result = "";
      if (props.information?.general?.general_basic_space_purpose_of_uses?.length) {
        props.information.general.general_basic_space_purpose_of_uses.forEach((item, idx) => {
          if (idx !== 0) {
            result += ", ";
          }
          result += OPTIONS_MAIN_CATEGORY.find((c) => c.value === item.mainCategory)?.label;
        });
      }
      return result;
    });
    const price_plan = computed(() => props.information?.general?.general_space_information_plan_ja || "");
    const list_page = computed(() => props.information?.page || []);
    const available_people = computed(() => {
      let result = "";
      if (props.information?.general) {
        result += props.information.general.general_space_information_minimum_capacity;
        result += "~";
        result += props.information.general.general_space_information_maximum_capacity;
        result += ` ${t("reservation_register.information_customer.last_name")}`;
      }
      return result;
    });
    const breadth_info = computed(
      () => props.information?.general?.general_space_information_spaciousness_description_ja || ""
    );
    const term_of_use = computed(() => props.information?.general?.general_space_information_terms_of_service || "");
    const cancellation_policy = computed(
      () => props.information?.general?.general_space_information_cancellation_policy || ""
    );

    // near station
    const list_near_station = computed(() => props.information?.near_transporttation?.near_transportations || []);
    const getNearStationLabel = computed(() => {
      let result = {};
      if (list_near_station?.value?.length) {
        const newArr = list_near_station.value
          .filter(
            (c) => c.route === TYPE_COMMON.subway || c.route == TYPE_COMMON.train || c.route == TYPE_COMMON.monorail
          )
          .sort((a, b) => a.walking_duration - b.walking_duration);
        if (newArr.length) {
          result = newArr[0];
        }
      }
      return result;
    });
    const getInfoStation = (type) => {
      if (type == TYPE_COMMON.bus || type == TYPE_COMMON.tram) {
        return "fa fa-bus text-[#06f] mr-1";
      }
      if (type == TYPE_COMMON.subway || type == TYPE_COMMON.train || type == TYPE_COMMON.monorail) {
        return "fa fa-subway text-[#0a0] mr-1";
      }
    };
    const list_subway = computed(
      () =>
        list_near_station.value.filter(
          (c) => c.route === TYPE_COMMON.subway || c.route == TYPE_COMMON.train || c.route == TYPE_COMMON.monorail
        ) || []
    );
    const list_bus = computed(
      () => list_near_station.value.filter((c) => c.route === TYPE_COMMON.bus || c.route == TYPE_COMMON.tram) || []
    );
    // pay method
    const list_plan = computed(() => {
      let result = [];
      if (props.information?.plan) {
        Object.keys(props.information?.plan).forEach((key) => {
          const objPush = { ...props.information?.plan[key] };
          let list_payment = [];
          Object.keys(props.information?.plan[key]?.rental_detail).forEach((key2) => {
            if (key2.includes("payment_method_") && props.information?.plan[key]?.rental_detail[key2]) {
              list_payment.push(getPayMethodLabel(props.information?.plan[key]?.rental_detail[key2]));
            }
          });
          objPush["payment_method"] = list_payment;
          result.push(objPush);
        });
      }
      return result;
    });
    const getPayMethodLabel = (key) => paymentMethodList.find((c) => c.value == key)?.label || "";

    // map
    const getAddress = computed(() => {
      let result = "";
      if (props.information?.general) {
        result += props.information.general.general_location_prefecture;
        result += props.information.general.general_location_municipality;
        result += props.information.general.general_location_address_ja;
      }
      return result;
    });
    const getGoogleMap = computed(() => {
      let result = "";
      if (
        props.information?.general?.general_location_latitude &&
        props.information?.general?.general_location_longitude
      ) {
        result += `https://www.google.com/maps/embed/v1/place?q=${props.information?.general?.general_location_latitude},${props.information?.general?.general_location_longitude}&key=AIzaSyBNYj1s4bkyi_o6Kh94nxXZOnHJEEhfUHw`;
      }
      return result;
    });
    const way_from_station = computed(() => props.information?.general?.general_location_access_instruction_ja || "");
    const copyAddressToClipboard = async () => {
      await navigator.clipboard.writeText(getAddress.value);
    };

    // equipment
    const general_equipment = computed(() => props.information?.equipment?.equipmentGeneralInformation || {});
    const broad_equipment = computed(() => props.information?.equipment?.equipmentConferenceInformation || {});
    const film_equipment = computed(() => props.information?.equipment?.equipmentShootingInformation || {});
    const event_equipment = computed(() => props.information?.equipment?.equipmentEventInformation || {});
    const party_equipment = computed(() => props.information?.equipment?.equipmentPartyInformation || {});
    const share_equipment = computed(() => props.information?.equipment?.equipmentShareInformation || {});
    const space_information = computed(() => {
      return {
        ...props.information?.equipment?.equipmentBasicInformation,
        ...props.information?.equipment?.equipmentGeneralInformation,
        ...props.information?.equipment?.equipmentShootingInformation,
        ...props.information?.equipment?.equipmentPartyInformation,
      };
    });
    return {
      list_icons,
      // plan
      list_plan,
      // base infor
      space_introduction,
      purpose_of_uses,
      price_plan,
      list_page,
      available_people,
      breadth_info,
      term_of_use,
      cancellation_policy,
      list_image,

      // equipment
      general_equipment,
      broad_equipment,
      film_equipment,
      event_equipment,
      party_equipment,
      share_equipment,
      space_information,

      // label equipment
      getGeneralEquipmentLabel,
      getBroadEquipmentLabel,
      getFilmEquipmentLabel,
      getEventEquipmentLabel,
      getPartyEquipmentLabel,
      getShareEquipmentLabel,
      getSpaceInfoLabel,
      getSpaceInfoValue,

      // station
      getNearStationLabel,
      list_subway,
      list_bus,
      getInfoStation,

      // map
      getAddress,
      getGoogleMap,
      way_from_station,
      copyAddressToClipboard,
    };
  },
};
</script>

<style lang="scss" scoped>
.euip-item {
  color: #626262;
  i {
    color: #fc575e;
  }
  &.false {
    color: #cdc7c7;
    i,
    .line-through {
      color: #cdc7c7;
    }
  }
}
table {
  td {
    font-size: 12px;
  }
}
#btn-copy-to-clipboard {
  background-color: #ffbd00;
  color: #fff;
  border: 0;
  border-radius: 3px;
  margin-left: 8px;
  box-shadow: 0 2px 2px #888;
}
.list-space-item {
  gap: 16px;
  .item-space {
    width: calc(50% - 8px);
  }
}
</style>
