import { UUID } from './UUID';

export type UploadedFile = {
  name: string;
};
export type UploadedFiles = Record<UUID, UploadedFile>;
