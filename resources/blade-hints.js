import "./blade-hints.css";

import tippy from "tippy.js";
import "tippy.js/dist/tippy.css";

document.addEventListener("DOMContentLoaded", function () {
  tippy(".blade-hints", {
    content: (reference) => reference.dataset.bladeHintsLabel,
  });
});
