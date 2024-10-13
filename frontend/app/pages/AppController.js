import { Event } from "../../assets/js/EventJS.min.js";
import { Modal } from "../../assets/js/ScopeJS.min.js";
import { State } from "../../assets/js/StateJS.min.js";
import { router } from "../config/router.js";
import { UploadImageModal } from "../modals/UploadImageModal.js";
import { getCurrentUser } from "../services/AuthService.js";

export const current_user = State(undefined);

export const AppController = {
  controller: function () {
    this.goTo = function (path) {
      router.navigate(path);
    };

    this.uploadImage = function () {
      Modal(
        UploadImageModal,
        {},
        {
          onClose: (e) => {
            if (!e.user_post_uuid) return;
            Event.emit("post", e);
          },
        }
      );
    };

    current_user.listen(() => this.apply());
    router.listen(() => this.apply());

    getCurrentUser().then(({ user, user_token }) => {
      localStorage.setItem("token", user_token.token);
      current_user.set(user);
      router.render(document.querySelector("#content"));
    });
  },
  render: function () {
    return /* HTML */ `
      <main class="main">
        <div class="container">
          <div class="sidebar sidebar-left">
            <div class="nav">
              <a class="center" onclick="uploadImage()">
                <i class="fa fa-plus"></i>
                <span>Subir</span>
              </a>
              <a onclick="goTo('/')" ${router.alias == "home" ? " class='active'" : ""}>
                <i class="fa fa-home"></i>
                <span>Inicio</span>
              </a>
              <a onclick="goTo('/slide')" ${router.alias == "slide" ? " class='active'" : ""}>
                <i class="fa fa-heart"></i>
                <span>Valora</span>
              </a>
              <a onclick="goTo('/explore')" ${router.alias == "explore" ? " class='active'" : ""}>
                <i class="fa fa-search"></i>
                <span>Explorar</span>
              </a>
              <a ${current_user.get() ? /* HTML */ `onclick="goTo('/profile/${current_user.get().user_uuid}')"` : ``} ${router.alias == "profile" ? " class='active'" : ""}>
                <i class="fa fa-user"></i>
                <span>Perfil</span>
              </a>
            </div>
          </div>
          <div class="content" id="content"></div>
          <div class="sidebar sidebar-right"></div>
        </div>
      </main>

      <img src="https://res.cloudinary.com/dsyxft79o/image/upload/instaween/rha2d7z66tzzcsblgqoo.webp" class="background" />

      <footer class="footer">
        <div class="container">
          <div class="nav">
            <a onclick="goTo('/')" ${router.alias == "home" ? " class='active'" : ""}>
              <i class="fa fa-home"></i>
            </a>
            <a onclick="goTo('/slide')" ${router.alias == "slide" ? " class='active'" : ""}>
              <i class="fa fa-heart"></i>
            </a>
            <a class="center" onclick="uploadImage()">
              <i class="fa fa-plus"></i>
            </a>
            <a onclick="goTo('/explore')" ${router.alias == "explore" ? " class='active'" : ""}>
              <i class="fa fa-search"></i>
            </a>
            <a ${current_user.get() ? /* HTML */ `onclick="goTo('/profile/${current_user.get().user_uuid}')"` : ``} ${router.alias == "profile" ? " class='active'" : ""}>
              <i class="fa fa-user"></i>
            </a>
          </div>
        </div>
      </footer>
    `;
  },
};
