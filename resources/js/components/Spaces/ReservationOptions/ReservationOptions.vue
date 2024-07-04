<template>
  <HeaderSpaces
    v-if="!isEditScreen"
    :title="'オプション登録s'"
    :textHelp="$t('reservation_options_components.title')"
    :textLink="$t('spaces_image_page.preview_of_public_page')"
    :textHelpTop="$t('spaces_image_page.text_desc_1')"
  />
  <LayoutModal :isShowModal="isShowModal" @onClose="isShowModal = false">
    <div class="p-8 bg-white rounded overflow-hidden">
      <FormKit type="group" v-model="formData">
        <div class="flex w-[540px]">
          <div class="w-1/5 font-bold">
            {{ $t("reservation_options_components.equipment_name") }}
          </div>
          <div class="w-4/5 h-8 border border-solid border-[#ccc] rounded">
            <FormKit
              type="text"
              name="title_ja"
              outer-class="h-full"
              wrapper-class="h-full"
              inner-class="h-full"
              input-class="w-full px-1 h-full rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
            />
          </div>
        </div>

        <div class="flex w-[540px] mt-2">
          <div class="w-1/5 font-bold">
            {{ $t("reservation_options_components.contents") }}
          </div>
          <div class="w-4/5 h-14 border border-solid border-[#ccc] rounded">
            <FormKit
              type="textarea"
              name="description_ja"
              outer-class="h-full"
              :placeholder="$t('reservation_options_components.placeholder_1')"
              wrapper-class="h-full"
              inner-class="h-full"
              input-class="w-full p-1 h-full rounded outline-none resize-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
            />
          </div>
        </div>

        <div class="flex w-[540px] mt-2">
          <div class="w-1/5 font-bold">
            {{ $t("reservation_options_components.excluding_tax") }}
          </div>
          <div class="w-4/5 h-8 flex">
            <div class="w-[150px] flex border border-solid border-[#ccc] rounded">
              <FormKit
                type="number"
                min="0"
                name="price"
                outer-class="w-[110px] h-full"
                wrapper-class="h-full"
                inner-class="h-full"
                input-class="w-full px-1 h-full rounded rounded-tl rounded-bl outline-none resize-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                @input="handleChangeInput"
              />
              <span class="h-full flex-1 flex items-center justify-center bg-[#eee] rounded-tr rounded-br">
                {{ $t("reservation_options_components.circle") }}
              </span>
            </div>

            <div class="mx-1 flex items-center">／</div>
            <div class="w-[74px] border border-solid border-[#ccc] rounded">
              <FormKit
                type="select"
                name="unit_type"
                :options="optionUnitType"
                outer-class="w-full h-full"
                wrapper-class="w-full h-full"
                inner-class="w-full h-full"
                input-class="px-2 w-full h-full rounded outline-none focus:shadow-lg bg-white focus:shadow-cyan-500/50 focus:border-cyan-500/50"
              />
            </div>
            <div class="ml-1 flex items-center">
              {{ tenancyPriceIncludeTax }}
              {{ $t("reservation_options_components.text_help_3") }}
            </div>
          </div>
        </div>

        <div class="flex w-[540px] mt-[3px]" v-if="isShowMessagePice">
          <div class="w-1/5 font-bold"></div>
          <div class="w-4/5 flex">
            <div class="text-[red]">価格を入力してください</div>
          </div>
        </div>

        <div class="flex w-[540px] mt-2">
          <div class="w-1/5 font-bold">
            {{ $t("reservation_options_components.maximum_number") }}
          </div>
          <div class="w-4/5">
            <div class="w-[112px] flex border border-solid border-[#ccc] rounded">
              <FormKit
                type="number"
                min="0"
                name="order_number"
                outer-class="w-[74px] "
                input-class="w-full px-1 h-8 rounded rounded-tl rounded-bl outline-none resize-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
              />
              <span class="flex-1 flex items-center justify-center bg-[#eee] rounded-tr rounded-br"> 個 </span>
            </div>
            <div class="text-[#737373] mt-2">
              {{ $t("reservation_options_components.text_help_4") }}
            </div>
          </div>
        </div>

        <div class="flex w-[540px] mt-2">
          <div class="w-1/5 font-bold">
            {{ $t("reservation_options_components.public_private") }}
          </div>
          <div class="w-4/5">
            <FormKit
              type="radio"
              name="active"
              wrapper-class="flex"
              options-class="flex"
              label-class="mx-2"
              value="1"
              :options="optionActive"
            />
          </div>
        </div>

        <div class="flex w-[540px] mt-2">
          <div class="w-1/5"></div>
          <div class="w-4/5 flex">
            <div class="w-1/2">
              <button class="py-2 px-3 bg-white border border-solid border-[#ccc] rounded" @click="isShowModal = false">
                {{ $t("reservation_options_components.cancel") }}
              </button>
            </div>
            <button
              class="py-2 px-3 bg-[#ffbd00] rounded text-white"
              @click="handleAddData"
              type="submit"
              name="submit"
            >
              {{ $t("common.keep") }}
            </button>
          </div>
        </div>
      </FormKit>
    </div>
  </LayoutModal>

  <LayoutInput :labelText="$t('reservation_options_components.option_setting')" customCss="mt-5">
    <div>{{ $t("reservation_options_components.text_help_1") }}</div>
    <div>{{ $t("reservation_options_components.text_help_2") }}</div>
  </LayoutInput>

  <LayoutInput :labelText="$t('reservation_options_components.register_equipment')" customCss="mt-5">
    <div class="grid gap-2 grid-cols-6 pr-3">
      <button
        v-for="(item, index) in listButton"
        :key="index"
        class="px-4 py-2 bg-white rounded border border-solid border-[#ccc] hover:bg-[#e6e6e6] hover:border-[#adadad]"
        @click="() => showModal(item.name)"
      >
        {{ item.name }}
      </button>
    </div>
  </LayoutInput>

  <LayoutInput :labelText="$t('reservation_options_components.registered_equipment')" customCss="mt-5">
    <div v-if="!formDataArray.length">
      {{ $t("reservation_options_components.no_info") }}
    </div>
    <div v-else class="pr-3">
      <table class="w-full">
        <thead>
          <tr>
            <th class="w-[15%] py-2 px-1">
              {{ $t("reservation_options_components.equipment_name_1") }}
            </th>
            <th class="w-[60%] py-2 px-1">
              {{ $t("reservation_options_components.contents") }}
            </th>
            <th class="w-[10%] py-2 px-1">
              {{ $t("reservation_options_components.excluding_tax") }}
            </th>
            <th class="w-[10%] py-2 px-1">
              {{ $t("reservation_options_components.maximum_number") }}
            </th>
            <th class="w-[5%] py-2 px-1"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in formDataArray" :key="index">
            <td class="py-2 px-1 text-[#337ab7] cursor-pointer text-center" @click="() => handleShowModal(item, index)">
              {{ item.title_ja }}
            </td>
            <td class="py-2 px-1 text-[#337ab7] cursor-pointer" @click="() => handleShowModal(item, index)">
              {{ item.description_ja }}
            </td>
            <td class="py-2 px-1 text-[#337ab7] cursor-pointer text-center" @click="() => handleShowModal(item, index)">
              {{ item.price }}円
            </td>
            <td class="py-2 px-1 text-[#337ab7] cursor-pointer text-center" @click="() => handleShowModal(item, index)">
              {{ item.order_number }}
            </td>
            <td class="py-2 px-1 text-center">
              <div>
                <div
                  class="border border-solid border-[#ddd] rounded cursor-pointer px-[17px] py-[5px]"
                  @click="handlePositionUp(index)"
                >
                  <i class="fa fa-chevron-up"></i>
                </div>
                <div
                  class="border border-solid border-[#ddd] rounded cursor-pointer px-[17px] py-[5px] mt-[3px]"
                  @click="handlePositionDown(index)"
                >
                  <i class="fa fa-chevron-down"></i>
                </div>
              </div>
              <!-- <div
                @click="() => handleShowModal(item, index)"
                class="bg-white w-7 py-1 rounded border cursor-pointer mx-auto flex items-center justify-center"
              >
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </div> -->
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </LayoutInput>

  <ButtonNextStep v-if="!isEditScreen" :nextPage="'プラン作成'" @onBack="handleBack" @onNext="handleNext" />
</template>

<script>
import HeaderSpaces from "@/components/HeaderSpaces";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import ButtonNextStep from "@/components/Buttons/ButtonNextStep";
import { useI18n } from "vue-i18n";
import LayoutModal from "@/components/Layouts/LayoutModal.vue";
import { ref, inject } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import { ROUTER_PATH, MODULE_STORE, STEP_CREATE_SPACE, STEP_SPACE_CREATED } from "@/const";
import { postSpaceReservationOption, getDetailSpaceReservation } from "@/api";
import { optionUnitType, optionActive } from "@/const/options";
import { TAX_RATIO } from "@/const";

export default {
  name: "ReservationOptions",
  components: { HeaderSpaces, LayoutInput, ButtonNextStep, LayoutModal },
  props: {
    isEditScreen: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    const { t } = useI18n();
    const isShowModal = ref(false);
    const formData = ref({});
    const isEdit = ref(false);
    const indexArray = ref(null);
    const formDataArray = ref([]);
    const router = useRouter();
    const store = useStore();
    const route = useRoute();
    const idSpace = route.params.id || route.query.id;
    const toast = inject("$toast");
    const isShowMessagePice = ref(false);
    const tenancyPriceIncludeTax = ref();
    const handleChangeInput = (valueInput) => {
      tenancyPriceIncludeTax.value = valueInput ? (valueInput * (1 + TAX_RATIO)).toFixed(2) : 0;
      isShowMessagePice.value = false;
    };
    const isCreated =
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_STEP_SPACE_CREATED}`] >
      STEP_CREATE_SPACE.RESERVATION_OPTION;
    function submitHandler() {
      //do something with the form data
      if (isEdit.value) {
        formDataArray.value[indexArray.value] = { ...formData.value };

        isEdit.value = false;
        isShowModal.value = false;
        return;
      }
      formDataArray.value = [...formDataArray.value, { ...formData.value }];
      formData.value = {};
      isShowModal.value = false;
    }

    const listButton = [
      {
        name: t("reservation_options_components.projector"),
      },
      {
        name: t("reservation_options_components.whiteboard"),
      },
      {
        name: t("reservation_options_components.kitchen"),
      },
      {
        name: t("reservation_options_components.parking"),
      },
      {
        name: t("reservation_options_components.tv_set"),
      },
      {
        name: t("reservation_options_components.monitor"),
      },
      {
        name: t("reservation_options_components.computer"),
      },
      {
        name: t("reservation_options_components.speaker"),
      },
      {
        name: t("reservation_options_components.microphone_set"),
      },
      {
        name: t("reservation_options_components.trash_bags"),
      },
      {
        name: t("reservation_options_components.cleaning"),
      },
      {
        name: t("reservation_options_components.other_equipment"),
      },
    ];
    const handleAddData = () => {
      if (formData.value.price <= 0 || formData.value.price === undefined) {
        isShowMessagePice.value = true;
      } else {
        isShowMessagePice.value = false;
      }
      if (isShowMessagePice.value === false) {
        if (isEdit.value) {
          formDataArray.value[indexArray.value] = { ...formData.value };

          isEdit.value = false;
          isShowModal.value = false;
          return;
        }
        formDataArray.value = [...formDataArray.value, { ...formData.value }];
        formData.value = {};
        isShowModal.value = false;
      }
    };

    const showModal = (name) => {
      isShowModal.value = true;
      formData.value.title_ja = name;
    };
    const handleBack = () => {
      router.push(`${ROUTER_PATH.SPACE.BOOKING_SYSTEM}?id=${idSpace}`);
    };
    const handleNext = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await postSpaceReservationOption({ reservation_option_types: [...formDataArray.value] }, idSpace);
        store.commit(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
          STEP_SPACE_CREATED["plan-creation"]
        );
        router.push(`${ROUTER_PATH.SPACE.RENTAL_PLAN}?id=${idSpace}`);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleShowModal = (data, index) => {
      formData.value = { ...data };
      isEdit.value = true;
      indexArray.value = index;
      isShowModal.value = true;
    };
    const initData = async () => {
      if (props.isEditScreen) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const idSpaceFromParams = route.params.id;
          const res = await getDetailSpaceReservation(idSpaceFromParams);
          formDataArray.value = res.data?.reservationOptionTypes.map((item) => ({
            title_ja: item.title__ja,
            description_ja: item.description__ja,
            price: item.price,
            unit_type: item.unitType,
            order_number: item.order_number,
            active: item.active,
          }));
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
        return;
      }
      if (isCreated) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const res = await getDetailSpaceReservation(idSpace);
          formDataArray.value = res.data?.reservationOptionTypes.map((item) => ({
            title_ja: item.title__ja,
            description_ja: item.description__ja,
            price: item.price,
            unit_type: item.unitType,
            order_number: item.order_number,
            active: item.active,
          }));
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
        STEP_CREATE_SPACE.RESERVATION_OPTION
      );
    };

    initData();

    const handlePositionUp = (indexPositon) => {
      let temp = formDataArray.value[indexPositon - 1];

      if (indexPositon > 0) {
        formDataArray.value[indexPositon - 1] = formDataArray.value[indexPositon];

        formDataArray.value[indexPositon] = temp;
      }
    };

    const handlePositionDown = (indexPositon) => {
      let temp = formDataArray.value[indexPositon + 1];

      if (indexPositon < formDataArray.value.length - 1) {
        formDataArray.value[indexPositon + 1] = formDataArray.value[indexPositon];

        formDataArray.value[indexPositon] = temp;
      }
    };
    return {
      listButton,
      showModal,
      isShowModal,
      formData,
      handleBack,
      handleAddData,
      formDataArray,
      handleNext,
      handleShowModal,
      optionUnitType,
      optionActive,
      tenancyPriceIncludeTax,
      handleChangeInput,
      submitHandler,
      isShowMessagePice,
      handlePositionUp,
      handlePositionDown,
    };
  },
};
</script>

<style class="scss" scoped>
th,
td {
  border: 1px solid #dbdbdb;
}
[data-type="submit"] .formkit-input {
  background: red !important;
}
</style>
