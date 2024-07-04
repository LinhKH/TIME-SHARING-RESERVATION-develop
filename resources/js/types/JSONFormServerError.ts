import { ErrorCode } from './ErrorCode';
import { JSONApiResponseErrorBody } from './JSONApiResponse';

export type JSONFormServerError = {
  code: string;
  path: string;
};

export function fromJSONApiResponseErrorBody(
  errorBody: JSONApiResponseErrorBody<ErrorCode>
): JSONFormServerError[] {
  return errorBody.errors.flatMap((x) =>
    x.source?.pointer
      ? [
          {
            code: x.code,
            path: x.source?.pointer,
          },
        ]
      : []
  );
}

export function serverErrorsUnder(
  path: string,
  errors: JSONFormServerError[]
): JSONFormServerError[] {
  return errors.filter((x) => x.path.startsWith(path));
}

export function serverErrorsFor(
  path: string,
  errors: JSONFormServerError[]
): JSONFormServerError[] {
  return errors.filter((x) => x.path === path);
}
