<template>
  <LayoutForm :title="$t('spaces_general_page.location')" icon="fa fa-map-marker">
    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <i class="fa fa-map-o mx-1"></i>
        <span class="font-bold">
          {{ $t("spaces_general_page.post_code") }}
        </span>
      </div>
      <div class="flex-1">
        <div class="flex items-center">
          <FormKit
            type="text"
            name="general_location_post_code"
            outer-class="mr-4"
            validation="required|number"
            :validation-messages="{
              required: $t('validation.required'),
              number: $t('validation.number'),
            }"
            message-class="text-[red] mt-2"
            input-class="h-9 w-80 focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50 rounded border-solid border border-[#ddd] px-2 outline-none text-sx"
            class=""
          />

          <button
            class="p-2 h-9 border border-solid border-[#ddd] rounded bg-white focus:shadow-lg"
            @click="handleSendPostCode"
          >
            {{ $t("spaces_general_page.automatic_address_entry") }}
          </button>
        </div>
        <div v-if="messagesFormError.general_location_post_code">
          <MessagesFormError :messages="messagesFormError.general_location_post_code" />
        </div>
        <div class="mt-1">
          {{ $t("spaces_general_page.example_1") }}
        </div>
      </div>
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <span class="font-bold">
          {{ $t("spaces_general_page.prefectures") }}
        </span>
      </div>
      <div class="flex-1 flex items-center">
        <div class="form-card-group">
          <FormKit
            type="text"
            name="general_location_prefecture"
            placeholder=""
            outer-class="mr-4"
            input-class="h-9 w-80 focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50 rounded border-solid border border-[#ddd] px-2 outline-none text-sx"
            validation="required"
            :validation-messages="{
              required: $t('validation.required'),
            }"
            message-class="text-[red] mt-2"
          />
          <div v-if="messagesFormError.general_location_prefecture">
            <MessagesFormError :messages="messagesFormError.general_location_prefecture" />
          </div>
        </div>

        <div class="p-2 h-9">{{ $t("spaces_general_page.example_2") }}</div>
      </div>
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <span class="font-bold">
          {{ $t("spaces_general_page.municipalities") }}
        </span>
      </div>
      <div class="flex-1 flex items-center">
        <div class="form-card-group">
          <FormKit
            type="text"
            name="general_location_municipality"
            outer-class="mr-4 "
            input-class="h-9 w-80 focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50 rounded border-solid border border-[#ddd] px-2 outline-none text-sx"
            validation="required"
            :validation-messages="{
              required: $t('validation.required'),
            }"
            message-class="text-[red] mt-2"
          />
          <div v-if="messagesFormError.general_location_municipality">
            <MessagesFormError :messages="messagesFormError.general_location_municipality" />
          </div>
        </div>

        <div class="p-2 h-9">{{ $t("spaces_general_page.example_3") }}</div>
      </div>
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <span class="font-bold">
          {{ $t("spaces_general_page.address_building_name") }}
        </span>
      </div>
      <div class="flex-1 flex items-center">
        <div class="form-card-group w-full">
          <FormKit
            type="text"
            name="general_location_address_ja"
            :help="$t('spaces_general_page.help_4')"
            outer-class="w-full"
            help-class=" mt-1"
            input-class="h-9 w-full focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50 rounded border-solid border border-[#ddd] px-2 outline-none text-sx"
            validation="required"
            :validation-messages="{
              required: $t('validation.required'),
            }"
            message-class="text-[red] mt-2"
          />
          <div v-if="messagesFormError.general_location_address_ja">
            <MessagesFormError :messages="messagesFormError.general_location_address_ja" />
          </div>
        </div>
      </div>
    </div>

    <div class="flex mt-2 items-center">
      <div class="w-64">
        <LabelRequired />
        <i class="fa fa-location-arrow mr-1"></i>
        <span class="font-bold">
          {{ $t("spaces_general_page.how_to_access") }}
        </span>
        <i class="fa fa-question-circle ml-1 text-[#337ab7]" aria-hidden="true" data-reactid=".6.0"></i>
      </div>
      <div class="flex-1">
        <div class="w-full border border-solid border-[#ddd] rounded flex">
          <div class="flex items-center justify-center border-r border-solid border-[#ddd] w-10 bg-[#eee]">
            <img :src="JapanIcon" alt="japan" class="w-9 object-cover" />
          </div>
          <FormKit
            type="textarea"
            name="general_location_access_instruction_ja"
            :placeholder="$t('spaces_general_page.placeholder_5')"
            outer-class="w-full"
            input-class="w-full py-2 h-20 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 px-2 outline-none text-sx resize-none"
            validation="required"
            :validation-messages="{
              required: $t('validation.required'),
            }"
            message-class="text-[red] mt-2"
          />
        </div>
        <div v-if="messagesFormError.general_location_access_instruction_ja">
          <MessagesFormError :messages="messagesFormError.general_location_access_instruction_ja" />
        </div>
        <div class="mt-2">
          <span>{{ $t("spaces_general_page.remarks") }} </span>
          <span class="text-[#337ab7]">{{ $t("spaces_general_page.transportation_facilities") }} </span>
          <span>{{ $t("spaces_general_page.help_5") }}</span>
        </div>
      </div>
    </div>
  </LayoutForm>
</template>

<script>
import JapanIcon from "@/assets/images/japan.png";
import LabelRequired from "@/components/LabelRequired";
import LayoutForm from "@/components/Layouts/LayoutForm.vue";
import MessagesFormError from "@/components/MessagesForm";
export default {
  name: "Location",
  components: { LabelRequired, LayoutForm, MessagesFormError },
  props: ["messagesFormError"],
  setup(_, context) {
    const handleSendPostCode = () => {
      context.emit("inputAddress");
    };
    return { JapanIcon, handleSendPostCode };
  },
};
</script>

<style scoped></style>
