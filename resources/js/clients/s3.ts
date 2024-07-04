import api from '@/clients/api';
import FileType from 'file-type/browser';
import mime from 'mime-types';

export async function uploadFileToS3(presignedURL: string, fileData: File) {
  const mimeType =
    fileData.type ||
    (await detectFileType(fileData)) ||
    mime.lookup(fileData.name);

  if (!mimeType) {
    throw new Error('The file type was not detected.');
  } else {
    return await api.put(presignedURL, fileData, {
      headers: {
        'Content-Type': mimeType,
      },
    });
  }
}

async function detectFileType(data: File) {
  const fileType = await FileType.fromBlob(data);

  return fileType ? fileType.mime : '';
}
