import moment from 'moment-timezone';
import isISO8601Lib from 'validator/es/lib/isISO8601';

export type ISO8601 = string;
export function isISO8601(str: string): str is ISO8601 {
  return isISO8601Lib(str, { strict: true });
}

const serverTimeZone = 'Asia/Tokyo';

export function fromDate(date: Date): ISO8601 {
  return moment(date).tz(serverTimeZone).toISOString(true);
}

export function toDate(iso8601: ISO8601): Date {
  return moment(iso8601).toDate();
}
