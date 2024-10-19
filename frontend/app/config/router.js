import { Router } from "../../assets/js/ScopeJS.min.js";
import { ExploreController } from "../pages/ExploreController.js";
import { HomeController } from "../pages/HomeController.js";
import { PostController } from "../pages/PostController.js";
import { ProfileController } from "../pages/ProfileController.js";

export const router = Router(
  [
    {
      path: "/",
      controller: HomeController,
      alias: "home",
    },
    {
      path: "/post/:post_uuid",
      controller: PostController,
      alias: "post",
    },
    {
      path: "/explore",
      controller: ExploreController,
      alias: "explore",
    },
    {
      path: "/profile/:user_uuid",
      controller: ProfileController,
      alias: "profile",
    },
  ],
  {
    useHash: true,
  }
);
