import { Ref, ComputedRef } from 'vue';

export type RefOrComputed<T> = Ref<T> | ComputedRef<T>;
