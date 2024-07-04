import { MODULE_STORE, STEP_EDIT_SPACE, ROUTER_PATH } from "@/const";

const rentalSpaces = {
  namespaced: true,
  state() {
    return {
      listSteps: [
        {
          active: true,
          text: "スペース情報入力",
        },
        {
          active: false,
          text: "画像登録",
        },
        {
          active: false,
          text: "設備情報登録",
        },
        {
          active: false,
          text: "予約システム登録",
        },
        {
          active: false,
          text: "オプション登録",
        },
        {
          active: false,
          text: "プラン作成",
        },
        {
          active: false,
          text: "予約枠作成",
        },
        {
          active: false,
          text: "規約・メッセージ入力",
        },
        {
          active: false,
          text: "スペース公開申請",
        },
      ],
      listMenuEdit: [
        {
          icon: "fa fa-info-circle",
          name: "スペース詳細",
          isActive: true,
          type: STEP_EDIT_SPACE.SPACE_DETAILS,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}`,
        },
        {
          icon: "fa fa-picture-o",
          name: "画像",
          isActive: false,
          type: STEP_EDIT_SPACE.IMAGE,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.IMAGES}`,
        },
        {
          icon: "fa fa-plus-square",
          name: "設備情報",
          isActive: false,
          type: STEP_EDIT_SPACE.EQUIPMENT_INFORMATION,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.EQUIPMENT_INFORMATION}`,
        },
        {
          icon: "fa fa-calendar-plus-o",
          name: "予約システム",
          isActive: false,
          type: STEP_EDIT_SPACE.RESERVATION_SYSTEM,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.RESERVATION_SYSTEM}`,
        },
        {
          icon: "fa fa-columns",
          name: "規約等",
          isActive: false,
          type: STEP_EDIT_SPACE.TERMS,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.PAGE_MANAGE}`,
        },
        {
          icon: "fa fa-envelope-o",
          name: "挿入メッセージ",
          isActive: false,
          type: STEP_EDIT_SPACE.INSERT_MESSAGE,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.MESSAGE_MANAGE}`,
        },
        {
          icon: "fa fa-picture-o",
          name: "360度 写 真",
          isActive: false,
          type: STEP_EDIT_SPACE.DEGREE_PHOTO,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.PANORAMA_IMAGES}`,
        },
        {
          icon: "fa fa-picture-o",
          name: "外観・入り口写真",
          isActive: false,
          type: STEP_EDIT_SPACE.APPEARANCE_ENTRANCE,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.FACADE_IMAGES}`,
        },
        {
          icon: "fa fa-picture-o",
          name: "駅経路",
          isActive: false,
          type: STEP_EDIT_SPACE.STATION_ROUTE,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.DIRECTIONS_STATION_IMAGES}`,
        },
        {
          icon: "fa fa-picture-o",
          name: "図面",
          isActive: false,
          type: STEP_EDIT_SPACE.DRAWING,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.FLOOR_PLAN}`,
        },
        {
          icon: "fa fa-subway",
          name: "交通機関",
          isActive: false,
          type: STEP_EDIT_SPACE.TRANSPORTATION_FACILITIES,
          link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.TRANSPORTATION_FACILITIES}`,
        },
      ],
      nameSpace: null,
      idEditSpace: null,
      stepSpaceCreated: null,
      idPlan: null,
      namePlanCurrent: null,
      previewedSpace: null,
      listPreviewedSpace: [],
    };
  },
  getters: {
    [MODULE_STORE.RENTAL_SPACES.GETTERS.GET_LIST_STEPS](state) {
      return state.listSteps;
    },
    [MODULE_STORE.RENTAL_SPACES.GETTERS.GET_LIST_STEP_EDIT](state) {
      return state.listMenuEdit;
    },
    [MODULE_STORE.RENTAL_SPACES.GETTERS.GET_NAME_SPACE](state) {
      return state.nameSpace;
    },
    [MODULE_STORE.RENTAL_SPACES.GETTERS.GET_ID_EDIT_SPACE](state) {
      return state.idEditSpace;
    },
    [MODULE_STORE.RENTAL_SPACES.GETTERS.GET_STEP_SPACE_CREATED](state) {
      return state.stepSpaceCreated;
    },
    [MODULE_STORE.RENTAL_SPACES.GETTERS.GET_ID_PLAN](state) {
      return state.idPlan;
    },
    [MODULE_STORE.RENTAL_SPACES.GETTERS.GET_NAME_PLAN_CURRENT](state) {
      return state.namePlanCurrent;
    },
    getPreviewedSpace: (state) => {
      return state.previewedSpace;
    },
    getListPreviewedSpace: (state) => {
      return state.listPreviewedSpace;
    },
  },
  mutations: {
    [MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_ID_PLAN](state, payload) {
      state.idPlan = payload;
    },
    [MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_ID_EDIT_SPACE](state, payload) {
      state.idEditSpace = payload;
    },
    [MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED](state, payload) {
      state.stepSpaceCreated = payload;
    },
    [MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_NAME_SPACE](state, payload) {
      state.nameSpace = payload;
    },
    [MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_NAME_PLAN_CURRENT](state, payload) {
      state.namePlanCurrent = payload;
    },
    SET_PREVIEWED_SPACE(state, payload) {
      state.previewedSpace = payload;
    },
    SET_LIST_PREVIEWED_SPACE(state, payload) {
      state.listPreviewedSpace = payload;
    },
  },
  actions: {
    [MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE]({ state }, payload) {
      for (let index = 0; index < state.listSteps.length; index++) {
        if (index < Number(payload)) {
          state.listSteps[index].active = true;
        } else {
          state.listSteps[index].active = false;
        }
      }
    },
    [MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT]({ state }, payload) {
      state.listMenuEdit.forEach((item) => (item.isActive = false));
      state.listMenuEdit.find((item) => item.type === payload).isActive = true;
    },
  },
};
export default rentalSpaces;
