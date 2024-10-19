import { router } from "../config/router.js";
import { getPost } from "../services/PostService.js";

export const PostController = {
  controller: function () {
    this.post = router.body;
    this.getPost = function () {
      getPost(router.params.post_uuid).then((post) => {
        this.post = post;
        this.apply();
      });
    };

    if (!this.post) this.getPost();
  },
  render: function () {
    return /* HTML */ `
      <div class="posts content-center">
        <div fadeIn id="${this.post?.user_post_uuid || `post_0`}" class="post">
          <img style="aspect-ratio: 3/4" lazy src="${this.post?.image || ""}" class="post-image" />
        </div>
      </div>
    `;
  },
};
