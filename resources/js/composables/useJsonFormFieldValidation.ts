import { computed, ref, watch } from 'vue';

import { JSONFormField, JSONFormMetaData } from '@/types/JSONForm';
import { JSONFormValue, validateJsonFormValue } from '@/types/JSONFormContents';
import { JSONFormFieldError } from '@/types/JSONFormError';
import { RefOrComputed } from '@/types/RefOrComputed';
import { JSONFormServerError } from '@/types/JSONFormServerError';

export default function (
    definition: RefOrComputed<JSONFormField>,
    value: RefOrComputed<JSONFormValue>,
    meta: RefOrComputed<JSONFormMetaData>,
    serverErrors: RefOrComputed<JSONFormServerError[]>,
    defaultErrors?: RefOrComputed<JSONFormFieldError[]>
) {
    const changed = ref(false);

    const errors = ref([...(defaultErrors ? defaultErrors.value : [])]);
    watch(value, (value) => {
        changed.value = true;
        errors.value = validateJsonFormValue(definition.value, value, meta.value);
    });

    return {
        errors,
        setError(error: JSONFormFieldError) {
            changed.value = true;
            errors.value = [error];
        },
        showError: computed(
            () =>
                (errors.value.length !== 0 && changed.value) ||
                serverErrors.value.length !== 0
        ),
    };
}
