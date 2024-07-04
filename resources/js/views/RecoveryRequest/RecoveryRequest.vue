<template>
  <div class="h-[50px] w-full">
    <a href="/admin/login" rel="noopener noreferrer">
      <img :src="logoTimeSharing" alt="Log" class="h-4/5 ml-3" />
    </a>
  </div>
  <hr />
  <div id="content">
    <div class="panel panel-primary">
      <div class="h-12 w-full bg-[#555555] flex items-center justify-center text-base text-white panel-heading">
        パスワードの再設定
      </div>
      <div class="panel-body">
        <p v-if="isEmailExist">このメールアドレスのユーザーが見つかりません。</p>
        <form>
          <div class="control-group form-group row">
            <div class="col-lg-12">
              <div id="input-email">
                <p class="control-label" for="email">メールアドレス</p>
                <input class="form-control" required type="email" v-model="email" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <button type="button" @click="handleResetPassWordUser" class="btn btn-primary">パスワードの再設定</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import logoTimeSharing from "@/assets/images/time_sharing_logo.png";
import { resetPassWordUser } from "@/api";
import { MODULE_STORE } from "@/const";
import { isEmpty } from "lodash";
import { ROUTER_PATH } from "@/const";

export default {
  name: "RecoveryRequest",

  data() {
    return {
      dataLogin: {},
      email: "",
      isEmailExist: false,
    };
  },

  computed: {
    logoTimeSharing() {
      return logoTimeSharing;
    },
  },

  methods: {
    async handleResetPassWordUser() {
      if (isEmpty(this.email)) {
        return;
      }
      try {
        this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

        const response = await resetPassWordUser(this.email);

        if (response.status == 200) {
          this.$toast.success(this.$t("パスワードはリセットしました。"));

          return this.$router.push(ROUTER_PATH.RECOVERY_REQUEST_SUCCESS);
        } else if (response.status == 404) {
          this.$toast.error("メールアドレスが存在しません。");
          this.isEmailExist = true;
        } else if (response.status == 500) {
          this.$toast.error("システムでエラーが発生しました。");
          this.isEmailExist = true;
        }
      } catch (errors) {
        const error = errors.msg || errors.message || t("common.has_error");

        return this.$toast.error(error);
      } finally {
        this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    },
  },
};
</script>

<style scoped>
#content {
  display: flex;
  justify-content: center;
}

/* #input-email {
  border: solid 1px;
} */

button {
}
.btn-primary {
  display: inline-block;
  background: #ffbd00;
  color: #fff;
  box-shadow: 0 1px 1px #a4966e;
  border: 0;
  text-decoration: none;
}
.btn {
  display: inline-block;
  padding: 6px 12px;
  margin-bottom: 0;
  font-size: 14px;
  font-weight: 400;
  line-height: 1.42857143;
  text-align: center;
  white-space: nowrap;
  vertical-align: middle;
  touch-action: manipulation;
  cursor: pointer;
  user-select: none;
  border-radius: 4px;
}
.form-control {
  width: 100%;
  height: 34px;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.42857143;
  color: #555;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccc;
  border-radius: 4px;
  display: block;
  box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
  margin-bottom: 5px;
  overflow: auto;
}
.panel-heading {
  background: #555;
  color: #fff;
  height: 49px;
  padding: 4px 12px;
  font-size: 20px;
  line-height: 37px;
  margin-top: 0;
  margin-bottom: 19px;
  text-align: center;
  border-radius: 0;
  border-bottom: none;
}

.panel-body {
  padding: 15px;
  width: 400px;
}
.panel-body p {
  margin: 0 0 10px;
  text-align: center;
}
.control-label {
  text-align: center;
  width: 100%;
  font-weight: 700;
}
form {
  display: flex;
  justify-content: center;
  flex-direction: column;
  align-items: center;
}
.panel {
  margin-bottom: 0;
  border-radius: 0;
  background-color: #fff;
  box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
  border: 1px solid #dcdcdc;
}
</style>
