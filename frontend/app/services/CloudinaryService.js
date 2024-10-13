import { cloudName, API_URL } from "../config/constants.js";
import { Alert } from "../modals/Alert.js";
import { setLoading } from "../setup.js";
import { getHeaders } from "./AuthService.js";

const SERVICE_URL = `${API_URL}/cloudinary`;

export function uploadImage(image) {
  setLoading(true);
  return fetch(`${SERVICE_URL}/upload`, { headers: getHeaders(), method: "POST", body: JSON.stringify({ image }) })
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

export function generateCloudinaryUrl(publicId) {
  const baseUrl = `https://res.cloudinary.com/${cloudName}/image/upload`;
  return `${baseUrl}/e_gen_background_replace:prompt_silent%20hill/e_gen_replace:from_all;to_zombie;preserve-geometry_true;multiple_true/c_pad,ar_3:4,h_1500,b_gen_fill/${publicId}.png`;
}
