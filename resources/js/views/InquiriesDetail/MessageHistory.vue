<template>
  <div>
    <div class="message-history" v-for="(item, idx) in listReply" :key="item">
      <div :class="item.first_name !== null ? ' message-history-right' : 'message-history-left'">
        <div class="user-info-name">
          <span v-if="item.first_name !== null">
            {{ item.first_name }}{{ item.last_name }} {{ convertTime(item.created_at) }}
          </span>

          <span v-else>{{
            `${item.customer_first_name} ${item.customer_last_name} ${convertTime(item.created_at)}`
          }}</span>
        </div>
        <div
          :class="item.customer_first_name ? 'well owner-info' : 'user-info'"
          class="message-content"
          style="white-space: pre-wrap"
        >
          {{ item.description }}
        </div>
        <div class="text-right" v-if="getReadStatus && item.first_name && idx == listReply.length - 1">
          既読 <i class="fa fa-check"></i>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import moment from "moment";
import { ref, computed, watch, inject, reactive } from "vue";

export default {
  props: {
    data: { type: Array, default: [] },
    listReply: { type: Array, default: [] },
    isRead: { type: Number, default: () => 0 },
  },

  setup(props, context) {
    const getReadStatus = computed(() => props.isRead);
    const convertTime = (rawTime) => {
      return moment(rawTime).format("YYYY年MM月DD日（水）hh:mm");
    };
    return { moment, convertTime, getReadStatus };
  },
};
</script>
<style lang="scss" scoped>
.message-history {
  padding: 0 28px 28px 20px;
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
    // margin-left: 20px;
    min-height: 20px;
    padding: 19px;
    // margin-bottom: 20px;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    box-shadow: inset 0 1px 1px rgb(0 0 0 / 5%);
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
    .user-info-name {
      width: 50%;
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
    .user-info-name {
      width: 50.01%;
      text-align: right;
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
    }
    .message-content::before {
      right: -9px;
      border-width: 9px 0 9px 9px;
      border-color: transparent transparent transparent #bce8f1;
    }
  }
  .text-right {
    text-align: right;
  }
}
</style>
