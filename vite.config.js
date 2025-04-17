import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/sass/app.scss",
        "resources/sass/oneui/themes/_base.scss",
        "resources/sass/oneui/themes/amethyst.scss",
        "resources/sass/oneui/themes/city.scss",
        "resources/sass/oneui/themes/flat.scss",
        "resources/sass/oneui/themes/modern.scss",
        "resources/sass/oneui/themes/smooth.scss",
        "resources/js/app.js",
        "resources/sass/main.scss",
        "resources/js/oneui/app.js",
        "resources/js/pages/op_auth_two_factor.min.js",
        "resources/js/pages/dashboard.js",
        "resources/js/pages/datatables.js",
        "resources/js/pages/be_comp_rating.js",
        "resources/js/pages/admin/languages.js",
        "resources/js/pages/admin/media_selection.js",
        // front
        "resources/js/scripts.js",
      ],
      refresh: true,
    }),
  ],
});
