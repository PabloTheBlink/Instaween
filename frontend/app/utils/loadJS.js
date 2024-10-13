export function loadJS(url, callback) {
  if (!url) return;

  const script = document.createElement("script");
  script.src = url;
  script.async = true;

  script.onload = function () {
    if (typeof callback === "function") {
      callback(null);
    }
  };

  document.head.appendChild(script);
}
