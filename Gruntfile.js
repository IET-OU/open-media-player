module.exports = function(grunt) {
  grunt.initConfig({
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
    }
  });

  grunt.loadNpmTasks('grunt-contrib-uglify'); // load the given tasks
  grunt.registerTask('default', ['uglify']); // Default grunt tasks maps to grunt
};
