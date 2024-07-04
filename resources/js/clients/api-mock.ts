import { ApiResponse } from './api';

export function createMockResponse<TCode extends number, TData>(
  status: TCode,
  data: TData
): ApiResponse<TCode, TData> {
  return {
    status,
    statusText: 'It is mock response.',
    config: {},
    headers: {},
    data,
  };
}
