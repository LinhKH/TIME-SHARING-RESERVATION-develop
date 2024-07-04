import {
  ErrorCode,
  FILE_SIZE_EXCEEDED,
  FILE_UPLOAD_FAILED,
  REQUIRED,
} from './ErrorCode';
import { JSONApiResponseErrorBody } from './JSONApiResponse';
import {
  JSONFormDefinition,
  JSONFormField,
  JSONFormMetaData,
} from './JSONForm';
import { applyPatch, Operation } from 'fast-json-patch';
import {
  JSONFormContents,
  JSONFormValue,
  validateJsonFormValue,
} from './JSONFormContents';
import { JSONFormServerError } from './JSONFormServerError';

export type JSONFormError = Record<
  string,
  JSONFormFieldError[] | JSONFormError[]
>;
export type JSONFormFieldError = {
  type: 'field-error';
  code: ErrorCode;
};

export function createJSONFormFieldError(code: ErrorCode): JSONFormFieldError {
  return {
    type: 'field-error',
    code,
  };
}
export function getJsonFormFieldErrorMessageId(
  field: JSONFormField,
  error: JSONFormFieldError | JSONFormServerError
): string {
  function id() {
    switch (error.code) {
      case REQUIRED:
        switch (field.view_type) {
          default:
            return 'required';
        }
      case FILE_UPLOAD_FAILED:
        switch (field.view_type) {
          default:
            return 'file-upload-failed';
        }
      case FILE_SIZE_EXCEEDED:
        switch (field.view_type) {
          default:
            return 'file-size-exceeded';
        }
    }
  }

  return `error-message.${id()}`;
}
export function isJSONFormFieldError(obj: unknown): obj is JSONFormFieldError {
  return (
    typeof obj === 'object' && (obj ? obj['type'] === 'field-error' : false)
  );
}
export function isJSONFormFieldErrors(
  obj: unknown
): obj is JSONFormFieldError[] {
  return Array.isArray(obj) ? obj.every(isJSONFormFieldError) : false;
}

export function hasError(error: JSONFormError) {
  return Object.keys(error).some((key) => {
    const items = error[key];

    if (items.length === 0) {
      return false;
    } else {
      const item = items[0];

      if (isJSONFormFieldError(item)) {
        return true;
      } else {
        return (items as JSONFormError[]).some(hasError);
      }
    }
  });
}
export function normalizeError(
  definition: JSONFormDefinition,
  contents: JSONFormContents,
  notNormal: unknown,
  meta: JSONFormMetaData,
  option: { autoValidate: boolean } = { autoValidate: false }
): JSONFormError {
  function normalizeFieldError(
    item: JSONFormField,
    value: JSONFormValue,
    error: unknown
  ): JSONFormFieldError[] {
    return isJSONFormFieldErrors(error)
      ? error
      : option.autoValidate
      ? validateJsonFormValue(item, value, meta)
      : [];
  }

  const error = typeof notNormal !== 'object' ? {} : notNormal || {};

  return definition.sections.reduce(
    (obj, section) => ({
      ...obj,
      ...(section.type === 'section'
        ? section.items.reduce((obj, item) => {
            switch (item.type) {
              case 'form':
                {
                  const value = normalizeFieldError(
                    item,
                    contents[item.key] as JSONFormValue,
                    error[item.key]
                  );

                  obj[item.key] = value;
                }
                break;
              case 'multiple':
                {
                  const multipleContents = contents[item.key];
                  const multipleErrors = error[item.key] || [];
                  obj[item.key] = Array.isArray(multipleContents)
                    ? (multipleContents as JSONFormContents[]).map(
                        (contents, i) =>
                          normalizeError(
                            item,
                            contents,
                            multipleErrors[i],
                            meta
                          )
                      )
                    : [];
                }
                break;
              default: {
                const check: never = item;
                return check;
              }
            }

            return obj;
          }, {})
        : section.type === 'section-group'
        ? normalizeError(section, contents, error, meta)
        : {}),
    }),
    {}
  );
}

export function fromJSONApiResponseErrorBody(
  errorBody: JSONApiResponseErrorBody<ErrorCode>,
  definition: JSONFormDefinition,
  contents: JSONFormContents,
  meta: JSONFormMetaData
): JSONFormError {
  const errorMap = errorBody.errors.reduce((errorMap, error) => {
    const pointer = error.source?.pointer;

    if (pointer) {
      const errors = [
        ...(errorMap.get(pointer) || []),
        createJSONFormFieldError(error.code),
      ];

      errorMap.set(pointer, errors);
      return errorMap;
    } else return errorMap;
  }, new Map<string, JSONFormFieldError[]>());

  const patch: Operation[] = Array.from(errorMap.keys()).map((pointer) => ({
    op: 'replace',
    path: pointer,
    value: errorMap.get(pointer),
  }));

  return applyPatch(normalizeError(definition, contents, {}, meta), patch)
    .newDocument;
}
