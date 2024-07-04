export type Filename = string; //e.g. "filename.png"
export type Extname = string; //e.g. "png"

export function getExtname(filename: Filename): Extname {
  return filename.includes('.') ? filename.split('.').pop() || '' : '';
}
