export default {
  plugins: ['@shufo/prettier-plugin-blade'],
  overrides: [
    {
      files: '*.js',
      options: {
        arrowParens: 'always',
        parser: 'babel',
        printWidth: 80,
        semi: false,
        singleQuote: true,
        tabWidth: 2,
        trailingComma: 'all',
      },
    },
    {
      files: '*.css',
      options: {
        parser: 'css',
        printWidth: 80,
        singleQuote: true,
        tabWidth: 2,
      },
    },
    {
      files: '*.json',
      options: {
        parser: 'json',
        printWidth: 80,
        tabWidth: 2,
      },
    },
    {
      files: '*.php',
      options: {
        parser: 'php',
        singleQuote: true,
      },
    },
    {
      files: '*.blade.php',
      options: {
        parser: 'blade',
        sortTailwindcssClasses: true,
        tabWidth: 2,
      },
    },
  ],
}
