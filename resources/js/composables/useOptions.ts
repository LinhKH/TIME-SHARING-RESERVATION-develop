import { ref, watch } from 'vue';

import { RefOrComputed } from '@/types/RefOrComputed';
import { DropdownOption } from '@/types/DropdownOption';

export default function (
  options: RefOrComputed<DropdownOption[]>,
  selected?: RefOrComputed<DropdownOption>
) {
  const selectedOption = ref(selected ? selected.value : null);

  if (selected) {
    watch(selected, (selected) => (selectedOption.value = selected));
  }

  const focusedOptionIndex = ref(
    options.value.findIndex((x) => x?.value === selected?.value?.value)
  );

  const optionsEl = ref<Element>();

  const autoScroll = (index: number) => {
    const selectedOptionEl = optionsEl.value?.querySelector(
      `.option-item:nth-child(n + ${index + 1})`
    );

    if (selectedOptionEl && optionsEl.value) {
      const selectedRect = selectedOptionEl.getBoundingClientRect();
      const optionsRect = optionsEl.value.getBoundingClientRect();

      if (selectedRect.bottom > optionsRect.bottom) {
        optionsEl.value.scrollTop += selectedRect.bottom - optionsRect.bottom;
      } else if (selectedRect.top < optionsRect.top) {
        optionsEl.value.scrollTop += selectedRect.top - optionsRect.top;
      }
    }
  };

  watch(focusedOptionIndex, autoScroll);

  return {
    optionsEl,
    onOptionsMounted() {
      focusedOptionIndex.value = options.value.findIndex(
        (x) => x?.value === selectedOption.value?.value
      );

      autoScroll(focusedOptionIndex.value);
    },
    selectedOption,
    selectOption(index: number) {
      focusedOptionIndex.value = index;
      selectedOption.value = options.value[index];
    },
    selectFocused() {
      const selected = options.value[focusedOptionIndex.value];
      if (selected !== undefined) {
        selectedOption.value = options.value[focusedOptionIndex.value];
      }
    },
    selectNextOption(e: KeyboardEvent) {
      e.preventDefault();
      const next =
        options.value.findIndex(
          (item) => item?.value === selectedOption.value?.value
        ) + 1;

      if (next < options.value.length) {
        focusedOptionIndex.value++;
        selectedOption.value = options.value[next];
      }
    },
    selectPreOption(e: KeyboardEvent) {
      e.preventDefault();
      const previous =
        options.value.findIndex(
          (item) => item?.value === selectedOption.value?.value
        ) - 1;

      if (previous >= 0) {
        focusedOptionIndex.value--;
        selectedOption.value = options.value[previous];
      }
    },
    focusedOptionIndex,
    focusNextOption(e) {
      e.preventDefault();
      if (focusedOptionIndex.value < options.value.length - 1) {
        focusedOptionIndex.value++;
      }
    },
    focusPreOption(e) {
      e.preventDefault();
      if (focusedOptionIndex.value > 0) {
        focusedOptionIndex.value--;
      }
    },
  };
}
