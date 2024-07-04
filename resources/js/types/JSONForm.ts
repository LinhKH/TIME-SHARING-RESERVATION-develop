import { JSFormula } from './JSFormula';
import { Master } from './JSONApiResponse';
import { UploadedFiles } from './UploadedFile';

export type JSONFormMetaData = {
  secureId: string;
  master: Master;
  files: UploadedFiles;
};

export type JSONFormDefinition = {
  sections: (JSONFormSection | JSONFormSectionGroup)[];
};
export type JSONFormSectionGroup = JSONFormDefinition & {
  type: 'section-group';
  title?: string;
};
export type JSONFormMultiple = JSONFormDefinition & {
  type: 'multiple';
  key: string;
  title?: string;
  labelFormula?: JSFormula;
};
export type JSONFormSection = {
  type: 'section';
  title?: string;
  items: (JSONFormField | JSONFormMultiple)[];
};
export type JSONFormFieldBase = {
  type: 'form';
  key: string;
  title?: string;
  description?: string;
  required?: boolean;
};
export type JSONFormField =
  | JSONFormTextField
  | JSONFormTextareaField
  | JSONFormRadioField
  | JSONFormCheckboxField
  | JSONFormBooleanField
  | JSONFormSelectField
  | JSONFormFileField
  | JSONFormNumberField
  | JSONFormDateField
  | JSONFormTimeField
  | JSONFormRangeField
  | JSONFormLabelField;
export type JSONFormItemWidth = 'half' | 'wide' | 'full' | undefined;
export type JSONFormTextField = JSONFormFieldBase & {
  view_type: 'text';
  unit?: string;
  placeholder?: string;
  width?: JSONFormItemWidth;
};
export type JSONFormTextareaField = JSONFormFieldBase & {
  view_type: 'textarea';
  rows?: number;
};
export type JSONFormRadioField = JSONFormFieldBase & {
  view_type: 'radio';
  code_type: string;
};
export type JSONFormCheckboxField = JSONFormFieldBase & {
  view_type: 'checkbox';
  code_type: string;
};
export type JSONFormBooleanField = JSONFormFieldBase & {
  view_type: 'boolean';
  label: string;
  emphasize?: boolean;
  width?: JSONFormItemWidth;
};
export type JSONFormSelectField = JSONFormFieldBase & {
  view_type: 'select';
  code_type: string;
  width?: JSONFormItemWidth;
};
export type JSONFormFileField = JSONFormFieldBase & {
  view_type: 'file';
  accepts?: string;
  width?: JSONFormItemWidth;
};
export type JSONFormNumberField = JSONFormFieldBase & {
  view_type: 'number';
  unit?: string;
  placeholder?: string;
  width?: JSONFormItemWidth;
};
export type JSONFormDateField = JSONFormFieldBase & {
  view_type: 'date';
  placeholder?: string;
  width?: JSONFormItemWidth;
};
export type JSONFormTimeField = JSONFormFieldBase & {
  view_type: 'time';
  placeholder?: string;
  ignoreTimezone?: boolean;
};
export type JSONFormRangeField = JSONFormFieldBase & {
  view_type: 'range';
  from: JSONFormField;
  to: JSONFormField;
};
export type JSONFormLabelField = JSONFormFieldBase & {
  view_type: 'label';
  shaded?: boolean;
  label: string;
};
