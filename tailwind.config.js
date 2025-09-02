/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.html",
    "./*.php",
    "./**/*.html",
    "./**/*.php",
    "./src/**/*.{js,jsx,ts,tsx}"
  ],
  theme: {
    extend: {
      colors: {
        // Custom colors
        primary: '#156064',
        accents: '#03CEA4',
        brandGreen: {
          light: '#FEFFA5',
          DEFAULT: '#38a169',
          dark: '#2f855a',
        },
        zenleafPrimary: '#00a8a3',
        zenleafSecondary: '#ffac81',
        zenleafAccent: '#8582f4',
      },
      fontFamily: {
        sans: ['Helvetica', 'Arial', 'sans-serif'],
      },
    },
  },
  plugins: [],
}
