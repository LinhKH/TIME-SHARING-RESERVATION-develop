import { Filename } from './Filename';

export type SelectedFile = {
  name: Filename;
  blob: File;
};

export function fromFileList(files: FileList | null): SelectedFile[] {
  if (files) {
    const ret: SelectedFile[] = [];

    for (let i = 0, imax = files.length; i < imax; i++) {
      let file;
      if ((file = files.item(i))) {
        ret.push({
          name: file.name,
          blob: file,
        });
      }
    }

    return ret;
  } else return [];
}
