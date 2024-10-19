import { Event } from "../../assets/js/EventJS.min.js";
import { router } from "../config/router.js";
import { getFeed } from "../services/PostService.js";

export const ExploreController = {
  controller: function () {
    this.posts = [null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null];

    this.getFeed = function () {
      getFeed(100).then((posts) => {
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
        ? /* HTML */ `<div class="content-center">
            <i class="fa fa-sad-tear"></i>
            <span>No hay posts</span>
          </div>`
        : /* HTML */ `
            <div class="posts-grid">
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
    `;
  },
};
