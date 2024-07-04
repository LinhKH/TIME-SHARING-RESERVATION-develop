<template>
  <div>
    <Header />
    <div class="flex justify-center">
      <div class="w-full pt-[20px] px-[5%] md:w-[38%]">
        <div>
          <h2 class="text-[30px] text-[#000000] leading-[44px]">{{ $t(`form_auth.title.register`) }}</h2>
        </div>
        <div class="mt-[70px]">
          <h3 class="text-[18px] text-[#000000] mb-[20px] leading-[24px]">{{ $t(`form_auth.create_with_email`) }}</h3>
          <form @submit="submitForm">
            <div class="p-[10px] mb-[10px] bg-[#f2dede]" v-if="!isEmpty(errors)">
              <div v-for="(error, index) in errors" :key="index">
                <span class="text-[#af2e2e] text-[16px] leading-[24px] font-[400]">{{ error }} </span>
              </div>
            </div>
            <div class="flex flex-col gap-[5px]">
              <div class="flex flex-col gap-[5px]">
                <div class="h-[34px]">
                  <Field
                    name="email"
                    type="text"
                    :placeholder="$t(`form_auth.placeholder.email`)"
                    class="w-full h-full flex-1 focus:outline-none rounded-[2px] text-[#555555] text-[14px] block px-[12px] py-[6px] border border-[#ccc] focus:border-[#66afe9] shadow-[0_0_2px_0px_#acacac] focus:shadow-[0_0_5px_0_#66afe9]"
                  />
                </div>
                <div class="h-[34px]">
                  <Field
                    name="password"
                    type="password"
                    :placeholder="$t(`form_auth.placeholder.password`)"
                    class="w-full h-full flex-1 focus:outline-none rounded-[2px] text-[#555555] text-[14px] block px-[12px] py-[6px] border border-[#ccc] focus:border-[#66afe9] shadow-[0_0_2px_0px_#acacac] focus:shadow-[0_0_5px_0_#66afe9]"
                  />
                </div>
                <div class="h-[34px]">
                  <Field
                    name="password_confirmation"
                    type="password"
                    :placeholder="$t(`form_auth.placeholder.confirm_password`)"
                    class="w-full h-full flex-1 focus:outline-none rounded-[2px] text-[#555555] text-[14px] block px-[12px] py-[6px] border border-[#ccc] focus:border-[#66afe9] shadow-[0_0_2px_0px_#acacac] focus:shadow-[0_0_5px_0_#66afe9]"
                  />
                </div>
              </div>
            </div>
            <div class="flex align-center pt-[10px]">
              <input type="checkbox" class="mr-[5px]" required />

              <span class="text-[#626262]"
                ><router-link to="/" class="text-[#1890ff]">{{ $t(`form_auth.agreement`) }}</router-link
                >{{ $t(`form_auth.when`) }}
                <router-link to="/" class="text-[#1890ff]">{{ $t(`form_auth.personal_information`) }}</router-link>
                {{ $t(`form_auth.agree`) }}</span
              >
            </div>
            <ButtonSubmit :content="$t(`form_auth.register`)" />
            <div class="mt-[70px] text-[16px]">
              <span class="text-[#626262]">
                {{ $t(`form_auth.have_account`) }}
                <router-link :to="ROUTER_PATH.LOGIN_CUSTOMER" class="text-[#1890ff]">{{
                  $t(`form_auth.login`)
                }}</router-link>
              </span>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import * as Yup from "yup";
import { inject } from "vue";
import { useStore } from "vuex";
import { isEmpty } from "lodash";
import { useI18n } from "vue-i18n";
import { MODULE_STORE } from "@/const";
import { ROUTER_PATH } from "@/const";
import { createCustomer } from "@/api";
import { Field, useForm } from "vee-validate";
import Header from "@/components/FormAuth/Header.vue";
import ButtonSubmit from "@/components/FormAuth/ButtonSubmit.vue";

export default {
  components: {
    Header,
    ButtonSubmit,
    Field,
  },
  setup() {
    const store = useStore();
    const { t } = useI18n();
    const toast = inject("$toast");
    const { handleSubmit, errors } = useForm({
      initialValues: {
        email: "",
        password: "",
      },
      validationSchema: Yup.object().shape({
        email: Yup.string().required(t(`form_auth.errors.email_required`)).email(t(`form_auth.errors.email_syntax`)),
        password: Yup.string().required().min(6, t(`form_auth.errors.password_length`)),
        password_confirmation: Yup.string()
          .oneOf([Yup.ref("password"), null], t(`form_auth.errors.password_required`))
          .required(t(`form_auth.errors.password_required`)),
      }),
    });
    const submitForm = handleSubmit(async (values) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await createCustomer(values);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    });
    return {
      submitForm,
      isEmpty,
      errors,
      ROUTER_PATH,
    };
  },
};
</script>