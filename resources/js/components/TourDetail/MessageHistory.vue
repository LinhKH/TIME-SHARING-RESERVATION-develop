<template>
  <div>
    <div class="message-history" v-for="item in listReply.slice().reverse()" :key="item">
      <div :class="item.customer_id ? ' message-history-left' : 'message-history-right'">
        <!-- <div class="user-info-name">
          <span v-if="item.first_name !== null"
            >（オーナー）{{ item.first_name }}{{ item.last_name }}
            {{ convertTime(item.created_at) }}</span
          >
          <span v-else>{{
            `（ユーザー）${item.customer_first_name} ${
              item.customer_last_name
            } ${convertTime(item.created_at)}`
          }}</span>
        </div> -->
        <div
          :class="item.customer_id ? 'well owner-info' : 'user-info'"
          class="message-content"
          style="white-space: pre-wrap"
        >
          {{ item.description }}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";

export default {
  props: {
    data: { type: Array },
    listReply: { type: Array },
  },

  setup() {
    const convertTime = (rawTime) => {
      return moment(rawTime).format("YYYY年MM月DD日（水）hh:mm");
    };
    return { moment, convertTime };
  },
};
</script>
<style lang="scss" scoped>
.message-history {
  padding: 10px 0;
}
.user-info-name {
  z-index: 0;
  background: #fff;
  position: relative;
  color: #aaa;
  font-weight: 700;
}
.message-content {
  width: 50%;
  z-index: 0;
  position: relative;
  margin-left: 10px;
  min-height: 20px;
  padding: 15px;
  // margin-bottom: 20px;
  border: 1px solid #e3e3e3;
  border-radius: 4px;
}
.message-content::before {
  content: "";
  position: absolute;
  top: 50%;
  margin-top: -9px;
  display: block;
  width: 0;
  height: 0;
  border-style: solid;
  z-index: 0;
}
.message-history-left {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  background: white;
  .user-info-name {
    width: 50%;
    margin-left: 20px;
  }
  .message-content {
    background: #fff7e2;
  }
  .message-content::before {
    left: -9px;
    border-width: 9px 9px 9px 0;
    border-color: transparent #fff7e2 transparent transparent;
  }
}
.message-history-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  background: white;
  .user-info-name {
    width: 50.01%;
    text-align: right;

    clear: both;
    margin-right: 20px;
  }
  .message-content {
    width: 50%;
    color: #626262;
    background: #bce8f1;
    z-index: 0;

    position: relative;
    border-width: 1px;
    border-style: solid;
    border-color: #e3e3e3;
    margin-right: 20px;
  }
  .message-content::before {
    right: -9px;
    border-width: 9px 0 9px 9px;
    border-color: transparent transparent transparent #bce8f1;
  }
}
</style>
