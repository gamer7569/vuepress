(function(){
  'use strict';

  /*
  |-----------------------------------------------------------------------------
  | Load Modules
  |-----------------------------------------------------------------------------
  */

  var gulp          = require('gulp'),
      rename        = require('gulp-rename'),
      plumber       = require('gulp-plumber'),
      util          = require('gulp-util'),
      clean         = require('gulp-clean'),

      // PHP Server & BrowserSync
      browserSync   = require('browser-sync').create(),

      // JS Related
      webpack     = require('webpack-stream');

  /*
  |-----------------------------------------------------------------------------
  | Global Config
  |-----------------------------------------------------------------------------
  */

  var reload = browserSync.reload;
  var themePath = './';

  var otherPaths    =   {
    'jsDest'      : './assets/js/',
    'webpackConfig'   : './webpack.config.js'
  };

  /*
  |-----------------------------------------------------------------------------
  | BrowserSync Webserver
  |-----------------------------------------------------------------------------
  */

  /** Setting up BrowserSync */
  gulp.task('browser-sync', function(){
    browserSync.init({
      proxy: 'vuepress.dev',
      port: 8080,
      open: true,
      notify: false
    });
  });


  /*
  |-----------------------------------------------------------------------------
  | Webpack
  |-----------------------------------------------------------------------------
  */
  gulp.task('webpack:build', function() {
    webpack(require(otherPaths.webpackConfig))
    .pipe(gulp.dest(otherPaths.jsDest ));
  });

  gulp.task('webpack', function() {
    var config = require(otherPaths.webpackConfig);
    config.watch = true;

    webpack(config)
    .pipe(gulp.dest(otherPaths.jsDest));
  });

  gulp.task('scripts', ['webpack']);


  /** Cleanup Dist-Directories before Build */
  gulp.task('clean', function(){
    return gulp.src([otherPaths.jsDest], {read: false})
      .pipe(clean())
  });

  /*
  |-----------------------------------------------------------------------------
  | Gulp Tasks
  |-----------------------------------------------------------------------------
  */

  /** Build Task */

  gulp.task('default', ['webpack:build']);

  gulp.task('dev', ['webpack']);

  /** Server Task */
  gulp.task('serve', ['dev', 'browser-sync'], function() {

  // Watch JS Scripts
  gulp.watch(otherPaths.jsDest + '**/*.js', reload);

  gulp.watch(['./gulpfile.js'], ['scripts', reload]);
  });

})();
