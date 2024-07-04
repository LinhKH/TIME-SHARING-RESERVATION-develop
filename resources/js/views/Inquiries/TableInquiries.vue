<template>
  <table class="w-full">
    <thead>
      <tr class="">
        <th class="border py-1 w-[5%]">{{ $t("list_inquiries_page.query_id") }}</th>
        <th class="border py-1 w-[10%]">
          {{ $t("list_inquiries_page.date_time") }}
        </th>
        <th class="border py-1 w-[5%]">
          {{ $t("list_inquiries_page.name") }}
        </th>
        <th class="border py-1 w-[5%]">
          {{ $t("list_inquiries_page.inquiry_agent") }}
        </th>
        <th class="border py-1 w-[5%]">
          {{ $t("list_inquiries_page.initial_inquiry_response") }}
        </th>
        <th class="border py-1 w-[5%]">
          {{ $t("list_inquiries_page.inquiry_reply") }}
        </th>
        <th class="border py-1 w-[5%]">
          {{ $t("list_inquiries_page.completed") }}
        </th>
        <th class="border py-1 w-[20%]">
          {{ $t("list_inquiries_page.query_space_name") }}
        </th>
        <th class="border py-1 w-[5%]">
          {{ $t("list_inquiries_page.reservation_system") }}
        </th>
        <th class="border py-1 w-[5%]">
          {{ $t("list_inquiries_page.company") }}
        </th>
        <th class="border py-1 w-[10%]">
          {{ $t("list_inquiries_page.correspondence") }}
        </th>
        <th class="border py-1 w-[10%]">
          {{ $t("list_inquiries_page.status_change") }}
        </th>
        <th class="border py-1 w-[5%]"></th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="item in listData" :key="item.id" class="text-center">
        <td class="border">
          <span class="text-[#337ab7] cursor-pointer break-all" @click="redirectPageDetail(item.id)">{{
            item.id
          }}</span>
        </td>
        <td class="border">
          <span class="text-[#337ab7] cursor-pointer break-all" @click="redirectPageDetail(item.id)">
            {{ item.created_at }}
          </span>
        </td>
        <td class="border">
          <span class="text-[#337ab7] cursor-pointer break-all" @click="goToCustomerView(item.customer_id)">{{
            getCustomerName(item.customer)
          }}</span>
        </td>
        <td class="border">{{ listData.inquiryAgent }}</td>
        <td class="border">
          {{ listData.initialInquiryResponse }}
        </td>
        <td class="border">
          {{ listData.lastInquiry }}
        </td>
        <td class="border p-2">
          {{ item.support_done === 1 ? $t("list_inquiries_page.complete") : $t("list_inquiries_page.incomplete") }}
        </td>
        <td class="border p-2">
          <span class="text-[#337ab7] cursor-pointer break-all" @click="redirectPageDetail(item.id)">
            {{ item.namespace }}
          </span>
        </td>
        <td class="border">
          <div v-for="reservationItem in item.correspondence" :key="reservationItem">
            <p>{{ reservationItem }}</p>
          </div>
        </td>
        <td class="border">
          <span class="text-[#337ab7] cursor-pointer break-all" @click="redirectPageDetail(item.id)">
            {{ item.customer.company_name }}
          </span>
        </td>
        <td class="border text-right">{{ listData.correspondence }}</td>
        <td class="border"><FormStatus /></td>
        <td class="border text-center">
          <a class="btn-detail" href="#" @click="redirectPageDetail(item.id)">
            <i class="fa fa-info-circle mr-1 text-[#333]" aria-hidden="true"></i>
            <span class="leading-8">{{ $t("list_inquiries_page.detailed") }}</span>
          </a>
        </td>
      </tr>
    </tbody>
  </table>
</template>
<script>
import { ref } from "vue";
import FormStatus from "./FormStatus.vue";
import { ROUTER_PATH } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
export default {
  props: {
    listData: { type: Object, default: () => [] },
  },
  components: { FormStatus },
  setup(props) {
    const { t } = useI18n();
    const router = useRouter();

    const listStatus = ref({
      notSupported: "未対応",
      supported: "対応中",
      Resolved: "対応済み",
    });
    const redirectPageDetail = (id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.INQUIRIES_DETAIL}?id=${id}`);
    };
    const goToCustomerView = (customer_id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CUSTOMER_VIEW}/${id}`);
    };
    const getCustomerName = (customer) => {
      let result = "";
      if (customer.last_name) {
        result += customer.last_name;
      }
      if (customer.first_name) {
        result += " ";
        result += customer.first_name;
      }
      return result;
    };
    return { listStatus, getCustomerName, redirectPageDetail, goToCustomerView };
  },
};
</script>
<style lang="scss" scoped>
.btn-detail {
  color: #333;
  background-color: #fff;
  padding: 5px 10px;
  font-size: 12px;
  line-height: 1.5;
  border-radius: 3px;
  border: 1px solid #ccc;
}
.btn-detail:hover {
  color: #333;
  background-color: #e6e6e6;
  border-color: #adadad;
}
</style>
