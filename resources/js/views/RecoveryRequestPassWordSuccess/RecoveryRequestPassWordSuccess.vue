<template>
  <div class="h-[50px] w-full">
    <a href="/admin/login" rel="noopener noreferrer">
      <img :src="logoTimeSharing" alt="Log" class="h-4/5 ml-3" />
    </a>
  </div>
  <hr />
  <div id="content">
    <h1>パスワードをリセットしました！ パスワード情報が記載されたメールを確認してください。</h1>
  </div>
</template>

<script>
import logoTimeSharing from "@/assets/images/time_sharing_logo.png";

export default {
  name: "RecoveryRequestPassWordSuccess",

  computed: {
    logoTimeSharing() {
      return logoTimeSharing;
    },
  },
};
</script>

<style scoped>
h1 {
  text-align: center;
  font-weight: 500;
  padding-top: 20px;
  font-size: 15px;
}
</style>
