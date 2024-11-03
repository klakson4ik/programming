 // подключаем gulp
//const gulp = require ("gulp");
// создадим две переменные, отвечающие за чтение исходных файлов (src) и запись сгенерированных файлов (dest).
const {src, dest, watch, series} = require ("gulp");

// передаем модули в переменные
const autoprefixer = require ("gulp-autoprefixer");
const removeComments = require ("gulp-strip-css-comments");
const rename = require ("gulp-rename");
const cssnano = require ("gulp-cssnano");
const importCss = require ('gulp-import-css');
const size = require('gulp-size');

const concatJS = require('gulp-concat');
const babel = require('gulp-babel');
const terser = require('gulp-terser');

let path = {
  build: {
   	css: "public/css/",
		js: "public/js/"
	},
	src: {
    user: {
  		css: "resources/css/user",
		  js: "resources/js/user"
    },
    admin: {
  		css: "resources/css/admin",
		  js: "resources/js/admin"
    }
  },
	import: {
    user : {
		  css: "resources/css/user/import.css"
	  },
    admin : {
		  css: "resources/css/admin/import.css"
	  }
  }
}

let JSUserFiles = [
		  "resources/js/common/libs/**/*.js",
		  "resources/js/common/scripts/**/*.js",
		  "resources/js/user/libs/**/*.js",
		  "resources/js/user/scripts/**/*.js",
		  "App/Web/User/Views/Layouts/**/*.js",
        "App/Web/User/Views/Pages/**/*.js",
		  "App/Web/User/Views/Partials/**/*.js"
]
 
let CSSUserFiles = [
       "./resources/css/common/styles/**/*.css",
       "./resources/css/common/libs/**/*.css",
       "./resources/css/user/styles/**/*.css",
       "./resources/css/user/libs/**/*.css",
       "./App/Web/User/Views/Layouts/**/*.css",
       "./App/Web/User/Views/Pages/**/*.css",
       "./App/Web/User/Views/Partials/**/*.css",
]

let JSAdminFiles = [
		 "resources/js/common/libs/**/*.js",
		 "resources/js/common/scripts/**/*.js",
		 "resources/js/admin/libs/**/*.js",
		 "resources/js/admin/scripts/**/*.js",
		 "App/Web/Admin/Views/Layouts/**/*.js",
       "App/Web/Admin/Views/Pages/**/*.js",
		 "App/Web/Admin/Views/Partials/**/*.js"
]
 
let CSSAdminFiles = [
       "./resources/css/common/styles/**/*.css",
       "./resources/css/common/libs/**/*.css",
       "./resources/css/admin/styles/**/*.css",
       "./resources/css/admin/libs/**/*.css",
       "./App/Web/Admin/Views/Layouts/**/*.css",
       "./App/Web/Admin/Views/Pages/**/*.css",
       "./App/Web/Admin/Views/Partials/**/*.css",
]

const jsUser = () => {
		  return (src(JSUserFiles))
		  .pipe(concatJS("concat.js"))
		  .pipe(dest(path.src.user.js))
		  .pipe(babel({
            presets: ['@babel/env']
        }))
		.pipe(rename({
		  basename: "babel",
			extname: ".js"
		}))
		  .pipe(dest(path.src.user.js))
		.pipe(rename({
		  basename: "app",
			suffix: ".min",
			extname: ".js"
		}))
		  .pipe(terser())
		  .pipe(dest(path.build.js))
		.pipe(size({
			showFiles: true,
			showTotal: false
		}))

}
const cssUser = () => {	
	return src(path.import.user.css)
		.pipe(importCss())
		.pipe(rename({
			basename: "app",
			extname: ".css",

		}))
		  .pipe(dest(path.src.user.css))
		.pipe(autoprefixer({    
			Browserslist: ['last 8 versions'],
         cascade: true
   	}))
		.pipe(rename({
			basename: "prefix",
			extname: ".css",

		}))
		  .pipe(dest(path.src.user.css))
		.pipe(cssnano({
			zindex: false,
			discardComments: {
				removeAll: true
			}
		}))
		.pipe(removeComments())
		.pipe(rename({
		  basename: "app",
			suffix: ".min",
			extname: ".css"
		}))
		.pipe(dest(path.build.css))
		.pipe(size({
			showFiles: true,
			showTotal: false
		}))

}

const jsAdmin = () => {
		  return (src(JSAdminFiles))
		  .pipe(concatJS("concat.js"))
		  .pipe(dest(path.src.admin.js))
		  .pipe(babel({
            presets: ['@babel/env']
        }))
		.pipe(rename({
		  basename: "babel",
			extname: ".js"
		}))
		  .pipe(dest(path.src.admin.js))
		.pipe(rename({
		  basename: "admin",
			suffix: ".min",
			extname: ".js"
		}))
		  .pipe(terser())
		  .pipe(dest(path.build.js))
		.pipe(size({
			showFiles: true,
			showTotal: false
		}))

}
const cssAdmin = () => {	
	return src(path.import.admin.css)
		.pipe(importCss())
		.pipe(rename({
			basename: "admin",
			extname: ".css",

		}))
		  .pipe(dest(path.src.admin.css))
		.pipe(autoprefixer({    
			Browserslist: ['last 8 versions'],
         cascade: true
   	}))
		.pipe(rename({
			basename: "prefix",
			extname: ".css",

		}))
		  .pipe(dest(path.src.admin.css))
		.pipe(cssnano({
			zindex: false,
			discardComments: {
				removeAll: true
			}
		}))
		.pipe(removeComments())
		.pipe(rename({
		  basename: "admin",
			suffix: ".min",
			extname: ".css"
		}))
		.pipe(dest(path.build.css))
		.pipe(size({
			showFiles: true,
			showTotal: false
		}))

}
// Watch
const watcher = () => {
  watch(CSSUserFiles, cssUser);
  watch(JSUserFiles, jsUser);
  watch(CSSAdminFiles, cssAdmin);
  watch(JSAdminFiles, jsAdmin);
};

// Default

exports.default = watcher

exports.watch = watcher;
exports.jsUser = jsUser;
exports.cssUser = cssUser;
exports.jsAdmin = jsAdmin;
exports.cssAdmin = cssAdmin;
