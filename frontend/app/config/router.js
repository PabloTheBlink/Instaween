import { Router } from "../../assets/js/ScopeJS.min.js";
import { ExploreController } from "../pages/ExploreController.js";
import { HomeController } from "../pages/HomeController.js";
import { ProfileController } from "../pages/ProfileController.js";
import { SlideController } from "../pages/SlideController.js";

export const router = Router(
  [
    {
      path: "/",
      controller: HomeController,
      alias: "home",
    },
    {
      path: "/slide",
      controller: SlideController,
      alias: "slide",
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
    useHash: false,
  }
);
