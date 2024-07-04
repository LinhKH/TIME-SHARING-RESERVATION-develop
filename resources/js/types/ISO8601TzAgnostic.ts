import moment from 'moment';

export type ISO8601TzAgnostic = string;

export function fromDate(date: Date): ISO8601TzAgnostic {
  return moment(date).format('YYYY-MM-DDTHH:mm:ss');
}

export function toDate(iso8601: ISO8601TzAgnostic): Date {
  const x = moment.parseZone(iso8601);

  return moment(x.format('YYYY-MM-DDTHH:mm:ss')).toDate();
}
