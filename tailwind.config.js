import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    "./app/Models/*",
    "./storage/framework/views/*.php",
    "./resources/views/**/*.blade.php",
    "./app/helpers/*.php",
    "./app/Enum/*.php",
    "./resources/views/components/*.php",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          DEFAULT: "#F76914",
          50: "#FFF1E8",
          100: "#FFE4D4",
          200: "#FFC9A8",
          300: "#FFAB78",
          400: "#FF8B47",
          500: "#F76914",
          600: "#DE5D11",
          700: "#C7510F",
          800: "#A9450D",
          900: "#87370A",
        },
      },
      fontFamily: {
        sans: ["Figtree", ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [forms],
};
