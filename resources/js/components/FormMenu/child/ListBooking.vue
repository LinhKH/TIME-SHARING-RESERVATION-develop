<template>
  <table class="mt-[20px] table w-full border border-solid border-[#ccc] border-collapse" cellspacing="1">
    <thead>
      <tr>
        <th
          class="border border-solid border-[#ccc] border-collapse p-2.5 text-start"
          v-for="(bookingHeaderItem, index) in listOfBookingsHeader"
          scope="col"
          :key="index"
        >
          {{ bookingHeaderItem }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(bookingsItem, index) in listOfBookings" :key="index" class="odd:bg-[#fffaf4]">
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start bg-[#fcf8e3]" scope="row">
          <span class="text-[#337ab7] cursor-pointer hover:underline">{{ bookingsItem.id }}</span>
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 bg-[#fcf8e3]">
          <span class="text-[#337ab7] cursor-pointer hover:underline"> {{ bookingsItem.user }}</span>
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 bg-[#fcf8e3]">
          <span class="text-[#337ab7] cursor-pointer hover:underline"> {{ bookingsItem.spaceUsed }}</span>
        </td>
        <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5 bg-[#fcf8e3]">
          {{ bookingsItem.usage }}
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 bg-[#fcf8e3]">
          <p>{{ bookingsItem.dateOfUse.date }}</p>
          <p>{{ bookingsItem.dateOfUse.day }}</p>
          <p>{{ bookingsItem.dateOfUse.time }}</p>
          <p>{{ bookingsItem.dateOfUse.descript }}</p>
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 bg-[#fcf8e3]">
          <i :class="bookingsItem.status.icon"></i>
          <spam>{{ bookingsItem.status.pendingApproval }}</spam>
          <p>{{ bookingsItem.status.requestReservation }}</p>
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-[#337ab7] bg-[#fcf8e3]">
          <div class="group">
            <p class="text-[#337ab7] group-hover:cursor-pointer group-hover:underline">
              {{ bookingsItem.reservationCompletion.date }}
            </p>
            <p class="text-[#337ab7] group-hover:cursor-pointer group-hover:underline">
              {{ bookingsItem.reservationCompletion.time }}
            </p>
          </div>
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 bg-[#fcf8e3]">
          {{ bookingsItem.useCoupon }}
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 bg-[#fcf8e3]">
          {{ bookingsItem.viaExternal }}
        </td>
        <td class="border border-solid border-[#ccc] border-collapse p-2.5 bg-[#fcf8e3] text-center">
          <button
            class="bg-white px-[12px] py-[7px] border border-solid border-[#37a200] text-[#37a200] rounded hover:text-white hover:bg-[#449d44] hover:border-[398439] transition-all"
          >
            {{ $t("dashboard.detail") }}
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "ListBooking",
  props: {
    listOfBookingsHeader: {
      type: Array,
      default: () => [],
    },
    listOfBookings: {
      type: Array,
      default: () => [],
    },
  },
};
</script>

<style></style>
