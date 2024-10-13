import { Event } from "../../assets/js/EventJS.min.js";
import { getSlide, nextSlide } from "../services/PostService.js";

export const SlideController = {
  controller: function () {
    this.post = undefined;

    this.getSlide = function () {
      getSlide().then((post) => {
        this.post = post;
        this.apply();
      });
    };

    this.next = function (opt) {
      const user_post_uuid = this.post.user_post_uuid;
      this.post = null;
      this.apply();
      nextSlide(user_post_uuid, opt).then((post) => {
        this.post = post;
        this.apply();
      });
    };

    Event.listen("post", () => this.getSlide());

    this.getSlide();
  },
  render: function () {
    return /* HTML */ `
      <style>
        .post {
          width: 100%;
          background-color: var(--post-bg-color);
          border-radius: 1rem;
          overflow: hidden;
          margin-top: 6rem;

          &:hover {
            opacity: 1;

            img {
              transform: scale(1.025);
            }
          }

          .post-image {
            overflow: hidden;
            width: 100%;
            height: 25rem;

            &.lazy {
              background: linear-gradient(90deg, rgba(255, 255, 255, 0.25) 25%, rgba(255, 255, 255, 0.5) 50%, rgba(255, 255, 255, 0.25) 75%);
              background-size: 400% 400%;
              animation: skeleton 1s ease infinite;
            }

            img {
              width: 100%;
              height: 100%;
              aspect-ratio: 9/16;
              object-fit: cover;
              transition: 1s;
              z-index: 1;
            }
          }

          .post-footer {
            display: flex;
            justify-content: space-around;
            height: 3rem;
            padding: 0 1rem;
            background-color: var(--post-bg-color);

            button {
              background: none;
              border: none;
              font-size: 1.1rem;
              color: var(--button-color);
              cursor: pointer;
            }
          }
        }
      </style>
      <header-component></header-component>
      ${this.post === null
        ? /* HTML */ ` <div class="content-center">No hay más posts que valorar</div>`
        : /* HTML */ `
            <div class="post">
              <div class="post-image ${!this.post?.image ? "lazy" : ""}">${this.post?.image ? /* HTML */ `<img src="${this.post.image}" alt="Post" />` : /* HTML */ ``}</div>
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
          `}
    `;
  },
};
