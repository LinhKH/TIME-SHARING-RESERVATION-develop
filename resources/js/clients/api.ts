import axios, { AxiosResponse } from 'axios';

export default axios.create({
  baseURL: '/api',
  validateStatus(status) {
    return status < 500;
  },
});

export type ApiResponse<TCode extends number, TData> = AxiosResponse<TData> & {
  status: TCode;
};
