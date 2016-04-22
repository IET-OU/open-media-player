module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    uglify: {
      my_target: {
        files: {
          'application/themes/ouplayer_base/build/ouplayer-mediaelement.min.js':
          ['application/themes/ouplayer_base/js/mep-header-cl.js',
          'application/themes/ouplayer_base/js/mep-oup-log.js',
          'application/engines/mediaelement/src/js/me-namespace.js',
          'application/engines/mediaelement/src/js/me-utility.js',
          'application/engines/mediaelement/src/js/me-plugindetector.js',
          'application/engines/mediaelement/src/js/me-featuredetection.js',
          'application/engines/mediaelement/src/js/me-mediaelements.js',
          'application/engines/mediaelement/src/js/me-shim.js',
          'application/engines/mediaelement/src/js/me-i18n.js',
          'application/engines/mediaelement/src/js/mep-library.js',
          'application/themes/ouplayer_base/js/mep-player.js',
          'application/engines/mediaelement/src/js/mep-feature-time.js',
          'application/themes/ouplayer_base/js/mep-feature-fullscreen.js',
          'application/themes/ouplayer_base/js/mep-feature-tracks.js',
          'application/engines/mediaelement/src/js/mep-feature-googleanalytics.js',
          'application/themes/ouplayer_base/js/mep-oup-header.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-shim.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-error.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-tracks-shim.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-playpause.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-progress.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-volume.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-postmessage.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-popout.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-transcript.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-quality.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-options.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-tooltip.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-group.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-fullscreenhover.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-copyembed.js',
          'application/themes/ouplayer_base/js/mep-oup-feature-ignore-color.js']
        }
      }
    },
    gitinfo: {},
    'git-describe': {
      me: {}
    },

  });

  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-gitinfo');
  grunt.loadNpmTasks('grunt-git-describe');

  // Default task builds the js
  grunt.registerTask('default', ['uglify']);

  // Save information from git to the version.json file
  grunt.registerTask('store-revision', function() {
    grunt.event.once('git-describe', function (rev) {
      grunt.option('gitRevision', rev);
      grunt.task.requires('git-describe');
      grunt.task.requires('gitinfo');
      grunt.file.write('version.json', JSON.stringify({
        commit: grunt.config('gitinfo.local.branch.current.SHA'),
        author:grunt.config('gitinfo.local.branch.current.lastCommitAuthor'),
        date:grunt.config('gitinfo.local.branch.current.lastCommitTime'),
        message:grunt.config('gitinfo.local.branch.current.lastCommitMessage'),
        version:grunt.option('gitRevision').tag+'-'+
                grunt.option('gitRevision').since+'-g'+grunt.option('gitRevision').object,
        branch:grunt.config('gitinfo.local.branch.current.name'),
        origin:grunt.config('gitinfo.remote.origin.url'),
        file_date:grunt.template.today(),
        test:"Test",
      }, null, 4));
    });
    grunt.task.run('git-describe');
  });

  grunt.registerTask('version', ['gitinfo', 'store-revision']);
};
