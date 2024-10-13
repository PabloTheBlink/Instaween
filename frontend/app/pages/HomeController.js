import { Event } from "../../assets/js/EventJS.min.js";
import { generateCloudinaryUrl } from "../services/CloudinaryService.js";
import { getFeed } from "../services/PostService.js";

export const HomeController = {
  controller: function () {
    this.posts = [null, null, null, null];

    this.getFeed = function () {
      getFeed().then((posts) => {
        this.posts = posts;
        this.apply();
      });
    };

    Event.listen("post", () => this.getFeed());
    this.getFeed();
  },
  render: function () {
    return /* HTML */ `
      <style>
        .posts {
          width: 100%;
          display: flex;
          flex-direction: column;
          gap: 2.5rem;
          padding: 6rem 0;

          .post {
            width: 100%;
            background-color: var(--post-bg-color);
            border-radius: 1rem;
            overflow: hidden;
            opacity: 0.75;

            &:hover {
              opacity: 1;

              img {
                transform: scale(1.025);
              }
            }

            .post-image {
              overflow: hidden;
              min-height: 20rem;

              &.lazy {
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, rgba(255, 255, 255, 0.25) 25%, rgba(255, 255, 255, 0.5) 50%, rgba(255, 255, 255, 0.25) 75%);
                background-size: 400% 400%;
                animation: skeleton 1s ease infinite;
              }

              img {
                width: 100%;
                aspect-ratio: 1/1;
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
        }
      </style>
      <header-component></header-component>
      ${!this.posts.length
        ? /* HTML */ `<div class="content-center">">No hay posts</div>`
        : /* HTML */ `
            <div class="posts">
              ${this.posts
                .map(
                  (post) => /* HTML */ `
                    <div class="post">
                      <div class="post-image ${!post?.image ? "lazy" : ""}">${post?.image ? /* HTML */ `<img src="${post.image}" alt="Post" />` : /* HTML */ ``}</div>
                      <div class="post-footer">
                        ${post
                          ? /* HTML */ `
                              <button>Like</button>
                              <button>Comment</button>
                              <button>Share</button>
                            `
                          : ``}
                      </div>
                    </div>
                  `
                )
                .join("")}
            </div>
          `}
    `;
  },
};
