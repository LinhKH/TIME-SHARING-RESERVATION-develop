// https://jsonapi.org/format/#document-meta

export type Master = Record<string, MasterItem[]>;

export type MasterItem = {
  code: string | number;
  name: string;
};

export type JSONApiResponseMetaBase = {
  master: Master;
};

export type JSONApiResponseBody<TData, TMeta = JSONApiResponseMetaBase> = {
  meta: TMeta;
  data: TData;
};

export type JSONApiResponseErrorBody<TCode extends string = string> = {
  errors: {
    code: TCode;
    source?: {
      pointer?: string;
    };
    title?: string;
    detail?: string;
  }[];
};
