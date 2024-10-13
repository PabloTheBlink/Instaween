import { router } from "../config/router.js";

export const HeaderComponent = {
  tagName: "header-component",
  controller: function () {
    this.getTitle = function () {
      if (router.alias == "home") return "Inicio";
      if (router.alias == "slide") return "Valora";
      if (router.alias == "explore") return "Explorar";
      if (router.alias == "profile") return "Perfil";
      return "Instaween";
    };
    this.title = this.getTitle();

    router.listen(() => {
      this.title = this.getTitle();
      this.apply();
    });

    this.checkScroll = function () {
      document.querySelector("header").style.top = document.documentElement.scrollTop > 100 ? "-4rem" : "0";
    };

    setTimeout(() => {
      window.addEventListener("scroll", () => this.checkScroll());
      this.checkScroll();
    });
  },

  render: function () {
    return /* HTML */ `
      <header class="header">
        <h1>${this.title}</h1>
      </header>
    `;
  },
};
