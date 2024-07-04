<template>
  <div>
    <table class="mt-[20px] table w-full border border-solid border-[#ccc] border-collapse" cellspacing="1">
      <thead>
        <tr>
          <th
            class="border border-solid border-[#ccc] border-collapse p-2.5 text-start"
            v-for="(dashboardItem, index) in dashboardHeaders"
            scope="col"
            :key="index"
          >
            {{ dashboardItem }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(reservationsItem, index) in reservationsSales" :key="index" class="odd:bg-[#fffaf4] group">
          <th
            class="border border-solid border-[#ccc] border-collapse p-2.5 text-start bg-[#ff9966] group-hover:bg-[#ffff00]"
            scope="row"
          >
            {{ reservationsItem.numberReservation }}
          </th>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 bg-[#ff9966] group-hover:bg-[#ffff00]">
            {{ reservationsItem.total }}
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5">
            {{ reservationsItem.useCompleted }}
          </td>
          <td class="tour__content border border-solid border-[#ccc] border-collapse p-2.5">
            {{ reservationsItem.expectedUse }}
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5">
            {{ reservationsItem.useMonth1 }}
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5">
            {{ reservationsItem.useMonth2 }}
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5">
            {{ reservationsItem.useMonth3 }}
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5">
            {{ reservationsItem.from }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "Reservation",
  props: {
    dashboardHeaders: {
      type: Array,
      default: () => [],
    },
    reservationsSales: {
      type: Array,
      default: () => [],
    },
  },
};
</script>

<style></style>
