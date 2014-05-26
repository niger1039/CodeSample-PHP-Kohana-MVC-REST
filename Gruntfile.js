module.exports = function(grunt) {
  
  // Project configuration.
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    
    dir: {
        base: './public/',
        base_js: '<%= dir.base %>' + 'js/',
        base_img: '<%= dir.base %>' + 'img/',
        base_sass: '<%= dir.base %>' + 'scss/',
        base_css: '<%= dir.base %>' + 'css/'
    },
    
    jshint: {
      files: [
          '<%=dir.base_js%>/**/*.js'
      ],
      options: {
        curly:      true,
        eqeqeq:     true,
        immed:      true,
        latedef:    true,
        noarg:      true,
        sub:        true,
        undef:      true,
        boss:       true,
        eqnull:     true,
        browser:    true,
        multistr:   true,
        newcap:     false,
        globals: {
            console: true,
            $: true,
            jQuery: true
        }
      }
    },
    
    compass: {
      all: {
        options: {
          sassDir: '<%= dir.base_sass %>',
          imagesDir: '<%= dir.base_img %>',
          javascriptsDir: '<%= dir.base_js %>',
          cssDir: '<%= dir.base_css %>',
          require: ['compass-normalize', 'rgbapng'],
          relativeAssets: true,
          raw: 'preferred_syntax = :scss\n',
          environment: 'development',
          outputStyle: 'expanded'
        }
      },
      deploy: {
        options: {
          sassDir: '<%= dir.base_sass %>',
          imagesDir: '<%= dir.base_img %>',
          javascriptsDir: '<%= dir.base_js %>',
          cssDir: '<%= dir.base_css %>',
          require: ['compass-normalize', 'rgbapng'],
          relativeAssets: true,
          raw: 'preferred_syntax = :scss\n',
          noLineComments: true,
          environment: 'production',
          outputStyle: 'compact'
        }
      }
    },
    
    watch: {
      all: {
        files: ['<%= jshint.files %>','<%= dir.base_sass%>/**/*.scss'],
        tasks: ['js','sass']
      },
      js: {
        files: ['<%= jshint.files %>'],
        tasks: ['js']
      },
      sass: {
        files: ['<%= dir.base_sass%>/**/*.scss'],
        tasks: ['sass']
      },
    }
  });

  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('js', ['jshint']);

  grunt.registerTask('sass', ['compass:all']);
  
  grunt.registerTask('default', ['jshint','compass:all']);
  
  grunt.registerTask('deploy', ['jshint','compass:deploy']);

};