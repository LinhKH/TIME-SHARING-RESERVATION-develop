<template>
    <div>
        <div class="px-4 flex flex-wrap text-[18px]">
            <div class="mr-[24px]">
                {{
                    $t("space_detail_client.space_info_descs.near_station_full", {
                        station: getNearStationLabel.transportation_name,
                        minute: getNearStationLabel.walking_duration,
                })
                }}
            </div>
            <div class="mr-[24px]">
                {{
                    $t("space_detail_client.space_info_descs.people", {
                        people: max_people,
                })
                }}
            </div>
            <div class="mr-[24px]">
                <div class="mr-[24px]">
                    {{ $t("space_detail_client.space_info_descs.price_label") }}
                </div>
                <span class="text-[24px]">{{ getPriceLabel }}</span>
            </div>
        </div>
        <div class="mt-3 list-link px-4">
            <div><i class="fa fa-list mr-[4px]"></i> {{ $t("space_detail_client.space_info_descs.go_to_item") }}</div>
            <div>
                <a href="#images" class="text-[#06f]">{{ $t(`space_detail_client.space_info_descs.images`) }}</a>
            </div>
            <div>
                <a href="#payment_methods" class="text-[#06f]">{{
                    $t(`space_detail_client.space_info_descs.payment_methods`)
                    }}</a>
            </div>
            <div>
                <a href="#space_information" class="text-[#06f]">{{
                    $t(`space_detail_client.space_info_descs.space_information`)
                    }}</a>
            </div>
            <div>
                <a href="#equip" class="text-[#06f]">{{ $t(`space_detail_client.space_info_descs.equip`) }}</a>
            </div>
            <div v-for="page in list_page" :key="page.id">
                <a :href="`#${page.title}`" class="text-[#06f]" v-if="page.content.length">{{
                    $t(`list_page.${page.title}`)
                    }}</a>
            </div>
        </div>
    </div>
</template>

<script>
import { computed } from "@vue/runtime-core";
import { TYPE_COMMON } from "@/const";
import { ref } from "vue";
import { useI18n } from "vue-i18n";
export default {
    name: "SideFixSpaceDetailClient",
    props: {
        information: {
            type: Object,
            default: () => ({}),
        },
    },
    setup(props) {
        const { t } = useI18n();
        // infor
        const max_people = computed(() => props.information?.general?.general_space_information_maximum_capacity || 0);

        // near station
        const list_near_station = computed(() => props.information?.near_transporttation?.near_transportations || []);
        const getNearStationLabel = computed(() => {
            let result = {};
            if (list_near_station?.value?.length) {
                const newArr = list_near_station.value
                    .filter(
                        (c) => c.route === TYPE_COMMON.subway || c.route == TYPE_COMMON.train || c.route == TYPE_COMMON.monorail
                    )
                    .sort((a, b) => a.walking_duration - b.walking_duration);
                if (newArr.length) {
                    result = newArr[0];
                }
            }
            return result;
        });

        // interval
        const list_interval = computed(() => {
            let result = [];
            if (props.information?.plan) {
                Object.keys(props.information?.plan).forEach((key) => {
                    result = result.concat(props.information.plan[key].rental_intervals);
                });
            }
            return result;
        });
        const getPriceLabel = computed(() => {
            let result = "";
            let priceResult = [];
            if (list_interval.value?.length) {
                list_interval.value.forEach((interval) => {
                    const arrStringStart = interval.start_time_formatted.split(":");
                    const startTime = Number(arrStringStart[0]) * 60 + Number(arrStringStart[1]);
                    const arrStringEnd = interval.end_time_formatted.split(":");
                    const endTime = Number(arrStringEnd[0]) * 60 + Number(arrStringEnd[1]);
                    let count = (endTime - startTime) / 60;
                    if (endTime - startTime < 60) {
                        count = 60 / (endTime - startTime);
                    }
                    const price = (interval.tenancy_price + interval.per_person_price) * count;
                    priceResult.push(price);
                });
            }
            const min = Math.ceil(Math.min.apply(Math, priceResult));
            const max = Math.ceil(Math.max.apply(Math, priceResult));
            result += t("space_detail_client.space_info_descs.price", {
                min,
                max,
            });
            return result;
        });

        const list_page = computed(() => props.information?.page || []);

        return {
            max_people,
            getNearStationLabel,
            list_interval,
            getPriceLabel,
            list_page,
        };
    },
};
</script>

<style></style>
