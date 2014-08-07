module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    clean: ["build","rpm"],
    bump: {
      options: {
        files: ['package.json'],
        updateConfigs: [],
        commit: true,
        commitMessage: 'Release v%VERSION%',
        commitFiles: ['package.json'], // '-a' for all files
        createTag: true,
        tagName: 'v%VERSION%',
        tagMessage: 'Version %VERSION%',
        push: true,
        pushTo: 'origin',
        gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d' // options to use with '$ git describe'
      },
    },
    rpm: {
        options: {
          release: true,
          destination: 'rpm/app',
          name: 'rust-example',
          version: null,
          release: true,
          homepage: 'https://github.com/russellsimpkins/rust-example/',
          summary: 'PHP Rest Example',
          license: 'MIT',
          distribution: 'Public',
          vendor: '',
          group: '',
          requires: null,
          description: 'An example program that uses the rust-framework to create a RESTFul API',
          defaultFilemode: null,
          defaultUsername: null,
          defaultGroupname: null,
          defaultDirmode: null,
          preInstall: null,
          postInstall: null,
          preUninstall: null,
          postUninstall: null,
        },
        files: { dest: '/opt/www/rust-example/', src : [ 'src/**/*', 'vendor/**/*' ], filter: function(filepath) {
              return ! (filepath.match(/\.git|\.svn|phpunit/) ? true : false);
            } 
        },
    },
  });

  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-bump');
  grunt.loadNpmTasks('grunt-rpm');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.registerTask('default', ['clean','rpm']);
};

