export function loadCSS(url, callback) {
  if (!url) return;

  const link = document.createElement("link");
  link.rel = "stylesheet";
  link.href = url;
  link.media = "only x";

  // Gestor de carga exitosa
  link.onload = function () {
    link.media = "all";
    if (typeof callback === "function") {
      callback(null);
    }
  };

  document.head.appendChild(link);
}
