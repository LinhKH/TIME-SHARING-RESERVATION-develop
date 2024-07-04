<template>
    <LayoutModal :isShowModal="isShowModal" @onClose="handleClose">
        <div class="bg-white w-[600px] max-h-screen overflow-auto">
            <Logo class="w-full h-12 justify-center" />
            <div class="w-full p-3 leading-7 text-[18px] text-[#B6B0BA] bg-[#0D3F58]">
                【再送】【TIME SHARING】予約リクエストを承りました： みんなのテスト（利用日：2022年09月29日）
            </div>
            <div class="p-3">
                <div class="my-1">admin dev admin</div>
                <div class="my-1">We have received your reservation request for everyone's test.</div>
                <div class="my-1 text-[red]">Your reservation is not complete yet.</div>
                <div class="my-1 text-[red]">
                    We will contact you later regarding whether or not you can make a reservation, so please wait a
                    moment.
                </div>
                <div class="my-1">*Depending on the latest reservation status, we may deny your request. note that.
                </div>
                <hr />
                <div class="py-1">Booking details 　</div>
                <div class="py-1">
                    <span class="font-bold">Space name: </span>
                    <span>Minna no Test</span>
                </div>
                <div class="py-1">
                    <span class="font-bold">Plan Name: </span>
                    <span>Test Plan Cash</span>
                </div>
                <div class="py-1">
                    <span class="font-bold">Date of use: </span>
                    <span>2022-09-29</span>
                </div>
                <div class="py-1">
                    <span class="font-bold">Hours of use: </span>
                    <span>12:00 - 15:00</span>
                </div>
                <div class="py-1">
                    <span class="font-bold">Purpose of use: </span>
                    <span>Conference room</span>
                </div>
                <div class="py-1">
                    <span class="font-bold">Details of purpose of use: Details </span>
                    <span> of purpose of use</span>
                </div>
                <div class="py-1">
                    <span class="font-bold">Reservation contents:</span>
                </div>
                <table class="w-full py-1">
                    <tr>
                        <th></th>
                        <th>Number of guests</th>
                        <th>room rate</th>
                        <th>Price per person</th>
                        <th>Total (excluding tax)</th>
                    </tr>
                    <tr v-for="item in 5" :key="item">
                        <td>12:00-12:30</td>
                        <td>4 people</td>
                        <td>909 yen</td>
                        <td>0 yen/person</td>
                        <td>909 yen</td>
                    </tr>
                </table>
                <div class="py-1">
                    <span class="font-bold">Total space fee (excluding tax): </span>
                    <span>6,000 yen (5,455 yen)</span>
                </div>
                <div class="py-1">
                    <span class="font-bold">Space fee after discount (excluding tax) : </span>
                    <span>6,000 yen (5,455 yen)</span>
                </div>
                <div class="py-1">
                    <span class="font-bold">Space fee + option fee total (excluding tax) : </span>
                    <span>6,000 yen (5,455 yen)</span>
                </div>
                <div class="py-1 text-[red]">Customer payment amount (excluding tax) : 6,000 yen (5,455 yen)</div>
                <div class="py-1 font-bold">Questions from Space :</div>
                <div class="py-1">
                    <p>
                        Eating and Drinking <br />
                        Only lunch boxes and light meals can be brought in. However, if you are going to bring it in,
                        please declare
                        it in advance in the answer column below. <br />
                        *Be sure to take your trash home with you. We do not charge for disposal.
                    </p>
                </div>
                <div class="py-1">
                    <p>
                        Party use <br />
                        Party use is prohibited in principle.<br />
                        However, it may be possible to extend the business exchange meeting level such as
                        seminars.<br />
                        If you wish, please let us know in advance in the answer column below.
                    </p>
                </div>
                <div class="py-1">Also, be sure to check the terms of use and cancellation policy.</div>
            </div>
        </div>
    </LayoutModal>
</template>

<script>
import LayoutModal from "@/components/Layouts/LayoutModal.vue";
import Logo from "@/components/Elements/Logo.vue";
import { ref } from "vue";

export default {
    name: "ModalPreviewEmail",
    components: { LayoutModal, Logo },
    emits: ["close"],
    setup(_, context) {
        const isShowModal = ref(true);
        const handleClose = () => {
            isShowModal.value = false;
            context.emit("close");
        };
        return { isShowModal, handleClose };
    },
};
</script>
<style lang="scss" scoped>
th,
td {
    border: 1px solid #000;
}
</style>
