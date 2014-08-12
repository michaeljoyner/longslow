var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    rename = require('gulp-rename'),
    minifycss = require('gulp-minify-css');

gulp.task('sass', function () {
    return gulp.src('app/assets/sass/**/*.scss')
        .pipe(sass({style: 'expanded'}))
        .pipe(autoprefixer('last 5 version'))
        .pipe(gulp.dest('public/styles/css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(gulp.dest('public/styles/css'));
});

gulp.task('watch', function(){
    return gulp.watch('app/assets/sass/**/*.scss', ['sass']);
});

gulp.task('default', ['sass', 'watch']);