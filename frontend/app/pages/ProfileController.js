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
      router.navigate(
        `/post/${post_uuid}`,
        this.posts.find((p) => p.user_post_uuid == post_uuid)
      );
    };

    const event = Event.listen("post", () => this.getFeed());

    this.onDestroy = function () {
      Event.unlisten(event);
    };

    this.getFeed();
  },
  render: function () {
    return /* HTML */ `
      ${!this.posts.length
        ? /* HTML */ `<div class="content-center" style="margin-top: 22rem">
            <i class="fa fa-sad-tear"></i>
            <span>No hay posts</span>
          </div>`
        : /* HTML */ `
            <div class="posts-grid" style="padding-top: 2rem; margin-top: 22rem">
              ${this.posts
                .map(
                  (post, index) => /* HTML */ `
                    <div fadeIn ${post?.user_post_uuid ? `onclick="openPost('${post?.user_post_uuid}')"` : ``} id="${post?.user_post_uuid || `post_${index}`}" class="post">
                      <img lazy src="${post?.image || ""}" class="post-image" />
                    </div>
                  `
                )
                .join("")}
            </div>
          `}

      <div class="user-header">
        <div class="image"><i class="fa fa-user"></i></div>
        <span>Mi perfil</span>
      </div>
    `;
  },
};
