import { generateCloudinaryUrl, uploadImage } from "../services/CloudinaryService.js";
import { savePost } from "../services/PostService.js";
import { setLoading } from "../setup.js";

export const UploadImageModal = {
  controller: function () {
    this.original_image = null;
    this.public_id = null;
    this.converted_image = null;

    this.loadImageAsync = function (src, callback) {
      const image = new Image();
      image.src = src;
      image.onload = () => {
        callback(src);
      };
      image.onerror = () => {
        this.loadImageAsync(src, callback);
      };
    };

    this.imageToBase64 = async function (url) {
      const response = await fetch(url);
      const blob = await response.blob();
      return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onloadend = () => resolve(reader.result);
        reader.onerror = reject;
        reader.readAsDataURL(blob);
      });
    };

    this.uploadImage = function (e) {
      const reader = new FileReader();
      reader.readAsDataURL(e.target.files[0]);
      reader.onload = () => {
        this.original_image = reader.result;
        setLoading(true);
        this.apply();
        uploadImage(reader.result).then((res) => {
          this.loadImageAsync(generateCloudinaryUrl(res.public_id), (src) => {
            this.imageToBase64(src).then((src) => {
              this.converted_image = src;
              setLoading(false);
              this.apply();
            });
          });
        });
      };
      e.target.value = "";
    };

    this.savePost = function () {
      if (!this.converted_image) return;
      savePost(this.converted_image).then((r) => {
        this.close(r);
      });
    };
  },
  render: function () {
    return /* HTML */ `
      <div class="upload-image-modal">
        ${!this.original_image
          ? /* HTML */ `
              <label class="dropzone">
                <i class="fa-solid fa-upload"></i>
                <span>Subir Imagen</span>
                <input onchange="uploadImage()" type="file" accept="image/*" />
              </label>
            `
          : /* HTML */ `
              <div class="image-container">
                <img src="${this.converted_image || this.original_image}" />
              </div>
              <div style="display: flex; align-items: center; padding: 1rem; gap: 1rem; justify-content: flex-end;">
                <button onclick="close()">Cancelar</button>
                <button ${!this.converted_image ? /* HTML */ `disabled` : /* HTML */ ``} onclick="savePost()">Publicar</button>
              </div>
            `}
      </div>
    `;
  },
  hideWhenClickOverlay: true,
};
