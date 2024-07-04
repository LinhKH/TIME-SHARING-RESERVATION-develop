<template>
  <table class="mt-[20px] table w-full" cellspacing="1">
    <thead>
      <tr class="border-b border-b-solid border-b-[#ccc] shadow-sm">
        <th
          class="border-collapse p-2.5 text-start first:w-[55%]"
          v-for="(saleMonthItem, index) in saleThisMonthHeader"
          scope="col"
          :key="index"
        >
          {{ saleMonthItem.title }}
          <i :class="saleMonthItem.icon" class="font-[15px]"></i>
        </th>
      </tr>
      <tr class="text-center border-b border-b-solid border-b-[#ccc] shadow-sm">
        <th
          class="border-b-solid-[#ccc] border-collapse p-2.5 first:w-[55%] first:text-start"
          v-for="(subSaleMonthItem, index) in subSaleMonthHeader"
          scope="col"
          :key="index"
        >
          {{ subSaleMonthItem }}
        </th>
      </tr>
    </thead>
    <tbody class="text-center">
      <tr v-for="(saleThisMonthItem, index) in saleThisMonth" :key="index">
        <td
          class="border-b border-b-solid border-b-[#ccc] border-collapse p-2.5 text-start w-[55%] font-bold"
          scope="row"
        >
          <span class="text-[#337ab7] cursor-pointer hover:underline">{{ saleThisMonthItem.spaceName }}</span>
        </td>
        <td
          class="border-b border-b-solid border-b-[#ccc] border-collapse p-2.5 text-center text-[#3c763d]"
          :class="[saleThisMonthItem.withoutTax1.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
          scope="row"
        >
          {{ saleThisMonthItem.withoutTax1.value
          }}<span
            class="ml-[2px]"
            :class="[saleThisMonthItem.withoutTax1.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
            >{{ $t("dashboard.circle") }}</span
          >
        </td>
        <td
          class="border-b border-b-solid border-b-[#ccc] border-collapse p-2.5 text-center text-[#3c763d]"
          :class="[saleThisMonthItem.taxIncluded1.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
          scope="row"
        >
          {{ saleThisMonthItem.taxIncluded1.value
          }}<span
            class="ml-[2px]"
            :class="[saleThisMonthItem.taxIncluded1.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
            >{{ $t("dashboard.circle") }}</span
          >
        </td>
        <td
          class="border-b border-b-solid border-b-[#ccc] border-collapse p-2.5 text-center text-[#3c763d]"
          :class="[saleThisMonthItem.withoutTax2.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
          scope="row"
        >
          {{ saleThisMonthItem.withoutTax2.value
          }}<span
            class="ml-[2px]"
            :class="[saleThisMonthItem.withoutTax2.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
            >{{ $t("dashboard.circle") }}</span
          >
        </td>
        <td
          class="border-b border-b-solid border-b-[#ccc] border-collapse p-2.5 text-center text-[#3c763d]"
          :class="[saleThisMonthItem.taxIncluded2.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
          scope="row"
        >
          {{ saleThisMonthItem.taxIncluded2.value
          }}<span
            class="ml-[2px]"
            :class="[saleThisMonthItem.taxIncluded2.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
            >{{ $t("dashboard.circle") }}</span
          >
        </td>
        <td
          class="border-b border-b-solid border-b-[#ccc] border-collapse p-2.5 text-center text-[#3c763d]"
          :class="[saleThisMonthItem.withoutTax3.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
          scope="row"
        >
          {{ saleThisMonthItem.withoutTax3.value
          }}<span
            class="ml-[2px]"
            :class="[saleThisMonthItem.withoutTax3.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
            >{{ $t("dashboard.circle") }}</span
          >
        </td>
        <td
          class="border-b border-b-solid border-b-[#ccc] border-collapse p-2.5 text-center text-[#3c763d]"
          :class="[saleThisMonthItem.taxIncluded3.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
          scope="row"
        >
          {{ saleThisMonthItem.taxIncluded3.value
          }}<span
            class="ml-[2px]"
            :class="[saleThisMonthItem.taxIncluded3.error ? 'text-[#a94442]' : 'text-[#3c763d]']"
            >{{ $t("dashboard.circle") }}</span
          >
        </td>
      </tr>
      <tr v-for="(totalItem, index) in total" :key="index">
        <td class="border-collapse p-2.5 text-start w-[55%] font-bold" scope="row">
          {{ $t("dashboard.total") }}
        </td>
        <td class="border-collapse p-2.5 text-center text-[#3c763d]" scope="row">
          {{ totalItem.withoutTax1 }}<span class="ml-[2px] text-[#3c763d]">{{ $t("dashboard.circle") }}</span>
        </td>
        <td class="border-collapse p-2.5 text-center text-[#3c763d]" scope="row">
          {{ totalItem.taxIncluded1 }}<span class="ml-[2px] text-[#3c763d]">{{ $t("dashboard.circle") }}</span>
        </td>
        <td class="border-collapse p-2.5 text-center text-[#3c763d]" scope="row">
          {{ totalItem.withoutTax2 }}<span class="ml-[2px] text-[#3c763d]">{{ $t("dashboard.circle") }}</span>
        </td>
        <td class="border-collapse p-2.5 text-center text-[#3c763d]" scope="row">
          {{ totalItem.taxIncluded2 }}<span class="ml-[2px] text-[#3c763d]">{{ $t("dashboard.circle") }}</span>
        </td>
        <td class="border-collapse p-2.5 text-center text-[#3c763d]" scope="row">
          {{ totalItem.withoutTax3 }}<span class="ml-[2px] text-[#3c763d]">{{ $t("dashboard.circle") }}</span>
        </td>
        <td class="border-collapse p-2.5 text-center text-[#3c763d]" scope="row">
          {{ totalItem.taxIncluded3 }}<span class="ml-[2px] text-[#3c763d]">{{ $t("dashboard.circle") }}</span>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "SaleMonth",
  props: {
    saleThisMonthHeader: {
      type: Array,
      default: () => [],
    },
    subSaleMonthHeader: {
      type: Array,
      default: () => [],
    },
    saleThisMonth: {
      type: Array,
      default: () => [],
    },
    total: {
      type: Array,
      default: () => [],
    },
  },
};
</script>

<style></style>
