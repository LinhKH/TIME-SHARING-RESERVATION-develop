import { computed, nextTick, ref } from 'vue';

import Boundary, {
  isBottomOutOfDocument,
  isLeftOutOfDocument,
  isRightOutOfDocument,
  isTopOutOfDocument,
} from '@/dom/boundary';

type PopoverPosition = {
  vertical: 'bottom' | 'top';
  horizontal: 'left' | 'right';
};

export default function () {
  const popover = ref<Element>();
  const popoverPosition = ref<PopoverPosition>({
    vertical: 'bottom',
    horizontal: 'left',
  });

  return {
    popover,
    popoverPosition: computed(
      () =>
        `${popoverPosition.value.vertical}-${popoverPosition.value.horizontal}`
    ),
    onPopoverMounted() {
      function maybeBoundary() {
        if (popover.value && popover.value instanceof Element) {
          return Boundary(popover.value);
        }
      }

      const boundary = maybeBoundary();

      if (boundary && isBottomOutOfDocument(boundary)) {
        popoverPosition.value.vertical = 'top';
        nextTick(() => {
          const boundary = maybeBoundary();
          if (boundary && isTopOutOfDocument(boundary)) {
            popoverPosition.value.vertical = 'bottom';
          }
        });
      }

      if (boundary && isRightOutOfDocument(boundary)) {
        popoverPosition.value.horizontal = 'right';
        nextTick(() => {
          const boundary = maybeBoundary();

          if (boundary && isLeftOutOfDocument(boundary)) {
            popoverPosition.value.horizontal = 'left';
          }
        });
      }
    },
    onPopoverUnmounted() {
      // レンダリング後のＤＯＭ要素から最適な位置を計算するため、見えなくなる時に初期値を設定しておく。
      popoverPosition.value = {
        vertical: 'bottom',
        horizontal: 'left',
      };
    },
  };
}
