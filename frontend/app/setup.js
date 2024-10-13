import { Component } from "../assets/js/ScopeJS.min.js";
import { components } from "./config/components.js";
import { loadCSS } from "./utils/loadCSS.js";
import { loadJS } from "./utils/loadJS.js";
import { AppController } from "./pages/AppController.js";

for (let component of components) Component(component);

const $spinner = document.querySelector("#loading-overlay");

export function setLoading(bool) {
  $spinner.style.display = bool ? "flex" : "none";
}

loadCSS("./assets/css/style.css", () => {
  Component(AppController).render(document.querySelector("#app"));
});

loadJS("./assets/js/three.min.js", () => {
  loadJS("./assets/js/vanta.fog.min.js", () => {
    VANTA.FOG({
      el: "body",
      mouseControls: true,
      touchControls: true,
      gyroControls: false,
      minHeight: 200.0,
      minWidth: 200.0,
      highlightColor: 0x0,
      midtoneColor: 0x0,
      lowlightColor: 0x0,
      baseColor: 0x2f2f2f,
      blurFactor: 0.37,
      speed: 0.6,
      zoom: 1.6,
      minHeight: window.innerHeight,
      minWidth: window.innerWidth,
    });
    window.addEventListener("resize", () => {
      VANTA.current.resize();
    });
  });
});
