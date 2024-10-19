import { Event } from "../../assets/js/EventJS.min.js";
import { getSlide, nextSlide } from "../services/PostService.js";

export const SlideController = {
  controller: function () {
    this.getSlide = function () {
      getSlide().then((post) => {
        this.post = post;
        this.apply();
      });
    };

    this.next = function (opt) {
      const user_post_uuid = this.post.user_post_uuid;
      this.post = undefined;
      this.apply();
      nextSlide(user_post_uuid, opt).then((post) => {
        this.post = post;
        this.apply();
      });
    };

    const event = Event.listen("post", () => this.getSlide());

    this.onDestroy = function () {
      Event.unlisten(event);
    };

    this.getSlide();
  },
  render: function () {
    return /* HTML */ `
      ${this.post === null
        ? /* HTML */ ` <div class="content-center">
            <i class="fa fa-sad-tear"></i>
            <span>No hay más posts que valorar</span>
          </div>`
        : /* HTML */ `
            <div class="posts">
              <div id="${this.post?.user_post_uuid || `post_0`}" class="post">
                <img lazy src="${this.post?.image || ""}" class="post-image" />
                <div class="post-footer">
                  ${this.post
                    ? /* HTML */ `
                        <button onclick="next(-1)">
                          <i class="fa fa-close"></i>
                        </button>
                        <button onclick="next(1)">
                          <i class="fa fa-heart"></i>
                        </button>
                      `
                    : ``}
                </div>
              </div>
            </div>
          `}
    `;
  },
};
