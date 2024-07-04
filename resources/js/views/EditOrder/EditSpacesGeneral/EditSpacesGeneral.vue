<template>
    <Suspense>
        <SpacesGeneral :actionType="ACTIONS_TYPE.UPDATE" />
    </Suspense>
</template>

<script>
import { ACTIONS_TYPE, MODULE_STORE, STEP_EDIT_SPACE } from "@/const";
import SpacesGeneral from "@/components/Spaces/SpacesGeneral";
import { useStore } from "vuex";

export default {
    name: "EditSpacesGeneral",
    components: { SpacesGeneral },
    setup() {
        const store = useStore();
        store.dispatch(
            `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
            STEP_EDIT_SPACE.SPACE_DETAILS
        );
        return { ACTIONS_TYPE };
    },
};
</script>

<style scoped></style>
