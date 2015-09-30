
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');


$(function () {

    var W = window
      , L = W.location
      ;

    ga('create', 'UA-24005173-1', 'auto');
    ga('send', 'pageview', '/iet-ou.github.io' + L.pathname + L.search);


    // Event tracking: https://developers.google.com/analytics/devguides/collection/analyticsjs/events
    $("a").on("click", function (ev) {
      var url = $(this).attr("href")
        , text = $(this).text();

      if (url.match(/^https?:/)) {
        // External URL.
        ga('send', 'event', 'link', 'click', text +' '+ url);

        W.console && console.log("Track extern link click:", text, url);
      }

      //ev.preventDefault();
    });


    // OMP widget/ badge.
    var $widget = $(".omp-widget")
      , $area = $("#copy-area")
      , html = $widget[0].outerHTML
      , U = W.location.href.replace(/#.*/, '')
      ;

    $area.val(html.replace(/\.\//g, U));

    //TODO: ? http://stackoverflow.com/questions/5797539/jquery-select-all-text-from-a-textarea

    setTimeout(function () {
      if ("#share" === W.location.hash) {
        $("#share > button").trigger("click");
      }
    }, 100);


    if (L.search.match(/[\?&]anti.?glare=\w/)) {
      $("body").addClass("anti-glare");
    }


    $('[ data-toggle = tooltip ]').tooltip();

    // Copyright year
    $("footer .copyright-year").html((new Date()).getFullYear());
});
