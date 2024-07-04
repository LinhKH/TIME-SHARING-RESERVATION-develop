<template>
  <div class="space-item">
    <div class="image">
      <img :src="getImageUrl" @click="openInNewTab" />
      <div class="price">
        <i class="fa fa-calendar-check-o mr-[2px]"></i>
        {{ getPriceLabel }}
      </div>
    </div>
    <div class="p-2">
      <div class="title" @click="openInNewTab">{{ information.generalBasicSpaceNameJa }}</div>
      <div class="flex flex-wrap">
        <div class="item mr-[8px]">
          <i class="fa fa-tag mr-[2px]"></i>
          <span class="text ml-[4px]">{{ getPurposeOfUse }}</span>
        </div>
        <div class="item mr-[8px]">
          <i class="fa fa-user mr-[2px]"></i>
          <span class="text ml-[4px]">{{
            information.generalSpaceInformationMaximumCapacity + $t("external_reservation.end_people")
          }}</span>
        </div>
        <div class="item w-[100%]">
          <i class="fa fa-map-marker mr-[2px]"></i>
          <span class="text ml-[4px]">{{ getAddress }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { OPTIONS_MAIN_CATEGORY } from "@/const";
export default {
  props: {
    information: {
      type: Object,
      default: () => ({}),
    },
  },
  computed: {
    getImageUrl() {
      const strArr = this.information.rental_space_image[0].s3key.split("/");
      const imageName = strArr[strArr.length - 1];
      return window.location.origin + `/storage/images/${imageName}`;
    },
    getPurposeOfUse() {
      return (
        OPTIONS_MAIN_CATEGORY.find(
          (c) => c.value === JSON.parse(this.information.generalBasicSpacePurposeOfUses)[0].mainCategory
        )?.label || ""
      );
    },
    getAddress() {
      let result = "";
      result += this.information.generalLocationPrefecture;
      result += this.information.generalLocationMunicipality;
      result += this.information.generalLocationAddressJa;
      return result;
    },
    getPriceLabel() {
      let result = "";
      let priceResult = [];
      let list_interval = [];
      if (this.information?.rental_space_rental_plan?.length) {
        this.information.rental_space_rental_plan.forEach((plan) => {
          list_interval = list_interval.concat(plan.rental_space_rental_interval);
        });
      }
      if (list_interval?.length) {
        list_interval.forEach((interval) => {
          const arrStringStart = interval.start_time_formatted.split(":");
          const startTime = Number(arrStringStart[0]) * 60 + Number(arrStringStart[1]);
          const arrStringEnd = interval.end_time_formatted.split(":");
          const endTime = Number(arrStringEnd[0]) * 60 + Number(arrStringEnd[1]);
          let count = (endTime - startTime) / 60;
          if (endTime - startTime < 60) {
            count = 60 / (endTime - startTime);
          }
          const price = (interval.tenancy_price + interval.per_person_price) * count;
          priceResult.push(price);
        });
      }
      const min = Math.ceil(Math.min.apply(Math, priceResult));
      const max = Math.ceil(Math.max.apply(Math, priceResult));
      result += this.$t("space_detail_client.reservation_request");
      if (min) {
        result += this.$t("space_detail_client.yen_per_hour", {
          price: min.toLocaleString("en-US"),
        });
      }
      if (max) {
        result += `~${this.$t("space_detail_client.yen_per_hour", {
          price: max.toLocaleString("en-US"),
        })}`;
      }
      return result;
    },
  },
  methods: {
    openInNewTab() {
      const url = `${window.location.origin}/${this.information.id}/space-details-client`;
      window.open(url, "_blank").focus();
    },
  },
};
</script>

<style lang="scss" scoped>
.space-item {
  border: 1px solid #555;
  overflow: hidden;
  .image {
    position: relative;
    aspect-ratio: calc(4 / 3);
    height: 295px;
    cursor: pointer;
    img {
      width: 100%;
      height: 100%;
      position: absolute;
      object-fit: cover;
    }
    .price {
      position: absolute;
      display: inline-flex;
      align-items: center;
      padding: 4px;
      color: #fff;
      background: #2e9cd8;
      font-weight: bold;
      bottom: 12px;
      left: 0;
      font-size: 14px;
      i {
        color: #fff;
      }
    }
  }
  .title {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    font-size: 14px;
    margin-bottom: 4px;
    cursor: pointer;
  }
  .flex {
    .item {
      display: inline-flex;
      align-items: center;
      font-size: 9pt;
    }
  }
}
</style>
