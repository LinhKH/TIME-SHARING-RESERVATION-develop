export type ErrorCode =
  | typeof REQUIRED
  | typeof FILE_UPLOAD_FAILED
  | typeof FILE_SIZE_EXCEEDED;

export const REQUIRED = '100';
export const FILE_UPLOAD_FAILED = '101';
export const FILE_SIZE_EXCEEDED = '102';
