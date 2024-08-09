import "./glimpse.css";

import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";

document.addEventListener("DOMContentLoaded", function () {
  tippy(".glimpse", {
    content: (reference) => reference.dataset.glimpseLabel,
  });
});
