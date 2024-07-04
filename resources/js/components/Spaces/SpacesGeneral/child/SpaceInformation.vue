<template>
  <LayoutForm :title="$t('spaces_general_page.space_info')" icon="fa fa-home">
    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <i class="fa fa-users mx-1"></i>
        <span>{{ $t("spaces_general_page.number_of_people") }}</span>
      </div>

      <div class="flex">
        <div class="form-card-group">
          <div class="w-80 rounded border border-solid border-[#ddd] flex">
            <div class="w-8 bg-[#eee] flex items-center justify-center">
              {{ $t("spaces_general_page.minimum") }}
            </div>
            <FormKit
              type="number"
              name="general_space_information_minimum_capacity"
              input-class="focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none  h-9 w-full"
              outer-class="flex-1"
              validation="required|number"
              min="1"
              :validation-messages="{
                required: $t('validation.required'),
                number: $t('validation.number'),
              }"
              message-class="text-[red] mt-2"
            />
            <div class="w-8 bg-[#eee] flex items-center justify-center">
              {{ $t("spaces_general_page.name") }}
            </div>
          </div>
          <div v-if="messagesFormError.general_space_information_minimum_capacity">
            <MessagesFormError :messages="messagesFormError.general_space_information_minimum_capacity" />
          </div>
        </div>
        <div class="form-card-group">
          <div class="w-80 rounded border border-solid border-[#ddd] flex ml-5">
            <div class="w-8 bg-[#eee] flex items-center justify-center">
              {{ $t("spaces_general_page.maximum") }}
            </div>
            <FormKit
              type="number"
              min="1"
              name="general_space_information_maximum_capacity"
              input-class="focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none  h-9 w-full"
              outer-class="flex-1"
              validation="required|number"
              :validation-messages="{
                required: $t('validation.required'),
                number: $t('validation.number'),
              }"
              message-class="text-[red] mt-2"
            />

            <div class="w-8 bg-[#eee] flex items-center justify-center">
              {{ $t("spaces_general_page.name") }}
            </div>
          </div>
          <div v-if="messagesFormError.general_space_information_maximum_capacity">
            <MessagesFormError :messages="messagesFormError.general_space_information_maximum_capacity" />
          </div>
        </div>
      </div>
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <i class="fa fa-paragraph mx-1"></i>
        <span class="font-bold">
          {{ $t("spaces_general_page.breadth") }}
        </span>
        <i class="fa fa-question-circle ml-1 text-[#337ab7]" aria-hidden="true" data-reactid=".7.0"></i>
      </div>
      <div class="flex-1">
        <div class="w-[660px] border border-solid border-[#ddd] rounded flex">
          <div class="w-10 border-r border-solid border-[#ddd] flex items-center justify-center bg-[#eee]">
            <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
          </div>
          <FormKit
            type="textarea"
            name="general_space_information_spaciousness_description_ja"
            :placeholder="$t('spaces_general_page.placeholder_6')"
            outer-class="w-full"
            input-class="w-full h-14 py-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none text-sx resize-none"
            validation="required"
            :validation-messages="{
              required: $t('validation.required'),
            }"
            message-class="text-[red] mt-2"
          />
        </div>
        <div v-if="messagesFormError.general_space_information_spaciousness_description_ja">
          <MessagesFormError :messages="messagesFormError.general_space_information_spaciousness_description_ja" />
        </div>
      </div>
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <span class="font-bold">
          {{ $t("spaces_general_page.price_plan") }}
        </span>
        <i class="fa fa-question-circle ml-1 text-[#337ab7]" aria-hidden="true" data-reactid=".7.0"></i>
      </div>
      <div class="flex-1">
        <div class="w-[800px] border border-solid border-[#ddd] rounded flex">
          <div class="w-10 border-r border-solid border-[#ddd] flex items-center justify-center bg-[#eee]">
            <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
          </div>
          <FormKit
            type="textarea"
            name="general_space_information_plan_ja"
            :placeholder="$t('spaces_general_page.placeholder_7')"
            outer-class="w-full"
            input-class="w-full h-20 py-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none text-sx resize-none"
            validation="required"
            :validation-messages="{
              required: $t('validation.required'),
            }"
            message-class="text-[red] mt-2"
          />
        </div>
        <div v-if="messagesFormError.general_space_information_plan_ja">
          <MessagesFormError :messages="messagesFormError.general_space_information_plan_ja" />
        </div>
      </div>
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <span class="font-bold"> {{ $t("spaces_general_page.movie") }} </span>
        <i class="fa fa-question-circle ml-1 text-[#337ab7]" aria-hidden="true" data-reactid=".7.0"></i>
      </div>
      <div class="flex-1 border border-solid border-[#ddd] rounded">
        <FormKit
          type="textarea"
          name="general_space_information_movie"
          outer-class="w-full"
          class="pt-[6px]"
          input-class="w-full h-14 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none text-sx resize-none pt-[8px]"
        />
        <div v-if="messagesFormError.general_space_information_movie">
          <MessagesFormError :messages="messagesFormError.general_space_information_movie" />
        </div>
      </div>
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <i class="fa fa-check mr-1"></i>
        <span class="font-bold">
          {{ $t("spaces_general_page.terms_of_service") }}
        </span>
        <i class="fa fa-question-circle ml-1 text-[#337ab7]" aria-hidden="true" data-reactid=".7.0"></i>
      </div>
      <div class="flex-1">
        <div class="w-full border border-solid border-[#ddd] rounded flex">
          <div class="w-10 border-r border-solid border-[#ddd] flex items-center justify-center bg-[#eee]">
            <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
          </div>
          <FormKit
            type="textarea"
            name="general_space_information_terms_of_service"
            :placeholder="$t('spaces_general_page.placeholder_8')"
            outer-class="w-full"
            input-class="w-full h-[174px] py-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none text-sx resize-none"
            validation="required"
            :validation-messages="{
              required: $t('validation.required'),
            }"
            message-class="text-[red] mt-2"
          />
        </div>
        <div v-if="messagesFormError.general_space_information_terms_of_service">
          <MessagesFormError :messages="messagesFormError.general_space_information_terms_of_service" />
        </div>
      </div>
    </div>

    <div class="mt-2">
      <div v-for="(item, index) in amountCancellation" :key="index" class="mb-2 flex items-center">
        <div class="w-64">
          <i class="fa fa-clock-o mr-1" data-reactid=".e.0.$2.0.0"></i>
          <span class="font-bold">
            {{ $t("spaces_general_page.add_cancellation_fee") }}
          </span>

          <!-- <div>errror</div> -->
        </div>

        <div class="flex-1 flex items-center">
          <div class="flex h-9">
            <select
              v-model="item.startDay"
              class="w-[150px] h-full px-2 bg-white border border-solid border-[#ddd] rounded outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
            >
              <option :value="option.value" v-for="option in OPTIONS_DATE" :key="option.value">
                {{ option.label }}
              </option>
            </select>
            <div class="w-11 h-full border border-solid border-[#ddd] rounded flex items-center justify-center">日</div>
          </div>
          <span class="inline-block mx-3"> ~ </span>
          <div class="flex h-9">
            <select
              v-model="item.endDay"
              class="w-[150px] h-full px-2 bg-white border border-solid border-[#ddd] rounded outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
            >
              <option :value="option.value" v-for="option in OPTIONS_DATE" :key="option.value">
                {{ option.label }}
              </option>
            </select>
            <div class="w-11 h-full border border-solid border-[#ddd] rounded flex items-center justify-center">日</div>
          </div>
          <div class="flex ml-3 items-center">
            <div class="border mr-1 border-solid border-[#ddd] rounded w-20">
              <input
                v-model="item.percentage"
                required
                max="100"
                type="number"
                class="focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none h-9 w-full"
              />
            </div>
            <span>%</span>
          </div>
          <div class="ml-3">
            <input v-model="item.isCouponApplicable" type="checkbox" name="isDiscount" id="isDiscount" />
            <label>{{ $t("spaces_general_page.label_1") }}</label>
          </div>
          <div
            class="group ml-10 border-solid border border-[#d43f3a] rounded flex items-center justify-center h-9 w-9 hover:bg-[#d43f3a]"
            @click="handleRemoveCancellation(index)"
          >
            <i class="fa fa-trash text-[#d43f3a] group-hover:text-white" data-reactid=".e.0.$2.6.0.0"></i>
          </div>
        </div>

        <!-- <div class="flex-1 flex items-center">
          <FormKit type="group" :name="`general_space_information_cancellation_fee_rules_${item}`">
            <div class="flex h-9">
              <FormKit
                type="select"
                name="start_day"
                :options="OPTIONS_DATE"
                wrapper-class="h-full "
                inner-class="h-full "
                input-class="w-[150px] h-full px-2 bg-white border border-solid border-[#ddd] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
              />
              <div class="w-11 h-full border border-solid border-[#ddd] rounded flex items-center justify-center">
                日
              </div>
            </div>
            <span class="inline-block mx-3"> ~ </span>
            <div class="flex h-9">
              <FormKit
                type="select"
                name="end_day"
                :options="OPTIONS_DATE"
                wrapper-class="h-full "
                inner-class="h-full "
                input-class="w-[150px] h-full px-2 bg-white border border-solid border-[#ddd] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
              />
              <div class="w-11 h-full border border-solid border-[#ddd] rounded flex items-center justify-center">
                日
              </div>
            </div>
            <div class="flex ml-3 items-center">
              <div class="border mr-1 border-solid border-[#ddd] rounded">
                <FormKit
                  type="text"
                  name="percentage"
                  input-class="focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none  h-9 w-full"
                  outer-class="w-20"
                  class="w-16"
                  validation="number"
                  :validation-messages="{
                    number: $t('validation.number'),
                  }"
                  message-class="text-[red] mt-2"
                />
              </div>
              <span>%</span>
            </div>
            <div class="ml-3">
              <FormKit
                name="is_coupon_applicable"
                type="checkbox"
                :label="$t('spaces_general_page.label_1')"
                wrapper-class="flex"
                label-class="ml-1"
              />
            </div>
            <div
              class="group ml-10 border-solid border border-[#d43f3a] rounded flex items-center justify-center h-9 w-9 hover:bg-[#d43f3a]"
              @click="handleRemoveCancellation"
            >
              <i class="fa fa-trash text-[#d43f3a] group-hover:text-white" data-reactid=".e.0.$2.6.0.0"></i>
            </div>
          </FormKit>
        </div> -->
      </div>

      <button
        class="bg-[#ffbd00] px-2 py-1 rounded hover:translate-y-[2px] transition-all"
        @click="handleAddCancellation"
      >
        <i class="fa fa-plus mr-1 text-white" data-reactid=".0.1.0"></i>
        <span class="text-white">
          {{ $t("spaces_general_page.added_cancellation_fee_rule") }}
        </span>
      </button>
      <MessagesFormError v-if="cancellationErr.dayOrder.isErr" :messages="cancellationErr.dayOrder.text" />
      <MessagesFormError v-if="cancellationErr.range.isErr" :messages="cancellationErr.range.text" />
      <MessagesFormError v-if="cancellationErr.maxPercents.isErr" :messages="cancellationErr.maxPercents.text" />
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <i class="fa fa-ban mr-1"></i>
        <span class="font-bold">
          {{ $t("spaces_general_page.cancellation_policy") }}
        </span>
        <i class="fa fa-question-circle text-[#337ab7] ml-1" aria-hidden="true" data-reactid=".7.0"></i>
      </div>
      <div class="flex-1">
        <div class="w-full border border-solid border-[#ddd] rounded flex">
          <div class="w-10 border-r border-solid border-[#ddd] flex items-center justify-center bg-[#eee]">
            <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
          </div>
          <FormKit
            type="textarea"
            name="general_space_information_cancellation_policy"
            :placeholder="$t('spaces_general_page.placeholder_9')"
            outer-class="w-full"
            input-class="w-full h-[114px] py-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none text-sx resize-none"
            validation="required"
            :validation-messages="{
              required: $t('validation.required'),
            }"
            message-class="text-[red] mt-2"
          />
        </div>
        <div v-if="messagesFormError.general_space_information_cancellation_policy">
          <MessagesFormError :messages="messagesFormError.general_space_information_cancellation_policy" />
        </div>
      </div>
    </div>
  </LayoutForm>
</template>

<script>
import JapanIcon from "@/assets/images/japan.png";
import LabelRequired from "@/components/LabelRequired";
import LayoutForm from "@/components/Layouts/LayoutForm.vue";
import { OPTIONS_DATE } from "@/const";
import MessagesFormError from "@/components/MessagesForm";
import { ref, watch } from "vue";
export default {
  name: "SpaceInformation",
  props: ["messagesFormError", "general_space_information_cancellation_fee_rules"],
  components: { LabelRequired, LayoutForm, MessagesFormError },
  setup(props, context) {
    const amountCancellation = ref([]);
    const cancellationErr = ref({
      dayOrder: {
        text: "開始日は終了日より大きいを入力して下さい",
        isErr: false,
      },
      range: {
        text: "範囲が重複してます",
        isErr: false,
      },
      maxPercents: {
        text: "0 から 100 までの値を入力してください。",
        isErr: false,
      },
    });
    const validateTimeCancel = () => {
      amountCancellation.value.forEach((range) => {
        if (range.startDay <= range.endDay) {
          cancellationErr.value.dayOrder.isErr = true;
          return;
        }
        for (let i = 0; i < amountCancellation.value.length; i++) {
          if (range === amountCancellation.value[i]) {
            continue;
          }
          if (
            range.startDay >= amountCancellation.value[i].endDay &&
            amountCancellation.value[i].startDay >= range.endDay
          ) {
            cancellationErr.value.range.isErr = true;
            return;
          }
        }
        cancellationErr.value.range.isErr = false;
        cancellationErr.value.dayOrder.isErr = false;
      });
    };
    watch(
      amountCancellation,
      (val) => {
        validateTimeCancel();
        context.emit("update:cancellation", val);
        if (val.length == 0) {
          cancellationErr.value.range.isErr = false;
          cancellationErr.value.dayOrder.isErr = false;
        }
      },
      { deep: true }
    );
    watch(
      cancellationErr,
      (val) => {
        const isErr = Object.values(val).some((field) => field.isErr);
        context.emit("validate:cancellation", isErr);
      },
      { deep: true }
    );
    watch(
      props,
      (val) => {
        amountCancellation.value = val.general_space_information_cancellation_fee_rules.map((item) => {
          return {
            ...item,
            isCouponApplicable: item.isCouponApplicable == "on" || item.isCouponApplicable,
          };
        });
      },
      { deep: true, immediate: true }
    );
    const handleAddCancellation = () => {
      context.emit("addNewCancellation");
    };
    const handleRemoveCancellation = (idx) => {
      context.emit("delete:cancellation", idx);
    };

    watch(
      amountCancellation,
      (val) => {
        if (val.some((item) => item.percentage > 100)) {
          cancellationErr.value.maxPercents.isErr = true;
        } else {
          cancellationErr.value.maxPercents.isErr = false;
        }
      },
      { deep: true }
    );
    return {
      handleAddCancellation,
      handleRemoveCancellation,
      OPTIONS_DATE,
      JapanIcon,
      amountCancellation,
      cancellationErr,
    };
  },
};
</script>

<style scoped></style>
