<template>
  <table class="mt-[20px] table w-full border border-solid border-[#ccc] border-collapse" cellspacing="1">
    <thead>
      <tr>
        <th
          class="border border-solid border-[#ccc] border-collapse p-2.5 text-start"
          v-for="(unansweredItem, index) in unansweredHeader"
          scope="col"
          :key="index"
        >
          {{ unansweredItem }}
        </th>
      </tr>
    </thead>
    <tbody class="text-center">
      <tr v-for="(unansweredInquirie, index) in unansweredInquiries" :key="index" class="odd:bg-[#f9f9f9] group">
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start" scope="row">
          <span class="text-[#337ab7] cursor-pointer hover:underline">{{ unansweredInquirie.id }}</span>
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5">
          <span class="text-[#337ab7] cursor-pointer hover:underline"> {{ unansweredInquirie.dateTime }}</span>
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5">
          <span class="text-[#337ab7] cursor-pointer hover:underline"> {{ unansweredInquirie.unansweredName }}</span>
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          {{ unansweredInquirie.inquiryAgent }}
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          {{ unansweredInquirie.initialResponse }}
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          {{ unansweredInquirie.inquiryReply }}
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          {{ unansweredInquirie.querySpaceName }}
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          <span class="text-[#337ab7] cursor-pointer hover:underline"> {{ unansweredInquirie.reservationSystem }}</span>
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          {{ unansweredInquirie.reservationSystem }}
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          <span class="text-[#337ab7] cursor-pointer hover:underline"> {{ unansweredInquirie.operatingCompany }}</span>
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5">
          <p>{{ unansweredInquirie.correspondence.value1 }}</p>
          <p>{{ unansweredInquirie.correspondence.value2 }}</p>
          <p>{{ unansweredInquirie.correspondence.value3 }}</p>
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          <select name="" id="" class="border border-solid border-[#ccc] border-radius block m-auto outline-none">
            <option value="">{{ unansweredInquirie.statusChange.option1 }}</option>
            <option value="">{{ unansweredInquirie.statusChange.option2 }}</option>
            <option value="">{{ unansweredInquirie.statusChange.option3 }}</option>
          </select>
          <input
            type="text"
            class="border border-solid border-[#ccc] border-radius block p-[4px] mt-[8px] w-[80%] m-auto outline-none"
            :placeholder="unansweredInquirie.statusChange.placeholder1"
          />
          <input
            type="text"
            class="border border-solid border-[#ccc] border-radius block p-[4px] mt-[8px] w-[80%] m-auto outline-none"
            :placeholder="unansweredInquirie.statusChange.placeholder1"
          />
          <button
            class="bg-white px-[12px] py-[7px] border border-solid border-[#37a200] text-[#37a200] rounded hover:text-white hover:bg-[#449d44] hover:border-[398439] transition-all mt-[8px]"
          >
            {{ $t("dashboard.keep") }}
          </button>
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
          <button
            class="bg-white px-[10px] py-[5px] border border-solid border-[#ccc] rounded hover:text-[#333] hover:bg-[#e6e6e6] hover:border-[#adadad] transition-all mt-[8px]"
          >
            <i class="fa fa-info-circle mr-[4px]"></i>
            <span>{{ $t("dashboard.detail") }}</span>
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "Unanswered",
  props: {
    unansweredHeader: {
      type: Array,
      default: () => [],
    },
    unansweredInquiries: {
      type: Array,
      default: () => [],
    },
  },
};
</script>

<style></style>
