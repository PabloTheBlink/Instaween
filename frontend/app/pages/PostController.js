import { router } from "../config/router.js";
import { getPost } from "../services/PostService.js";

export const PostController = {
  controller: function () {
    this.getPost = function () {
      getPost(router.params.post_uuid).then((post) => {
        this.post = post;
        this.apply();
      });
    };

    this.getPost();
  },
  render: function () {
    return /* HTML */ `
      <div class="posts">
        <div id="${this.post?.user_post_uuid || `post_0`}" class="post">
          <img lazy src="${this.post?.image || ""}" class="post-image" />
        </div>
      </div>
    `;
  },
};
