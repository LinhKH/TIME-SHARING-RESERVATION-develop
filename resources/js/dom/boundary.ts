export type Boundary = {
  bottom: number;
  top: number;
  right: number;
  left: number;
};

export default function (el: Element): Boundary {
  const rect = el.getBoundingClientRect();

  return {
    bottom: Math.max(rect.top, rect.bottom),
    top: Math.min(rect.top, rect.bottom),
    right: Math.max(rect.left, rect.right),
    left: Math.min(rect.left, rect.right),
  };
}

export function isBottomOutOfDocument(
  boundary: Boundary,
  documentBottomBoundary = document.documentElement.clientHeight
) {
  return boundary.bottom > documentBottomBoundary;
}

export function isTopOutOfDocument(
  boundary: Boundary,
  documentTopBoundary = 64
) {
  return boundary.top < documentTopBoundary;
}

export function isRightOutOfDocument(
  boundary: Boundary,
  documentRightBoundary = document.documentElement.clientWidth
) {
  return boundary.right > documentRightBoundary;
}

export function isLeftOutOfDocument(
  boundary: Boundary,
  documentLeftBoundary = 0
) {
  return boundary.left < documentLeftBoundary;
}
