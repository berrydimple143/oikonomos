import Alpine from '../node_modules/alpinejs/dist/module.esm.min.js';
import { gsap } from "../node_modules/gsap/index.js";
import { ScrambleTextPlugin } from "../node_modules/gsap/ScrambleTextPlugin.js";
import { SplitText } from "../node_modules/gsap/SplitText.js";
import { TextPlugin } from "../node_modules/gsap/TextPlugin.js";

gsap.registerPlugin(ScrambleTextPlugin, SplitText, TextPlugin);

window.gsap = gsap;
window.Alpine = Alpine;

Alpine.start();
