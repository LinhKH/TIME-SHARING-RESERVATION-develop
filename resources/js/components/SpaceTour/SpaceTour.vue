<template>
  <div class="w-[70%] m-auto">
    <Header :isShowHeader="isShowHeader" />
    <NavFunctionTour :navFunctionList="navFunctionList" />
    <VisitApplication :visitApplications="visitApplications" />
  </div>
</template>
<script>
import Header from "@/components/Header";
import NavFunctionTour from "./SpaceTourContent/NavFunctionTour.vue";
import VisitApplication from "./SpaceTourContent/VisitApplication.vue";
import { useI18n } from "vue-i18n";
import { ref } from "vue";
export default {
  name: "SpaceTour",
  components: {
    Header,
    NavFunctionTour,
    VisitApplication,
  },
  setup() {
    const { t } = useI18n();
    const isShowHeader = false;
    const navFunctionList = [
      {
        id: 1,
        icon: "fa fa-2x fa-check-circle-o",
        title: t("space_tour.reservation_request"),
      },
      {
        id: 2,
        icon: "fa fa-2x fa-check-circle-o",
        title: t("space_tour.reservation_request"),
      },
      {
        id: 3,
        icon: "fa fa-2x fa-comment",
        title: t("space_tour.reservation_request"),
      },
      {
        id: 4,
        icon: "fa fa-2x fa-user",
        title: t("space_tour.reservation_request"),
      },
      {
        id: 5,
        icon: "fa fa-2x fa-credit-card-alt",
        title: t("space_tour.reservation_request"),
      },
    ];
    const visitApplications = [
      {
        id: 1,
        type: "inputDate",
        title: t("space_tour.choose_1"),
        name: "inputDate1",
        value: "",
        required: true,
        placeholderDate: "2022/01/01",
        placeholderHour: "09:30",
      },
      {
        id: 2,
        type: "inputDate",
        title: t("space_tour.choose_2"),
        name: "inputDate2",
        value: "",
        required: false,
        placeholderDate: "2022/01/01",
        placeholderHour: "09:30",
      },
      {
        id: 3,
        type: "inputDate",
        title: t("space_tour.choose_3"),
        name: "inputDate3",
        value: "",
        required: false,
        placeholderDate: "2022/01/01",
        placeholderHour: "09:30",
      },
      {
        id: 4,
        type: "inputDescript",
        title: t("space_tour.date_time"),
        name: "inputDescript1",
        value: "",
        required: true,
        placeholder: t("space_tour.date_time_placeholder"),
      },
      {
        id: 5,
        type: "inputNumber",
        title: t("space_tour.expected_number"),
        name: "inputNumber1",
        value: "",
        required: true,
        placeholder: 40,
      },
      {
        id: 6,
        type: "inputSelect",
        title: t("space_tour.purpose_use"),
        name: "inputSelect1",
        value: "",
        required: true,
        placeholder: t("space_tour.purpose_use_placeholder"),
        children: [
          { id: 1, title: t("space_tour.purpose_use_value1") },
          { id: 3, title: t("space_tour.purpose_use_value3") },
          { id: 4, title: t("space_tour.purpose_use_value4") },
          { id: 5, title: t("space_tour.purpose_use_value5") },
        ],
      },
      {
        id: 7,
        type: "inputDescript",
        title: t("space_tour.usage_details"),
        name: "inputDescript2",
        value: "",
        required: true,
        placeholder: t("space_tour.usage_details_placeholder"),
      },
      {
        id: 8,
        type: "inputDescript",
        title: t("space_tour.check_points"),
        name: "inputDescript3",
        value: "",
        required: true,
        placeholder: t("space_tour.check_points_placeholder"),
      },
    ];
    return {
      isShowHeader,
      navFunctionList,
      visitApplications,
    };
  },
};
</script>
<style></style>
