// tailwind.config.js
module.exports = {
  content: [
    "./app/Views/**/*.php", // Pastikan ini mencakup semua file view Anda
    "./app/Controllers/**/*.php", // Jika Anda memiliki kelas Tailwind di controller
    // ... tambahkan jalur lain jika ada file PHP/JS yang menggunakan kelas Tailwind
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
