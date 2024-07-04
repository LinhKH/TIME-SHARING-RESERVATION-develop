<template>
  <div class="p-[5px]">
    <div v-for="(guideItem, index) in listGuide" :key="index" class="font-serif">
      <h4 class="text-[16px] my-[10px] p-[10px] text-[#333] bg-[#efefef]">{{ guideItem.title }}</h4>
      <div class="px-[10px] mb-[20px]">
        <p class="" v-for="(item, index) in guideItem.child" :key="index">
          <span v-if="guideItem.isIndex">{{ index }}. </span>{{ item }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "TourGuide",
  setup() {
    const listGuide = [
      {
        id: 1,
        title: "できること",
        isIndex: false,
        child: ["見学リクエスト機能をご活用頂くことで、", "お客様との見学日時の決定を速やかに行うことが可能です。"],
      },
      {
        id: 2,
        title: "見学までの流れ",
        isIndex: true,
        child: [
          "お客様より見学リクエストを受け付ける。",
          "見学リクエストを「承認」する。",
          "お客様が見学リクエストを「確定」する。",
          "確定となった見学日時にてお客様に対応する。",
        ],
      },
      {
        id: 3,
        title: "回答方法",
        isIndex: false,
        child: ["見学リクエストへの回答方法は、以下の通りです。"],
      },
      {
        id: 4,
        title: "【見学可能な場合】",
        isIndex: false,
        child: [
          "管理画面内「見学リクエスト一覧」をクリック",
          "見学が可能な日時を選択し、「次へ」ボタンをクリック",
          "お客様に回答する内容を確認し、「承認」ボタンをクリック",
        ],
      },
      {
        id: 5,
        title: "【見学不可な場合】",
        isIndex: false,
        child: [
          "管理画面内「見学リクエスト一覧」をクリック",
          "「見学不可」ボタンをクリック",
          "お客様に回答する内容を確認し、「確定」ボタンをクリック",
        ],
      },
      {
        id: 6,
        title: "注意事項",
        isIndex: false,
        child: [
          "見学リクエストへの回答方法は、以下の通りです。",
          "見学リクエストを承認後、お客様より「確定」頂いた場合のみ見学リクエストが確定します。",
          "見学リクエストのキャンセルは、リクエストの承認後も可能です。",
          "お客様より確定頂いた場合、メールにて見学リクエストが確定となった旨をメールにてご案内します。",
          "見学リクエストのお受付をご希望でない場合、「見学リクエスト」の設定ページにてチェックを外して下さい。",
          "（見学不可となります）",
          "リクエストを頂いた後、3日以内に回答頂けない場合は、自動キャンセルとなります。",
        ],
      },
    ];
    return { listGuide };
  },
};
</script>

<style></style>
