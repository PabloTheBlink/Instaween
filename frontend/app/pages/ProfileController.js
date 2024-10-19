import { Event } from "../../assets/js/EventJS.min.js";
import { router } from "../config/router.js";
import { getMyPosts } from "../services/PostService.js";
import { current_user } from "./AppController.js";

export const ProfileController = {
  controller: function () {
    this.current_user = current_user.get();
    this.posts = [null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null];

    this.getFeed = function () {
      getMyPosts().then((posts) => {
        this.posts = posts;
        this.apply();
      });
    };

    this.openPost = function (post_uuid) {
      router.navigate(`/post/${post_uuid}`);
    };

    const event = Event.listen("post", () => this.getFeed());

    this.onDestroy = function () {
      Event.unlisten(event);
    };

    this.getFeed();
  },
  render: function () {
    return /* HTML */ `
      <style>
        .user-header {
          margin-top: 6rem;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          gap: 1rem;
          background-color: rgba(255, 255, 255, 0.5);
          border-radius: 1rem;
          padding: 3rem 0;

          .image {
            width: 7rem;
            height: 7rem;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;

            i {
              font-size: 3rem;
            }
          }

          span {
            font-size: 1.5rem;
            font-weight: bold;
          }
        }
      </style>

      <div class="user-header">
        <div class="image"><i class="fa fa-user"></i></div>
        <span>Mi perfil</span>
      </div>

      ${!this.posts.length
        ? /* HTML */ `<div class="content-center">
            <i class="fa fa-sad-tear"></i>
            <span>No hay posts</span>
          </div>`
        : /* HTML */ `
            <div class="posts-grid" style="padding-top: 2rem">
              ${this.posts
                .map(
                  (post, index) => /* HTML */ `
                    <div ${post?.user_post_uuid ? `onclick="openPost('${post?.user_post_uuid}')"` : ``} id="${post?.user_post_uuid || `post_${index}`}" class="post">
                      <img lazy src="${post?.image || ""}" class="post-image" />
                    </div>
                  `
                )
                .join("")}
            </div>
          `}
    `;
  },
};
