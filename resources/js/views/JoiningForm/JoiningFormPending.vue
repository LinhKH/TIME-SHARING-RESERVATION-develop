<template>
  <joining-form-base-layout :alert-message="$t('joining.already-submitted')">
    <json-form
      :definition="definition"
      :contents="defaultContents"
      :meta="meta"
      :errors="errors"
      :serverErrors="[]"
    ></json-form>
  </joining-form-base-layout>
</template>

<script lang="ts">
import { defineComponent, PropType, ref, toRefs } from "vue";
import JoiningFormBaseLayout from "@/views/JoiningForm/JoiningFormBaseLayout.vue";
import JsonForm from "@/components/JsonForm/JsonForm.vue";
import { JSONFormDefinition, JSONFormMetaData } from "@/types/JSONForm";
import { JSONFormContents } from "@/types/JSONFormContents";
import { JSONFormError, normalizeError } from "@/types/JSONFormError";

export default defineComponent({
  components: {
    JoiningFormBaseLayout,
    JsonForm,
  },
  props: {
    status: {
      type: String,
      required: true,
    },
    definition: {
      type: Object as PropType<JSONFormDefinition>,
      required: true,
    },
    defaultContents: {
      type: Object as PropType<JSONFormContents>,
      required: true,
    },
    meta: {
      type: Object as PropType<JSONFormMetaData>,
      required: true,
    },
  },
  setup(props) {
    const { definition, defaultContents, meta } = toRefs(props);

    const errors = ref<JSONFormError>(
      normalizeError(definition.value, defaultContents.value, {}, meta.value, {
        autoValidate: true,
      })
    );

    return {
      errors,
    };
  },
});
</script>
