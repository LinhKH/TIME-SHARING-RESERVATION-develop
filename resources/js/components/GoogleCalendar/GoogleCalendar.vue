<template>
    <div class="p-3">
        <div class="flex justify-between">
            <div class="w-[35%]">
                <div class="flex flex-wrap items-center">
                    <div class="flex mr-2">
                        <i class="fa fa-home text-[#337ab7] text-xl mr-2"></i>
                        <span class="text-[#337ab7] text-xl">Test</span>
                    </div>
                    <a :href="linkRoute.spaceDetailClient" target="_blank">
                        <span
                            class="group flex items-center bg-[#ffbd00] rounded-sm text-white cursor-pointer hover:bg-[#fff1cc] hover:text-[#ffbd00] px-2 btn-public">
                            <i class="fa fa-external-link text-white group-hover:text-[#ffbd00] mr-1"></i>
                            {{ $t("edit_space_page.view_public_page") }}
                        </span>
                    </a>
                </div>
                <div class="flex mt-2 mb-5"></div>
            </div>
            <div class="w-[35%]">
                <div v-if="type === 'admin'"
                    class="w-full border border-solid border-[#666] rounded flex justify-between px-2 py-1 cursor-pointer"
                    @click="isShowBoxChangeStatus = !isShowBoxChangeStatus">
                    <div class="">
                        <template v-if="isPrivate">
                            <div class="font-bold text-[#666]">{{ $t("edit_space_page.status_private") }}</div>
                            <div class="font-bold text-[#737373]">{{ $t("edit_space_page.undisclosed") }}</div>
                        </template>
                        <template v-if="isPublic">
                            <div class="font-bold text-[#37a200]">{{ $t("edit_space_page.status_public") }}</div>
                            <div class="font-bold text-[#737373]">{{ $t("edit_space_page.released") }}</div>
                        </template>
                    </div>
                    <div class="">
                        <i class="fa fa-chevron-down text-[#37a200]" v-if="isPublic"></i>
                        <i class="fa fa-chevron-down text-[#737373]" v-if="isPrivate"></i>
                    </div>
                </div>
                <div class="w-full py-1 border-l border-r border-solid border-[#666] rounded shadow-lg"
                    v-if="isShowBoxChangeStatus && isPrivate">
                    <div class="px-4 py-2 hover:bg-[#eee] cursor-pointer"
                        @click="() => handleChangeStatus(STATUS_SPACE.PUBLIC)">
                        <div class="border border-solid border-[#37a200] text-[#37a200] p-2 rounded font-bold text-sm">
                            {{ $t("edit_space_page.change_to_publishing") }}
                        </div>
                        <div class="text-[#737373] mt-2">{{ $t("edit_space_page.released") }}</div>
                    </div>
                    <div class="px-4 py-2 bg-[#fff15e] cursor-pointer" @click="isShowBoxChangeStatus = false">
                        <div class="border border-solid border-[#666] text-[#666] p-2 rounded font-bold text-sm">
                            {{ $t("edit_space_page.currently_private") }}
                        </div>
                        <div class="text-[#666] mt-2">{{ $t("edit_space_page.undisclosed") }}</div>
                    </div>
                </div>
                <div class="w-full py-1 border-l border-r border-solid border-[#666] rounded shadow-lg"
                    v-if="isShowBoxChangeStatus && isPublic">
                    <div class="px-4 py-2 bg-[#fff15e] cursor-pointer" @click="isShowBoxChangeStatus = false">
                        <div class="border border-solid border-[#37a200] text-[#37a200] p-2 rounded font-bold text-sm">
                            {{ $t("edit_space_page.currently_open") }}
                        </div>
                        <div class="text-[#737373] mt-2">{{ $t("edit_space_page.released") }}</div>
                    </div>
                    <div class="px-4 py-2 hover:bg-[#eee] cursor-pointer"
                        @click="() => handleChangeStatus(STATUS_SPACE.ARCHIVED)">
                        <div class="border border-solid border-[#666] text-[#666] p-2 rounded font-bold text-sm">
                            {{ $t("edit_space_page.change_to_private") }}
                        </div>
                        <div class="text-[#666] mt-2">{{ $t("edit_space_page.undisclosed") }}</div>
                    </div>
                </div>
            </div>
        </div>
        <StepDetailOrder />
        <!-- <router-view :maxPlan="maxPlan" /> -->
        <div class="calendar-collaboration mt-[20px]" v-if="isLinkGoogle">
            <h1>Googleカレンダー同期</h1>
            <div class="calendar-button">
                <button class="btn-danger" @click="handleGoogleCalendar">Googleカレンダー連携解除</button>
                <span>連携済みアカウント : sonmhmor@gmail.com</span>
            </div>
            <p>連携するカレンダーを選択していない場合は、「カレンダー選択」より、連携するカレンダーを決定してください。</p>
            <p class="mb-[20px]">
                連携していると、一方のカレンダーに予定（予約）が入ると、もう一方のカレンダーにリアルタイムで同期されます。
            </p>
            <h1>カレンダー選択</h1>
            <p class="mb-[10px]">
                接続するカレンダーを選択して「カレンダーを決定・変更」ボタンを押してください。ボタンを押すと、一度、現在のカレンダーと同期処理を行います。
            </p>
            <p class="mb-[10px]">特別な事情がない限り、接続する2つのカレンダーは同じカレンダーを指定してください。</p>
            <p class="mb-[10px]">
                （スペなびの予定 → Google）（Googleの予定 → スペなび）の2つが「◯接続済み」になっていれば準備は完了です。
            </p>
            <p class="mb-[10px]">その後は、自動的にリアルタイムで同期されます。</p>

            <div v-for="item in formInput" :key="item" class="calendar-contact mb-[10px]">
                <div class="w-[40%] flex justify-between items-center">
                    <span>{{ item.title }}</span>
                    <span>{{ item.subtitle }}</span>
                </div>

                <div class="w-[60%] flex justify-around items-center ml-[30px]">
                    <div class="select-box">
                        <select v-model="item.valueInput" name="" id="">
                            <option v-for="option in listSelect" :key="option" :value="option">{{ option }}</option>
                        </select>
                    </div>

                    <button class="contact-button">カレンダーを決定・変更</button>
                </div>
            </div>

            <div class="caledar-footer">
                <h2 class="text-[18px] font-semibold mb-[10px]">注意事項</h2>
                <p>
                    TIME SHARINGからの予約をキャンセルまたは時間変更する場合、Googleカレンダー上で予約を変更して同期をしても、TIME
                    SHARINGのカレンダーには反映されず予約内容は変更されません。
                </p>
                <p>必ず管理画面にログインし、予約をキャンセルしていただくようお願いいたします。</p>
                <p>例）TIME SHARINGで予約をしたお客様がキャンセルを希望</p>
                <p class="mb-[10px]">
                    TIME SHARINGにログインして、予約をキャンセルすると、自動的にGoogleカレンダーから該当の予定が削除されます。
                </p>
                <p>同期処理に時間がかかる場合があります。（特に初回は時間がかかる場合があります。）</p>
            </div>
        </div>

        <div class="google-calendar mt-[20px]" v-else>
            <p>TIME SHARINGの予約カレンダーとGoogleカレンダーのインポート/エクスポート設定を行うことができます。</p>
            <p>設定すると、一方のカレンダーに予定（予約）が入ると、もう一方のカレンダーにリアルタイムで同期されます。</p>
            <div>
                <button @click="handleGoogleCollaboration" class="btn-info">Googleカレンダーと連携</button>
                <span> Googleカレンダーからインポート/エクスポートを行うアカウントを選択します。</span>
            </div>
        </div>
    </div>
</template>
<script>
import StepDetailOrder from "@/components/StepDetailOrder";
import { MODULE_STORE, ROUTER_PATH, STATUS_SPACE } from "@/const";
import { computed, inject, ref } from "vue";
import { useStore } from "vuex";
import { useRoute, useRouter } from "vue-router";
import { getStatusSpace, updateStatusSpace } from "@/api";
import { useI18n } from "vue-i18n";
// import { ROUTER_PATH, MODULE_STORE } from "@/const";
export default {
    components: { StepDetailOrder },
    setup() {
        const store = useStore();
        const route = useRoute();
        const router = useRouter();
        const type = localStorage.getItem("type");
        const { t } = useI18n();
        const toast = inject("$toast");
        const statusSpace = ref("");
        const maxPlan = ref(0);
        const isLinkGoogle = ref(true);
        const isPublic = computed(() => statusSpace.value == STATUS_SPACE.PUBLIC);
        const isPrivate = computed(() => statusSpace.value == STATUS_SPACE.ARCHIVED);
        const isShowBoxChangeStatus = ref(false);
        const handleGoogleCalendar = () => {
            isLinkGoogle.value = false;
        };
        const listSelect = ["sonmh@mor.com.vn", "abc@gmail.com"];
        const formInput = ref([
            {
                id: 1,
                title: "(スペなびの予定 → Google)",
                subtitle: "接続済み",
                valueInput: "sonmh@mor.com.vn",
            },
            {
                id: 2,
                title: "(Googleの予定 → スペなび）",
                subtitle: "接続済み",
                valueInput: "sonmh@mor.com.vn",
            },
        ]);
        const handleGoogleCollaboration = () => {
            // router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.GOOGLE_COLLABORATION}`);
        };
        const nameSpace = computed(
            () => store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_NAME_SPACE}`]
        );
        const idSpace = route.params.id;
        // const idSpace = 129;
        const linkRoute = {
            spaceDetailClient: `${ROUTER_PATH.HOME}${idSpace}/${ROUTER_PATH.SPACE_DETAILS_CLIENT}`,
            reservationCalendar: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATION_CALENDAR}`,
            reservationRegister: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATION_REGISTER}?id=${idSpace}`,
        };
        const getStatusSpaceFromApi = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getStatusSpace(idSpace);
                statusSpace.value = res.data?.status;
                maxPlan.value = res.data?.max_rental_plans_count || 0;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        };
        const handleChangeStatus = async (status) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                isShowBoxChangeStatus.value = false;
                await updateStatusSpace(idSpace, { status });
                toast.success(t("toast_message.update_success"));
                getStatusSpaceFromApi();
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        };
        getStatusSpaceFromApi();
        return {
            nameSpace,
            linkRoute,
            isShowBoxChangeStatus,
            isPublic,
            isPrivate,
            STATUS_SPACE,
            handleChangeStatus,
            type,
            maxPlan,
            handleGoogleCollaboration,
            isLinkGoogle,
            handleGoogleCalendar,
            formInput,
            listSelect,
        };
    },
};
</script>

<style scoped lang="scss">
.btn-public {
    height: 20px;
}

.btn-info {
    color: #fff;
    background-color: #5bc0de;
    border-color: #46b8da;
    font-size: 14px;
    padding: 8px;
    border-radius: 5px;

    &:hover {
        color: #fff;
        background-color: #31b0d5;
        border-color: #269abc;
    }
}

.google-calendar {
    & p {
        margin-bottom: 10px;
    }
}

.calendar-collaboration {
    & h1 {
        font-size: 18px;
        margin-bottom: 10px;
    }
}

.calendar-button {
    margin-bottom: 10px;
}

.btn-danger {
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
    border-radius: 6px;

    padding: 8px 100px;
    margin-right: 50px;
}

.calendar-contact {
    width: 80%;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.select-box {
    width: 45%;

    & select {
        border: 1px solid #ccc;
        width: 100%;
        padding: 8px 12px;
        border-radius: 5px;
    }
}

.caledar-footer {
    background-color: #fcf8e3;
    border-color: #faebcc;
    padding: 5px;
    border: 1px solid transparent;
    margin-top: 20px;

    & p {
        color: #8a6d3b;
    }
}

.contact-button {
    background: #ffbd00;
    color: #fff;
    box-shadow: 0 1px 1px #a4966e;
    font-size: 14px;
    padding: 8px;
    border-radius: 5px;
    //   &:hover {
    //     color: #fff;
    //     background-color: #31b0d5;
    //     border-color: #269abc;
    //   }
}
</style>
