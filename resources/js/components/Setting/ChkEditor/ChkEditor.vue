<template>
  <ckeditor v-if="isRequired" :editor="ClassicEditor" v-model="formData[name]" :config="editorConfig"></ckeditor>
  <ckeditor v-else :editor="ClassicEditor" v-model="formData1[name]" :config="editorConfig"></ckeditor>
</template>

<script>
import { ref } from "vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  name: "ChkEditor",
  props: {
    formData: Object,
    formData1: Object,
    name: String,
    isRequired: Boolean,
  },

  setup() {
    const editorData = ref();
    const editorConfig = {};
    return { editorData, ClassicEditor, editorConfig };
  },
};
</script>
