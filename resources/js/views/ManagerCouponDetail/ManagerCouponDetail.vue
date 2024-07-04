<template>
  <div class="font-serif">
    <div class="w-full text-[18px] mt-[20px] mb-[10px]">{{ $t("coupon_detail.detail") }}</div>
    <form @submit="handleClickCreateAdd">
      <BaseFormCoupon :label="$t('coupon_detail.active')">
        <div class="flex">
          <label class="flex justify-start items-center mr-[15px] font-normal" for="radio1"
            ><input
              type="radio"
              id="radio1"
              value="radio1"
              name="gender"
              class="translate-y-[-2px] mr-[3px]"
              @click="handleRadio(1)"
              :checked="enabledCheck === 1 || true"
            />{{ $t("coupon_detail.yes") }}</label
          >
          <label class="flex justify-start items-center font-normal" for="radio2"
            ><input
              type="radio"
              id="radio2"
              value="radio2"
              name="gender"
              class="translate-y-[-2px] mr-[3px]"
              :checked="enabledCheck === 2"
              @click="handleRadio(2)"
            />{{ $t("coupon_detail.no") }}</label
          >
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.discount_name')" id="discount_name">
        <div class="w-full border border-solid border-[#ddd] rounded h-8">
          <Field
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
            type="text"
            name="name"
            v-model="detailCoupon.name"
          />
        </div>
        <div class="mt-[5px]"><ErrorMessage class="text-[red]" name="name" /></div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.note')" id="subNameHeader">
        <div class="w-full border border-solid border-[#ddd] rounded flex">
          <textarea
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br p-[10px]"
            rows="6"
            cols="50"
            v-model="memoCheck"
            :placeholder="$t('coupon_detail.placeholder_memo')"
          />
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.discount_rate')" id="discount_rate">
        <div class="w-[50%] flex border border-solid border-[#ddd] rounded h-8">
          <Field
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
            type="text"
            name="rate"
            v-model="detailCoupon.discount_percentage"
          />
          <div class="bg-[#eee] rounded-r-[4px] p-2 border-l border-l-solid border-[#ccc]">%</div>
        </div>
        <div class="mt-[5px]"><ErrorMessage class="text-[red]" name="rate" /></div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.discount_code')" id="discount_code">
        <div class="w-[50%] flex border border-solid border-[#ddd] rounded h-8">
          <Field
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
            type="text"
            name="code"
            v-model="detailCoupon.code"
          />
        </div>
        <div class="mt-[5px]"><ErrorMessage class="text-[red]" name="code" /></div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.Expiration_reservation_date')">
        <div class="flex">
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex justify-center items-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker
                class="px-2 w-[100px] outline-none text-center text-sm py-[5px] rounded"
                v-model="usableFrom"
                :lowerLimit="new Date()"
                @update:modelValue="usableFromFormat(usableFrom)"
              />
            </div>
          </div>
          <div class="p-2">〜</div>
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex justify-center items-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker
                class="px-2 w-[100px] outline-none text-center text-sm py-[5px] rounded"
                v-model="usableTo"
                :lowerLimit="usableFrom"
              />
            </div>
          </div>
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.Expiration_use_date')">
        <div class="flex">
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex justify-center items-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker
                class="px-2 w-[100px] outline-none text-center text-sm py-[5px] rounded"
                v-model="validFrom"
                :lowerLimit="new Date()"
              />
            </div>
          </div>
          <div class="p-2">〜</div>
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex justify-center items-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker
                class="px-2 w-[100px] outline-none text-center text-sm py-[5px] rounded"
                v-model="validTo"
                :lowerLimit="validFrom"
              />
            </div>
          </div>
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.maximum_number_use')" id="maximum_number_use">
        <div class="w-[50%] flex border border-solid border-[#ddd] rounded h-8">
          <Field
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
            type="text"
            name="number_of_people"
            placeholder="0"
            v-model="numberOfPeople"
          />
        </div>
        <div class="mt-[5px]"><ErrorMessage class="text-[red]" name="number_of_people" /></div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.email')" id="email">
        <div class="w-[100%] flex border border-solid border-[#ddd] rounded h-8">
          <input
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
            type="text"
            placeholder="例:abc@example.com,def@example.jp メールアドレスを左詰めで','カンマで区切る。"
            v-model="mailText"
          />
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.id_space')" id="id_space">
        <div class="w-[100%] flex border border-solid border-[#ddd] rounded h-8">
          <input
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
            type="text"
            placeholder="例:abc@example.com,def@example.jp メールアドレスを左詰めで','カンマで区切る。"
            v-model="spaceId"
          />
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.id_packed')" id="id_packed">
        <div class="w-[100%] flex border border-solid border-[#ddd] rounded h-8">
          <input
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
            type="text"
            placeholder="例:53,67 予約プランIDを左詰めで','カンマで区切る。IDは数字のみ。"
            v-model="planId"
          />
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.day_of_week')" id="day_of_week">
        <div class="flex justify-start items-center">
          <label
            v-for="(listWeekItem, index) in listDayWeek"
            :key="index"
            class="flex justify-start items-center mr-[15px] font-bold"
            :for="listWeekItem.title"
            ><input
              type="checkbox"
              :checked="listWeekItem.check === true"
              :id="listWeekItem.title"
              class="translate-y-[-2px] mr-[3px]"
              @click="handleCheckbox(listWeekItem.id)"
            />{{ listWeekItem.title }}</label
          >
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.max_people')" id="max_people">
        <div class="w-[50%] flex border border-solid border-[#ddd] rounded h-8">
          <input
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
            type="number"
            :placeholder="$t('coupon_detail.placeholder_maximum_number')"
            v-model="detailCoupon.master"
          />
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('coupon_detail.note_email')" id="note_email">
        <div class="w-full border border-solid border-[#ddd] rounded flex">
          <textarea
            class="flex-1 w-full h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br p-[10px]"
            rows="6"
            cols="50"
            :placeholder="$t('coupon_detail.placeholder_nofi_email')"
          />
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon>
        <div class="text-center mb-[8px] flex justify-start my-3">
          <button
            @click="handleClickCreateAdd"
            class="group bg-[#ffbd00] border border-solid border-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all"
          >
            <span class="text-[14px] text-[#fff]"> {{ $t(`form_setting.button_text`) }}</span>
          </button>

          <button
            type="button"
            v-if="detailCoupon.id"
            @click="handleDeleteCoupon(detailCoupon.id)"
            class="bg-[#fff] hover:bg-[#d43f3a] px-[12px] py-[6px] border border-solid border-[#d43f3a] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all ml-[10px] group"
          >
            <span class="text-[14px] text-[#d43f3a] group-hover:text-[#fff]">
              {{ $t("form_setting_news.delete") }}</span
            >
          </button>
        </div>
      </BaseFormCoupon>
    </form>
  </div>
</template>

<script>
import * as Yup from "yup";
import { reactive, watch } from "vue";
import { useI18n } from "vue-i18n";
import { useRouter, useRoute } from "vue-router";
import { Field, useForm, ErrorMessage } from "vee-validate";
import BaseFormCoupon from "@/components/FormSettingCoupon/BaseFormCoupon/BaseFormCoupon.vue";
import Datepicker from "vue3-datepicker";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import {
  getDetailCouponApi,
  addSettingCouponApi,
  updateSettingCouponApi,
  deleteSettingCouponApi,
  deleteCouponApi,
} from "@/api";
import { ref, inject } from "vue";
import { useStore } from "vuex";

export default {
  components: { BaseFormCoupon, Datepicker, Field, ErrorMessage },
  name: "ManagerCouponDetail ",
  props: {
    itemEdit: Object,
  },

  setup(props, context) {
    const { t } = useI18n();
    const enabledCheck = ref(1);
    const router = useRouter();
    const store = useStore();
    const toast = inject("$toast");
    const route = useRoute();
    const id = route.query.id;
    const dateDate = ref(new Date("2020-01-02"));
    const detailCoupon = ref({});
    const year = ref();
    const month = ref();
    const day = ref();
    const usableFrom = ref();
    const usableTo = ref();
    const validFrom = ref();
    const validTo = ref();
    const memoCheck = ref();
    const mailText = ref();
    const numberOfPeople = ref();
    const planId = ref();
    const spaceId = ref();
    const dayWeek = ref([]);
    const daysTheWeek = ref([]);
    const dataTest1 = ref();
    const listAdd = reactive({
      id: Math.floor(Math.random() * 100),
      name: "",
      subNameHeader: "",
      discountRate: "",
      numberUse: 1,
      discountCode: "",
      dateReservationStart: "",
      dateReservationEnd: "",
      dateUseStart: "",
      dateUseEnd: "",
      email: "",
      idSpace: "",
      idPacked: "",
      maxPeople: "",
      noteEmail: "",
    });
    const listDayWeek = ref([
      {
        id: 0,
        title: "日",
        check: false,
      },
      {
        id: 1,
        title: "月",
        check: false,
      },
      {
        id: 2,
        title: "火",
        check: false,
      },
      {
        id: 3,
        title: "水",
        check: false,
      },
      {
        id: 4,
        title: "木",
        check: false,
      },
      {
        id: 5,
        title: "金",
        check: false,
      },
      {
        id: 6,
        title: "土",
        check: false,
      },
    ]);
    watch(
      usableFrom,
      (val) => {
        // console.log(123, new Date(val).getTime());
        if (new Date(usableFrom.value).getTime() > new Date(usableTo.value).getTime()) {
          usableTo.value = usableFrom.value;
        }
      },
      {
        immediate: true,
      }
    );
    watch(
      validFrom,
      (val) => {
        // console.log(123, new Date(val).getTime());
        if (new Date(validFrom.value).getTime() > new Date(validTo.value).getTime()) {
          validTo.value = validFrom.value;
        }
      },
      {
        immediate: true,
      }
    );
    const { handleSubmit, errors } = useForm({
      initialValues: {
        name: "",
        rate: "",
        code: "",
      },
      validationSchema: Yup.object().shape({
        name: Yup.string().required(t(`coupon_detail.error_require`)),
        code: Yup.string().required(t(`coupon_detail.error_require`)),
        rate: Yup.string()
          .matches(/^\d+$/, t(`coupon_detail.messeage_number`))
          .required(t(`coupon_detail.error_require`)),
        number_of_people: Yup.string().required(t(`coupon_detail.error_require`)),
      }),
    });
    const handleClickCreateAdd = handleSubmit((values) => {
      if (id) {
        updateSettingCoupon(values);
      } else {
        addSettingCoupon(values);
      }
    });
    const handleDeleteCoupon = async (itemId) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await deleteCouponApi(itemId);
        router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COUPONS}`);
      } catch (errors) {
        const bug = errors.message || t("common.has_error");
        toast.error(bug);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const addSettingCoupon = async (values) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await addSettingCouponApi({
          name: values.name,
          enabled: enabledCheck.value,
          mail_text: mailText.value,
          space_ids: spaceId.value,
          memo: memoCheck.value,
          code: values.code,
          number_of_people: numberOfPeople.value,
          plan_ids: planId.value,
          discount_percentage: values.rate,
          valid_from: `${validFrom.value ? formatDateCreate(validFrom.value) : ""}`,
          valid_to: `${validTo.value ? formatDateCreate(validTo.value) : ""}`,
          usable_from: `${usableFrom.value ? formatDateCreate(usableFrom.value) : ""}`,
          usable_to: `${usableTo.value ? formatDateCreate(usableTo.value) : ""}`,
          days_of_the_week: daysTheWeek.value,
        });
        router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COUPONS}`);
      } catch (errors) {
        const error = errors?.msg || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const updateSettingCoupon = async (values) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateSettingCouponApi(id, {
          name: values.name,
          enabled: enabledCheck.value,
          mail_text: mailText.value,
          space_ids: spaceId.value,
          memo: memoCheck.value,
          code: values.code,
          number_of_people: numberOfPeople.value,
          plan_ids: planId.value,
          discount_percentage: values.rate,
          valid_from: `${validFrom.value ? formatDateCreate(validFrom.value) : ""}`,
          valid_to: `${validTo.value ? formatDateCreate(validTo.value) : ""}`,
          usable_from: `${usableFrom.value ? formatDateCreate(usableFrom.value) : ""}`,
          usable_to: `${usableTo.value ? formatDateCreate(usableTo.value) : ""}`,
          days_of_the_week: daysTheWeek.value,
        });
        router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COUPONS}`);
      } catch (errors) {
        const error = errors?.msg || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const getDetailSettingCoupon = async () => {
      if (id) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          detailCoupon.value = await getDetailCouponApi(id);
          if (detailCoupon.value.days_of_the_week) {
            detailCoupon.value.days_of_the_week.forEach((element) => {
              switch (element) {
                case 0:
                  listDayWeek.value[0].check = true;
                  break;
                case 1:
                  listDayWeek.value[1].check = true;
                  break;
                case 2:
                  listDayWeek.value[2].check = true;
                  break;
                case 3:
                  listDayWeek.value[3].check = true;
                  break;
                case 4:
                  listDayWeek.value[4].check = true;
                  break;
                case 5:
                  listDayWeek.value[5].check = true;
                  break;
                case 6:
                  listDayWeek.value[6].check = true;
                  break;
                default:
              }
            });
          }

          dayWeek.value = detailCoupon.value.days_of_the_week;
          enabledCheck.value = detailCoupon.value.enabled;
          if (
            detailCoupon.value.usable_from ||
            detailCoupon.value.usable_to ||
            detailCoupon.value.valid_from ||
            detailCoupon.value.valid_to
          ) {
            usableFrom.value = new Date(formatDate(detailCoupon.value.usable_from));
            usableTo.value = new Date(formatDate(detailCoupon.value.usable_to));
            validFrom.value = new Date(formatDate(detailCoupon.value.valid_from));
            validTo.value = new Date(formatDate(detailCoupon.value.valid_to));
          }

          memoCheck.value = detailCoupon.value.memo;
          mailText.value = detailCoupon.value.mail_text;
          numberOfPeople.value = detailCoupon.value.number_of_people;
          planId.value = detailCoupon.value.plan_ids;
          spaceId.value = detailCoupon.value.space_ids;
          daysTheWeek.value = detailCoupon.value.days_of_the_week;
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    const handleRadio = (valueRadio) => {
      enabledCheck.value = valueRadio;
    };
    const formatDate = (val) => {
      year.value = val?.toString().trim().slice(0, 4);
      month.value = val?.toString().trim().slice(4, 6);
      day.value = val?.toString().trim().slice(6, 8);
      return `${year.value}-${month.value}-${day.value}`;
    };
    const formatDateCreate = (data) => {
      const date = new Date(data);

      month.value = date.getMonth() + 1 < 10 ? "0" + (date.getMonth() + 1) : date.getMonth() + 1;
      day.value = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
      year.value = date.getFullYear();
      return `${year.value}${month.value}${day.value}`;
    };
    const checkValue = ref(false);
    const handleCheckbox = (id) => {
      daysTheWeek.value.forEach((el, index) => {
        if (el === id) {
          daysTheWeek.value.splice(index, 1);
          checkValue.value = true;
        }
      });
      if (checkValue.value === false) {
        daysTheWeek.value.push(id);
      }
    };
    const deleteItemNew = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await deleteSettingCouponApi(detailCoupon.value?.id);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const usableFromFormat = (usableValue) => {
      const test = formatDateCreate(usableValue);
      dataTest1.value = Number.parseInt(test);
    };
    getDetailSettingCoupon();
    return {
      listAdd,
      handleClickCreateAdd,
      handleSubmit,
      errors,
      id,
      detailCoupon,
      dateDate,
      listDayWeek,
      year,
      month,
      day,
      formatDate,
      usableFrom,
      usableTo,
      validFrom,
      validTo,
      enabledCheck,
      memoCheck,
      mailText,
      numberOfPeople,
      planId,
      spaceId,
      handleRadio,
      daysTheWeek,
      handleCheckbox,
      formatDateCreate,
      usableFromFormat,
      dataTest1,
      checkValue,
      updateSettingCoupon,
      deleteItemNew,
      handleDeleteCoupon,
    };
  },
  watch: {
    itemEdit() {
      if (this.itemEdit) {
        this.listAdd = Object.assign({}, this.itemEdit);
      }
    },
  },
};
</script>

<style></style>
