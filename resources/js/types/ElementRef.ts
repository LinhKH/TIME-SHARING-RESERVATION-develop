import { RefOrComputed } from './RefOrComputed';

export type ElementWillMount = Element | null | undefined;

export type ElementRef = RefOrComputed<ElementWillMount>;

export type ElementRefs = ElementRef | ElementRef[];

export function toArray(elementRefs: ElementRefs): ElementRef[] {
  return Array.isArray(elementRefs) ? elementRefs : [elementRefs];
}
