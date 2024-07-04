import { ref, watch } from 'vue';
import { ElementRef } from '../types/ElementRef';

import vClickOutside from 'v-click-outside';
const { bind, unbind } = vClickOutside.directive;

export default function (elementRef: ElementRef) {
  const event = ref<MouseEvent | null>(null);

  if (elementRef.value) {
    bind(elementRef.value, { value: (e) => (event.value = e) });
  }
  watch(elementRef, (el, oldEl) => {
    if (oldEl) unbind(el);
    if (el) bind(el, { value: (e) => (event.value = e) });
  });

  return event;
}
