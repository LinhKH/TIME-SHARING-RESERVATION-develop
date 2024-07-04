<template>
  <div class="modal">
    <div class="modal__header">
      <div class="title">祝日リスト</div>
      <button @click="handleCloseModal" type="button" class="close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal__body">
      <div class="content p-[15px]">
        <div class="year-selection p-[10px]">
          <ul class="years-list flex">
            <li
              v-for="item in holidayList"
              class="year-item flex items-center cursor-pointer"
              :class="{ active: item == currentYear }"
              :key="item"
							@click="currentYear = item"
            >
              {{ item }}
            </li>
          </ul>
        </div>

        <div class="holiday-table">
          <table class="table-bordered">
            <thead>
              <tr>
                <th style="width: 1%">年</th>
                <th style="width: 1%">月</th>
                <th style="width: 1%">日</th>
                <th>祝日</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="row in currentList" :key="row.id">
                <td>
                  <strong>{{ row.year }}</strong>
                </td>
                <td>
                  <strong>{{ row.month }}</strong>
                </td>
                <td>
                  <strong>{{ row.day }}</strong>
                </td>
                <td>{{ row.name }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, computed, defineEmits } from "vue";
import {getListHoliday} from "@/api"

const emit = defineEmits(["close:modal"])
const holidayList = ref([]);
const holidayData = ref({})
const handleCloseModal = () => emit("close:modal")
const fetchHolidayList = async () => {
	try {
		const data = await getListHoliday()
		holidayData.value = data
		holidayList.value = Object.keys(data)
	} catch (error) {
		console.error(error);
	}
}
await fetchHolidayList()
const currentYear = ref(holidayList.value[holidayList.value.length - 1]);
const currentList = computed(() => holidayData.value[currentYear.value]);
</script>
<style lang="scss" scoped>
.modal {
  width: 600px;
  background: #fff;
  position: relative;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 6px;
  outline: 0;
  &__header {
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
    .title {
      font-size: 18px;
      font-weight: 500;
    }
    .close {
      position: absolute;
      right: 16px;
      top: 10px;
      font-size: 21px;
      font-weight: 700;
      line-height: 1;
      color: #000;
      text-shadow: 0 1px 0 #fff;
      filter: alpha(opacity=20);
      opacity: 0.2;
      &:hover {
        color: #000;
        text-decoration: none;
        cursor: pointer;
        filter: alpha(opacity=50);
        opacity: 0.5;
      }
    }
  }
  &__body {
    position: relative;
		height: 360px;
		overflow-y: auto;
    .table-bordered {
      border: 1px solid #ddd;
      td, th {
				text-align: left;
        border: 1px solid #ddd;
				padding: 5px;
      }
    }
    .year-item {
      height: 50px;
      padding: 5px;
      border: 1px solid #ccc;
      margin: 5px;
      border-radius: 4px;
      color: #337ab7;
      &.active {
        color: #fff;
        background-color: #337ab7;
      }
    }
  }
}
</style>
