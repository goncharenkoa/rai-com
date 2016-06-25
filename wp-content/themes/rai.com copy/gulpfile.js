var gulp = require('gulp');
var jade = require('gulp-jade');
var watch = require('gulp-watch');
var sass = require('gulp-sass');
var gls = require('gulp-live-server');
var sourcemaps = require('gulp-sourcemaps');
var uglify      = require('gulp-uglify');

gulp.task('compressjs', function() {
    return gulp.src('./src/assets/js/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./js/'));
});

gulp.task('serve', function() {
    var server = gls.static('dist', 8080);
    server.start();
    gulp.watch(['dist/css/*.css', 'dist/*.html'], function (file) {
        server.notify.apply(server, [file]);
    });
});
gulp.task('templates', function() {
    var YOUR_LOCALS = {};

    gulp.src('./src/jade/pages/*.jade')
        .pipe(jade({
            locals: YOUR_LOCALS,
            pretty: true
        }))
        .pipe(gulp.dest('./dist/'))
});
gulp.task('sass', function () {
    return gulp.src('./src/assets/sass/main.sass')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./css'));
});
gulp.task('watcher', function () {
    gulp.watch('./src/assets/js/*.js', ['compressjs']);
    gulp.watch('./src/assets/sass/**/*.sass', ['sass']);
    //gulp.watch('./src/jade/**/*.jade', ['templates']);
});
