<template>
  <div class="p-[10px]">
    <div class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-[10px] py-[12px] mb-[20px]">
      <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
      <span class="text-[12px] text-[#3c763d]">{{ idData.day }}{{ $t("reservation_register.report") }}</span>
    </div>
    <div v-for="item in dataFormReserved" :key="item.id">
      <LayoutInput :labelText="item.labelText" class="p-[5px] mb-[5px] border-b-[1px] border-[#ffbd00]">
        <div v-if="item.type === 'text'">
          {{ item.dataText }}
        </div>
        <div v-if="item.type === 'icon'">
          <i class="fa fa-university"></i>
          <span class="text-[#8a6d3b]">{{ item.dataText }}</span>
        </div>
        <div v-if="item.type === 'people'">{{ item.dataText }} 名</div>
        <div v-if="item.type === 'time'">
          <span>
            {{ item.dataText }}
          </span>
          -
          <span>
            {{ item.dataText1 }}
          </span>
        </div>
        <div v-if="item.type === 'money'">
          <span> {{ item.dataText }} {{ $t("dashboard.circle") }} ({{ $t("dashboard.without_tax") }}) </span>
          <span> {{ item.dataText1 }}{{ $t("dashboard.circle") }} ({{ $t("dashboard.tax_included") }}) </span>
        </div>
      </LayoutInput>
    </div>
  </div>
</template>

<script>
import { useRoute } from "vue-router";
import { ref, inject, computed, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import moment from "moment";
import { getReservationDetail } from "@/api";
import { useStore } from "vuex";
import { MODULE_STORE } from "@/const";
export default {
  name: "ReservationsReserved",
  components: { LayoutInput },
  setup() {
    const { t } = useI18n();
    const toast = inject("$toast");
    const store = useStore();
    const route = useRoute();
    const id = route.query.id;
    // console.log("idkjdasfk", id);
    const idData = route.query;
    const today = new Date();
    const hour = today.getHours();
    const hourToday = today.getMinutes();
    const getHour = today.getHours() < 10 ? `0${today.getHours()}` : `${today.getHours()}`;
    const getMinutes = today.getMinutes() < 10 ? `0${today.getMinutes()}` : `${today.getMinutes()}`;
    const stringDay = `${getHour}:${getMinutes}`;
    // const stringDay = moment(hourToday).format("hh:mm");
    // console.log("stringDay", getHour, getMinutes);
    const dateToday = moment(today).format("YYYY年MM月DD日");
    const reservationType = ref();
    const status = ref();
    const statusTilte = ref();
    const paymentTitle = ref();
    const dataFormReserved = ref([
      {
        id: 1,
        type: "text",
        labelText: t("reservation_register.label.type_reservation"),
        dataText: "",
      },
      {
        id: 2,
        type: "time",
        labelText: t("reservation_register.date_end"),
        dataText: dateToday,
        dataText1: stringDay,
      },
      {
        id: 3,
        type: "icon",
        labelText: t("reservation_register.status"),
        dataText: status.value,
      },
      {
        id: 4,
        type: "text",
        labelText: t("reservation_register.payment_methods_label"),
        dataText: t("reservation_register.payment_methods"),
      },
      {
        id: 5,
        type: "text",
        labelText: t("reservation_register.space_name"),
        dataText: t("reservation_register.site"),
      },
      {
        id: 6,
        type: "text",
        labelText: t("reservation_register.day_use"),
        dataText: idData.day,
      },
      {
        id: 7,
        type: "time",
        labelText: t("reservation_register.time_use"),
        dataText: idData.plan_less_start_time,
        dataText1: idData.plan_less_start_time,
      },
      {
        id: 8,
        type: "people",
        labelText: t("reservation_register.people"),
        dataText: idData.people_count,
      },
      {
        id: 9,
        type: "text",
        labelText: "利用目的",
        dataText: idData.people_count,
      },
      {
        id: 10,
        type: "text",
        labelText: "利用目的詳細",
        dataText: idData.use_purpose_category,
      },
      {
        id: 11,
        type: "text",
        labelText: "レンタルスペース利用料合計",
        dataText: idData.use_purpose_for_other,
      },
      {
        id: 12,
        type: "money",
        labelText: "オプション",
        dataText: idData.total_price_override_sans_tax,
        dataText1: idData.spacePriceVat,
      },
      {
        id: 13,
        type: "money",
        labelText: "オプション利用料合計",
        dataText: idData.limited_discount_price_sans_tax,
        dataText1: idData.moneyBeforeDiscount,
      },
      {
        id: 14,
        type: "money",
        labelText: "合計",
        dataText: idData.totalNoVATFinal,
        dataText1: idData.totalVATFinal,
      },
    ]);
    const convertTime = (dateValue) => {
      var dateFormat = new Date(dateValue * 1000);
      var year = dateFormat.getFullYear();
      var month = dateFormat.getMonth() + 1;
      var day = dateFormat.getDate();
      return `${year}年${year < 10 ? `0${month}` : month}月${day}日`;
    };
    const getInfoReservation = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getReservationDetail(id);
        reservationType.value = res.data?.proxy_reservation_type;
        if (res.data?.proxy_reservation_type === "web") {
          reservationType.value = " Web予約";
        }
        if (res.data?.proxy_reservation_type === "new_apply") {
          reservationType.value = "  電話予約(通常)";
        }
        if (res.data?.proxy_reservation_type === "extending") {
          reservationType.value = "電話予約(延長・追加)";
        }
        dataFormReserved.value[0].dataText = reservationType.value;

        if (res.data.rental_space?.status === "published") {
          statusTilte.value = "公開中";
        } else {
          statusTilte.value = "非公開";
        }
        dataFormReserved.value[2].dataText = statusTilte.value;
        if (res.data?.payment_method === "credit-card") {
          paymentTitle.value = "クレジットカード";
        }
        if (res.data?.payment_method === "bank-transfer") {
          paymentTitle.value = "銀行振込";
        }
        if (res.data?.payment_method === "cash-on-site") {
          paymentTitle.value = "当日現金払い";
        }
        if (res.data?.payment_method === "Paid") {
          paymentTitle.value = "Paid";
        }
        if (res.data?.payment_method === "choose-later-by-customer") {
          paymentTitle.value = "お客様の支払い方法の選択";
        }

        dataFormReserved.value[3].dataText = paymentTitle.value;
        dataFormReserved.value[4].dataText = res.data?.rental_space?.rental_space_eav?.find(
          (item) => item.attribute == "generalBasicSpaceNameJa"
        ).value;
        var valueTime = convertTime(res.data?.creation_time);
        dataFormReserved.value[5].dataText = valueTime;
        dataFormReserved.value[6].dataText = res.data?.planless_start_time;
        dataFormReserved.value[6].dataText1 = res.data?.planless_end_time;
        dataFormReserved.value[7].dataText = res.data?.people_count;
        dataFormReserved.value[8].dataText = res.data?.use_purpose_category;
        dataFormReserved.value[9].dataText = res.data?.use_purpose_for_other;
        dataFormReserved.value[9].dataText = res.data?.use_purpose_for_other;
        dataFormReserved.value[9].dataText = res.data?.use_purpose_for_other;
        dataFormReserved.value[11].dataText = res.data?.total_price_sans_tax;
        dataFormReserved.value[13].dataText = res.data?.total_price_sans_tax;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    onMounted(async () => {
      await getInfoReservation();
    });
    return {
      idData,
      dataFormReserved,
      today,
      dateToday,
      stringDay,
      getInfoReservation,
      status,
      reservationType,
      convertTime,
      statusTilte,
      paymentTitle,
    };
  },
};
</script>
<style></style>
