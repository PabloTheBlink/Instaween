export function onChangeEnd(callback, timeout = 2000) {
  if (window.onChangeEnd) clearTimeout(window.onChangeEnd);
  window.onChangeEnd = setTimeout(callback, timeout);
}
