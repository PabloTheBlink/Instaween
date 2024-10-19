import { API_URL } from "../config/constants.js";
import { Alert } from "../modals/Alert.js";
import { setLoading } from "../setup.js";
import { getHeaders } from "./AuthService.js";

const SERVICE_URL = `${API_URL}/post`;

export function getFeed(limit = 10) {
  return fetch(`${SERVICE_URL}/feed?limit=${limit}`, { headers: getHeaders() })
    .then((r) => {
      if (!r.ok) {
        throw new Error(r.statusText);
      }
      return r.json();
    })
    .catch((e) => {
      Alert(e.message || "An error occurred", { autohide: 2500 });
    });
}

export function getPost(post_uuid) {
  return fetch(`${SERVICE_URL}/post/${post_uuid}`, { headers: getHeaders() })
    .then((r) => {
      if (!r.ok) {
        throw new Error(r.statusText);
      }
      return r.json();
    })
    .catch((e) => {
      Alert(e.message || "An error occurred", { autohide: 2500 });
    });
}

export function getSlide() {
  return fetch(`${SERVICE_URL}/slide`, { headers: getHeaders() })
    .then((r) => {
      if (!r.ok) {
        throw new Error(r.statusText);
      }
      return r.json();
    })
    .catch((e) => {
      Alert(e.message || "An error occurred", { autohide: 2500 });
    });
}

export function nextSlide(user_post_uuid, opt) {
  return fetch(`${SERVICE_URL}/slide`, {
    headers: getHeaders(),
    method: "POST",
    body: JSON.stringify({
      user_post_uuid,
      opt,
    }),
  })
    .then((r) => {
      if (!r.ok) {
        throw new Error(r.statusText);
      }
      return r.json();
    })
    .catch((e) => {
      Alert(e.message || "An error occurred", { autohide: 2500 });
    });
}

export function savePost(image) {
  setLoading(true);
  return fetch(`${SERVICE_URL}/save`, { headers: getHeaders(), method: "POST", body: JSON.stringify({ image }) })
    .then((r) => {
      setLoading(false);
      if (!r.ok) {
        throw new Error(r.statusText);
      }
      return r.json();
    })
    .catch((e) => {
      Alert(e.message || "An error occurred", { autohide: 2500 });
    });
}
