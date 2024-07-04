<template>Search Tour</template>

<script>
export default {
  name: "SearchTour",
  setup() {
    const listSearchTour = ref([
      {
        id: 1,
        icon: "",
        type: "",
        title: "ステータス",
      },
    ]);
    return {
      listSearchTour,
    };
  },
};
</script>

<style></style>
