<template>
  <div>
    <ul class="list-space">
      <li v-for="item in props.listSpace" :key="item.id" @click="handlePush(item.id)" class="space-item">
        <a>{{ item.title }}</a>
      </li>
    </ul>
  </div>
</template>
<script setup>
import { defineProps } from "vue";
import { useRouter } from "vue-router";
const props = defineProps({
  listSpace: Object,
});

const router = useRouter();

const handlePush = (id) => {
  router.push({ name: "GoogleCalendar", params: { id } });
};
</script>
<style lang="scss" scoped>
.list-space {
  padding-left: 30px;
  padding-top: 5px;
  padding-bottom: 5px;
  .space-item {
    list-style-type: disc;
    a {
      font-size: 12px;
      color: #337ab7;
      text-decoration: none;
      &:hover {
        text-decoration: underline;
      }
    }
  }
}
</style>
