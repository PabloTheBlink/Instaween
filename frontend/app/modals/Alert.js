import { Modal } from "../../assets/js/ScopeJS.min.js";

export function Alert(message, options) {
  Modal({
    controller: function () {
      if (options.autohide) {
        setTimeout(() => {
          this.close();
        }, options.autohide);
      }
    },
    render: function () {
      return /* HTML */ ` <div class="alert">${message}</div> `;
    },
    hideWhenClickOverlay: true,
  });
}
