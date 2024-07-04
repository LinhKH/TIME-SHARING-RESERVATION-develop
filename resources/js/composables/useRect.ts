import { onMounted, onUnmounted, ref } from 'vue';
import debounce from 'just-debounce-it';
import { ElementRef } from '@/types/ElementRef';

export default function (
  elementRef: ElementRef,
  { includeOffset = true } = {}
) {
  const rect = ref<DOMRect>();

  const updateRect = debounce(() => {
    const el = elementRef.value;
    if (el instanceof Element) {
      const calculated = el.getBoundingClientRect();
      const offsetX = includeOffset ? window.pageXOffset : 0;
      const offsetY = includeOffset ? window.pageYOffset : 0;

      rect.value = {
        ...calculated.toJSON(),
        top: calculated.top + offsetY,
        bottom: calculated.bottom + offsetY,
        left: calculated.left + offsetX,
        right: calculated.right + offsetX,
        x: calculated.x + offsetX,
        y: calculated.y + offsetY,
      };
    }
  }, 25);

  onMounted(() => {
    window.addEventListener('resize', updateRect);

    updateRect();
  });

  onUnmounted(() => {
    window.removeEventListener('resize', updateRect);
  });

  return rect;
}
