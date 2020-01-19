const mix = require('laravel-mix');
const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin');

const srcPath = 'resources/ts/';

mix.ts('resources/ts/app.ts', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .sass('resources/sass/myapp.scss', 'public/css')
  .webpackConfig({
    resolve: {
      alias: {
        '@sass': path.resolve('resources/sass'),
        '@src': path.resolve(__dirname, srcPath),
        '@store': path.resolve(__dirname, srcPath + 'store/'),
        '@views': path.resolve(__dirname, srcPath + 'views/'),
        '@components': path.resolve(__dirname, srcPath + 'components/'),
        '@core': path.resolve(__dirname, srcPath + 'core/'),
        '@modules': path.resolve(__dirname, srcPath + 'store/modules/'),
      }
    },
    plugins: [
      new VuetifyLoaderPlugin()
    ],
  });

mix.browserSync({
  proxy: {
    target: "localhost:8000",
    ws: true,
  },
  files: [
    './app/Http/Controllers/*.php',
    './public/css/*.css',
    './public/js/*.js',
    './resources/views/**/*.blade.php',
    './resources/views/*.blade.php',
    './resources/ts/components/*.vue',
  ],
  watchOptions: {
    usePolling: true,
    interval: 100
  },
  open: "external",
  reloadOnRestart: true
});
