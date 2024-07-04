<template>
  <div class="w-full h-full bg-[#212121] py-[20px]">
    <div class="grid grid-cols-6 w-full h-[70%] px-[15px]">
      <div>
        <h1></h1>
      </div>
      <div>
        <ul>
          <li class="text-[#aaa] text-[1.8rem] mt-[20px] mb-[10px] tracking-[.2em]">GUIDE</li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.guide.help") }}
          </li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.guide.about_company") }}
          </li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.guide.privacy_policy") }}
          </li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.guide.information") }}
          </li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.guide.policy") }}
          </li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.guide.symbol") }}
          </li>
        </ul>
      </div>
      <div></div>
      <div>
        <ul>
          <li class="text-[#aaa] text-[1.8rem] mt-[20px] mb-[10px] tracking-[.2em]">LINK</li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.link.cook") }}
          </li>
        </ul>
      </div>
      <div>
        <ul>
          <li class="text-[#aaa] text-[1.8rem] mt-[20px] mb-[10px] tracking-[.2em]">CONTACT</li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.contact.address_email") }}
          </li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.contact.company") }}
          </li>
          <li class="text-[#fff] text-[14px] my-[0.5em] mx-auto leading-5">
            {{ $t("overview_page_user.root.contact.other") }}
          </li>
        </ul>
      </div>
      <div></div>
    </div>
    <div class="w-full h-[30%] flex justify-start items-center px-[15px] pt-[20px]">
      <div class="text-[#aaa] text-[2rem] tracking-[.2em]">FOLLOW US</div>
      <div class="my-[0.5em] py-[5px] px-[15px] w-[62px] h-[32px] text-center rounded">
        <div class="w-[24px] h-[24px] rounded item-center m-auto bg-[#fff]">
          <i class="fa fa-facebook mt-[6px]"></i>
        </div>
      </div>
      <div class="my-[0.5em] py-[5px] px-[15px] w-[62px] h-[32px] text-center rounded">
        <div class="w-[24px] h-[24px] rounded item-center m-auto bg-[#fff]">
          <i class="fa fa-instagram mt-[6px]"></i>
        </div>
      </div>
      <div class="my-[0.5em] py-[5px] px-[15px] w-[62px] h-[32px] text-center rounded">
        <div class="w-[24px] h-[24px] rounded item-center m-auto bg-[#fff]">
          <i class="fa fa-twitter mt-[6px]"></i>
        </div>
      </div>
      <div class="my-[0.5em] py-[5px] px-[15px] w-[62px] h-[32px] text-center rounded">
        <div class="w-[24px] h-[24px] rounded item-center m-auto bg-[#fff]">
          <icon-line-chat />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import IconLineChat from "./IconLineChat.vue";
export default {
  components: { IconLineChat },
  name: "RootOverviewUser",
  setup() {},
};
</script>

<style scoped></style>
