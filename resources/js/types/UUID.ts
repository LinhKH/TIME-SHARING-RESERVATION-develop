import { v4 as uuidv4 } from 'uuid';
import isUUIDLib from 'validator/es/lib/isUUID';

export type UUID = string;
export function isUUID(str: string): str is UUID {
  return isUUIDLib(str);
}

export function UUIDV4() {
  return uuidv4();
}
