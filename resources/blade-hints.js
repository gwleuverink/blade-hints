import "./blade-hints.css";

import tippy, { inlinePositioning } from "tippy.js";
import "tippy.js/dist/tippy.css";

document.addEventListener("DOMContentLoaded", function () {
  tippy(".blade-hints", {
    interactive: true,
    inlinePositioning: true,
    plugins: [inlinePositioning],
    content: (reference) => reference.dataset.bladeHintsLabel,
  });
});
