export type JSFormula = string;

export function evalFormula(formula: JSFormula) {
  return Function(`"use strict"; return ${formula}`)();
}
