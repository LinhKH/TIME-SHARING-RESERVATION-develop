import { REQUIRED } from './ErrorCode';
import { isISO8601, ISO8601 } from './ISO8601';
import { ISO8601TzAgnostic } from './ISO8601TzAgnostic';
import {
  JSONFormDefinition,
  JSONFormField,
  JSONFormMetaData,
  JSONFormMultiple,
  JSONFormSectionGroup,
} from './JSONForm';
import { createJSONFormFieldError } from './JSONFormError';
import { isUUID, UUID, UUIDV4 } from './UUID';

export const CONTENT_KEY = Symbol();

export type JSONFormContents = Record<
  string | symbol,
  JSONFormValue | JSONFormContents[] | UUID
>;
export type JSONFormRange = { from: JSONFormValue; to: JSONFormValue };
export type JSONFormValue =
  | JSONFormTextValue
  | JSONFormSelectValue
  | JSONFormMultiSelectValue
  | JSONFormBooleanValue
  | JSONFormFileValue
  | JSONFormNumberValue
  | JSONFormDateValue
  | JSONFormRange;
export type JSONFormTextValue = string;
export type JSONFormSelectValue = number | string | null;
export type JSONFormMultiSelectValue = (number | string)[];
export type JSONFormBooleanValue = boolean;
export type JSONFormFileValue = UUID | null;
export type JSONFormNumberValue = number | null;
export type JSONFormDateValue = ISO8601 | ISO8601TzAgnostic | null;

export function isJSONFormBooleanValue(
  value: unknown
): value is JSONFormBooleanValue {
  return typeof value === 'boolean';
}
export function isJSONFormTextValue(
  value: unknown
): value is JSONFormTextValue {
  return typeof value === 'string';
}
export function isJSONFormNumberValue(
  value: unknown
): value is JSONFormNumberValue {
  return typeof value === 'number';
}
export function isJSONFormSelectValue(
  value: unknown
): value is JSONFormSelectValue {
  return ['number', 'string'].includes(typeof value);
}
export function isJSONFormMultiSelectValue(
  value: unknown
): value is JSONFormMultiSelectValue {
  return Array.isArray(value) && value.every(isJSONFormSelectValue);
}
export function isJSONFormDateValue(
  value: unknown
): value is JSONFormDateValue {
  return typeof value === 'string' && isISO8601(value as string);
}
export function isJSONFormFileValue(
  value: unknown
): value is JSONFormFileValue {
  return typeof value === 'string' && isUUID(value as string);
}
export function isJSONFormRange(value: unknown): value is JSONFormRange {
  return value && typeof value === 'object' && value['from'] && value['to'];
}

export function normalizeContents<
  T extends JSONFormDefinition | JSONFormSectionGroup | JSONFormMultiple
>(definition: T, notNormal: unknown): JSONFormContents {
  function normalizeFormValue(
    item: JSONFormField,
    value: unknown
  ): JSONFormValue | JSONFormRange | undefined {
    switch (item.view_type) {
      case 'boolean':
        return isJSONFormBooleanValue(value) ? value : false;
      case 'text':
      case 'textarea':
        return isJSONFormTextValue(value) ? value : '';
      case 'number':
        return isJSONFormNumberValue(value) ? value : null;
      case 'select':
      case 'radio':
        return isJSONFormSelectValue(value) ? value : null;
      case 'checkbox':
        return isJSONFormMultiSelectValue(value) ? value : [];
      case 'date':
      case 'time':
        return isJSONFormDateValue(value) ? value : null;
      case 'file':
        return isJSONFormFileValue(value) ? value : null;
      case 'range':
        return isJSONFormRange(value)
          ? ({
              from: normalizeFormValue(item.from, value.from),
              to: normalizeFormValue(item.to, value.to),
            } as JSONFormRange)
          : ({
              from: normalizeFormValue(item.from, undefined),
              to: normalizeFormValue(item.to, undefined),
            } as JSONFormRange);
      case 'label':
        return undefined;
      default: {
        const check: never = item;
        return check;
      }
    }
  }

  const contents = typeof notNormal !== 'object' ? {} : notNormal || {};

  const ret = definition.sections.reduce(
    (obj, section) => ({
      ...obj,
      ...(section.type === 'section'
        ? section.items.reduce((obj, item) => {
            switch (item.type) {
              case 'form':
                {
                  const value = normalizeFormValue(item, contents[item.key]);

                  if (value !== undefined) {
                    obj[item.key] = value;
                  }
                }
                break;
              case 'multiple':
                {
                  const multipleContents = contents[item.key];
                  obj[item.key] = Array.isArray(multipleContents)
                    ? (multipleContents as JSONFormContents[]).map((contents) =>
                        normalizeContents(item, contents)
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
        ? normalizeContents(section, contents)
        : {}),
    }),
    {}
  );

  ret[CONTENT_KEY] = UUIDV4();

  return ret;
}

export function validateJsonFormValue(
  definition: JSONFormField,
  value: JSONFormValue,
  // eslint-disable-next-line @typescript-eslint/no-unused-vars
  _?: JSONFormMetaData
) {
  if (definition.required && isEmpty(definition, value)) {
    return [createJSONFormFieldError(REQUIRED)];
  } else {
    return [];
  }
}

export function isEmpty(definition: JSONFormField, value: JSONFormValue) {
  switch (definition.view_type) {
    case 'boolean':
      return (value as JSONFormBooleanValue) === false;
    case 'text':
    case 'textarea':
      return (value as JSONFormTextValue) === '';
    case 'number':
      return (value as JSONFormNumberValue) === null;
    case 'checkbox':
      return (value as JSONFormMultiSelectValue).length === 0;
    case 'select':
    case 'radio':
      return (value as JSONFormSelectValue) === null;
    case 'date':
    case 'time':
      return (value as JSONFormDateValue) === null;
    case 'file':
      return (value as JSONFormFileValue) === null;
    case 'range': {
      const range = value as JSONFormRange;

      return (
        isEmpty(definition.from, range.from) || isEmpty(definition.to, range.to)
      );
    }
    case 'label':
      return false;
    default: {
      const check: never = definition;
      return check;
    }
  }
}
