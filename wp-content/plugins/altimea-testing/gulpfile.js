// config globals
var src = './src/',
    dist = './public/assets/',
    srcPug = './src/pug/**/*.pug',
    distPartials = './public/partials/',
    proxyUrl = 'testing.wp',
    localPort = 8080,
    destJSFile = 'altimea-testing-main.js';

// my scripts: default load all script of folder js/*
var scripts = [
    src + 'js/functions.js',
    src + 'js/main.js'
];

// node modules folder
var modules = './node_modules/';
// var plugins path: (check theme plugins before of add new plugins)
var plugins = [
  // modules + 'vue/dist/vue.js'

];

// define package
var gulp = require('gulp'),
    babel = require('gulp-babel'),
    plumber = require('gulp-plumber'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    eslint = require('gulp-eslint'),
    sass = require('gulp-sass'),
    postcss = require('gulp-postcss'),
    autoprefixer = require('autoprefixer'),
    cssnano = require('cssnano'),
    sourcemaps = require('gulp-sourcemaps'),
    browserSync = require('browser-sync').create(),
    reload = browserSync.reload,
    imagemin = require('gulp-imagemin'),
    md5 = require('gulp-md5'),
    del = require('del'),
    wpPot = require('gulp-wp-pot'),
    stylelint = require('gulp-stylelint'),
    crypto = require('crypto'),
    fs = require('fs'),
    mymd5 = require('./node_modules_third/gulp-mymd5/index.js'),
    rename = require('gulp-rename'),
    pug = require('gulp-pug'),
    dataJson = {
        'md5': ''
    };

gulp.task('scripts-cleanup', () => {
    del.sync([dist], {force: true});
});

/**
 * task execute
 * this create a file with data json
 * create variable hash to production
*/
gulp.task( 'set-dataJson', () => {
    dataJson['md5'] = crypto.createHash( 'md5' ).update( Date.now().toString() ).digest( 'hex' ).slice( 0, 10 );
    fs.writeFile( './gulpfiledata.json', JSON.stringify( dataJson ), function( err ) {
        if ( err ) {
            return console.log( err );
        }
    });
});

//pug
gulp.task('pug', () => {
    return gulp.src(srcPug)
        .pipe(pug({ pretty: true }))
        .pipe(rename({
            extname: '.php'
        }))
        .pipe(gulp.dest(distPartials))
});

// pot files
gulp.task('potFiles', () => {
    return gulp.src(['**/*.php'])
    .pipe(wpPot({
        domain: 'altimea-testing'
    }))
    .pipe(gulp.dest('languages/altimea-testing.pot'));
});

// minify images
gulp.task('images', () => {
    return gulp.src(src + 'img/**/*.+(png|jpg|jpeg|gif|svg)')
    .pipe(imagemin())
    .pipe(gulp.dest(dist + 'img/'));
});

// copy fonts
gulp.task('fonts', () => {
    return gulp.src(src + 'fonts/**/*')
    .pipe(gulp.dest(dist + 'fonts/'));
});

// sass mappgins files
gulp.task('styles:dev', () => {
    var processors = [
        autoprefixer({browsers: ['> 3%', 'last 2 versions', 'ie 9', 'ios 6', 'android 4']})
    ];

    return gulp.src(src + 'scss/**/*.scss')
        .pipe(plumber())
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(postcss(processors))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest(dist + 'css/'))
        .pipe(browserSync.stream());
});

// sass dist remove source maps
gulp.task('styles:dist', () => {
    var processors = [
        autoprefixer({browsers: ['> 3%', 'last 2 versions', 'ie 9', 'ios 6', 'android 4']}),
        cssnano({zindex: false})
    ];

    return gulp.src(src + 'scss/**/*.scss')
        .pipe(plumber())
        .pipe(sass())
        .pipe(postcss(processors))
        .pipe(gulp.dest(dist + 'css/'))
        .pipe(mymd5(dataJson.md5))
        .pipe(gulp.dest(dist + 'css/'));
});


// script js
var scriptsTemp = [
    src + 'temp/plugins.js',
    src + 'temp/main.js'
];

// plugins js minify
gulp.task('pluginsjs', () => {
    return gulp.src(plugins)
            .pipe(concat('plugins.js'))
            .pipe(uglify())
            .pipe(gulp.dest(src + 'temp/'));
});

gulp.task('scripts:temp', () => {
    return gulp.src(scripts)
            .pipe(sourcemaps.init())
            .pipe(plumber())
            .pipe(eslint())
            .pipe(eslint.format())
            .pipe(eslint.failAfterError())
            .pipe(babel({
              presets: ['@babel/env']
            }))
            .pipe(concat('main.js'))
            .pipe(sourcemaps.write())
            .pipe(gulp.dest(src + 'temp/'));
});

gulp.task('eslint:dev', () => {
    return gulp.src(scriptsTemp)
            .pipe(eslint())
            .pipe(eslint.format())
            .pipe(eslint.failAfterError());
});

gulp.task('scripts:dev', () => {
    return gulp.src(scriptsTemp)
            .pipe(sourcemaps.init())
            .pipe(plumber())
            .pipe(concat(destJSFile))
            .pipe(sourcemaps.write())
            .pipe(gulp.dest(dist + 'js/'));
});

gulp.task('eslint:dist', () => {
    return gulp.src(scriptsTemp)
            .pipe(eslint())
            .pipe(eslint.format())
            .pipe(eslint.failAfterError());
});

gulp.task('scripts:dist', () => {
    return gulp.src(scriptsTemp)
            .pipe(plumber())
            .pipe(concat(destJSFile))
            .pipe(uglify())
            .pipe(gulp.dest(dist + 'js/'))
            .pipe(mymd5(dataJson.md5))
            .pipe(gulp.dest(dist + 'js/'));
});

gulp.task('lint-css', ['styles:dev'], () => {
    return gulp
        .src(src + 'scss/**/*.scss')
        .pipe(stylelint({
            reporters: [
                {formatter: 'string', console: true}
            ]
    }));
});

// serve
gulp.task('serve', () => {
    browserSync.init({
        proxy: proxyUrl,
        port: localPort,
        reloadDebounce: 500
    });
    
    gulp.watch(src + 'scss/**/*.scss', ['lint-css']);
    gulp.watch(src + 'js/**/*.js', ['scripts:temp']);
    gulp.watch(src + 'temp/**/*.js', ['scripts:dev']).on('change', reload);
    gulp.watch('./**/*.php').on('change', reload);
});

// tasks globals
gulp.task('static', ['potFiles', 'pluginsjs', 'scripts:temp', 'fonts', 'images', 'pug']);

// build all
gulp.task('build', ['lint-css', 'scripts:dev', 'static']);

// gulp minify all
gulp.task('dist', ['scripts-cleanup', 'set-dataJson', 'styles:dist', 'scripts:dist', 'static']);

// dev default tasks
gulp.task('default', ['build', 'serve']);
