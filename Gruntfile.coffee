module.exports = (grunt) ->
  require("load-grunt-tasks") grunt

  appConfig =
    dev: "app"
    dist: "share/web"

  # Project configuration.
  grunt.initConfig
    pkg: grunt.file.readJSON("package.json")
    app: appConfig
    # Put JavaScript
    coffee:
      options:
        bare: true
        sourceMap: true
        sourceRoot: ""
      dist:
        files: [
          expand: true
          cwd: "<%= app.dev %>"
          src: "{,**/}*.coffee"
          dest: "<%= app.dist %>"
          ext: ".js"
        ]
    # Put Jade
    jade:
      options:
        pretty: true
      dist:
        files: [
          expand: true
          cwd: "<%= app.dev %>"
          src: "{,**/}*.jade"
          dest: "<%= app.dist %>"
          ext: ".html"
        ]
    # Put Stylus
    stylus:
      options:
        compress: true
        use: [require('nib')]
      dist:
        files: [
          expand: true
          cwd: "<%= app.dev %>"
          src: "{,**/}*.styl"
          dest: "<%= app.dist %>"
          ext: ".css"
        ]
    concurrent:
      dist: ["jade","coffee","stylus"]
    clean: ["share/web"]
    copy: 
      main: 
        files: [
          {expand: true, src: ['bower_components/**'], dest: 'share/web/'}
          {expand: true, cwd:'app/', src: ['images/**'], dest: 'share/web/'}
          {expand: true, cwd:'app/', src: ['*.ico','{,**/}*.php','{,**/}*.js','{,**/}*.css'], dest: 'share/web/'}
        ]
    watch:
      jade:
        files: ["app/**/*.jade"]
        tasks: ["jade"]
      coffee:
        files: ["app/**/*.coffee"]
        tasks: ["coffee"]
      styl:
        files: ["app/**/*.styl"]
        tasks: ["stylus"]
      other:
        files: ['app/images/**','app/{,**/}*.php','app/{,**/}*.js','app/{,**/}*.css']
        tasks: ["copy"]

  grunt.registerTask "default", ["clean","copy","concurrent:dist", "watch"]