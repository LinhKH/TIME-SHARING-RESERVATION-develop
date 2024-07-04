import { onMounted, onUnmounted, ref, watch } from 'vue';
import { ElementRef, ElementWillMount } from '@/types/ElementRef';

export default (elementRef: ElementRef) => {
  const hovered = ref(false);

  function onMouseEnter() {
    hovered.value = true;
  }
  function onMouseLeave() {
    hovered.value = false;
  }

  function addEventListener(element: ElementWillMount) {
    if (element instanceof Element) {
      element.addEventListener('mouseenter', onMouseEnter);
      element.addEventListener('mouseleave', onMouseLeave);
    }
  }

  function removeEventListener(element: ElementWillMount) {
    if (element instanceof Element) {
      element.removeEventListener('mouseenter', onMouseEnter);
      element.removeEventListener('mouseleave', onMouseLeave);
    }
  }

  onMounted(() => addEventListener(elementRef.value));
  onUnmounted(() => removeEventListener(elementRef.value));
  watch(elementRef, (now, old) => {
    removeEventListener(old);
    addEventListener(now);
  });

  return hovered;
};
