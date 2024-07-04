<template>
  <div class="border border-[#dbdbdb] border-solid rounded h-full px-2 cursor-pointer" @click="$emit('onExportFile')">
    <i class="fa fa-file mr-1" aria-hidden="true"></i>
    <span class="leading-8">
      {{ $t("list_user_manage_page.csv_download_list") }}
    </span>
  </div>
</template>

<script>
export default {
  name: "ButtonDownloadCSV",

  data() {
    return {};
  },

  mounted() {},

  methods: {},
};
</script>

<style scoped></style>
