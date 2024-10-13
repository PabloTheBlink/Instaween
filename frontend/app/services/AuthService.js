import { API_URL } from "../config/constants.js";
import { Alert } from "../modals/Alert.js";
import { setLoading } from "../setup.js";

const SERVICE_URL = `${API_URL}/auth`;

export function getHeaders() {
  const headers = {};
  if (localStorage.getItem("token")) {
    headers.Authorization = `Bearer ${localStorage.getItem("token")}`;
  }
  return headers;
}

export function getCurrentUser() {
  setLoading(true);
  return fetch(`${SERVICE_URL}/current-user`, { headers: getHeaders() })
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
