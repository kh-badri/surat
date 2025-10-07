/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/Views/**/*.php",
    "./app/Views/*.php", // Menambahkan path ini untuk view di root app/Views
  ],
  theme: {
    extend: {
      fontFamily: {
        // Tambahkan baris ini
        corsiva: ['"Monotype Corsiva"', "cursive"],
        times: ['"Times New Roman"', "serif"],
      },
      colors: {
        // Warna tema kuning seperti Maxim
        primary: {
          50: "#fffde7",
          100: "#fff9c4",
          200: "#fff59d",
          300: "#fff176",
          400: "#ffee58",
          500: "#ffeb3b", // Warna utama
          600: "#fdd835",
          700: "#fbc02d",
          800: "#f9a825",
          900: "#f57f17",
        },
        secondary: "#212121", // Warna sekunder (abu-abu gelap)
      },
    },
  },
  plugins: [],
};
