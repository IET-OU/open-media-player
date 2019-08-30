
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');


window.jQuery(function ($) {

    const WIN = window;
    const LOC = WIN.location;
    const ga = WIN.ga;

    // $("iframe.omp-player").attr("src", $("meta[ name = omp-embed-url ]").first().attr("content"));

    // Analytics.
    ga('create', 'UA-24005173-1', 'auto');
    ga('send', 'pageview', '/iet-ou.github.io' + L.pathname + L.search);


    // Event tracking: https://developers.google.com/analytics/devguides/collection/analyticsjs/events
    $("a").on("click", function (ev) {
      var url = $(this).attr("href")
        , text = $(this).text();

      if (url.match(/^https?:/)) {
        // External URL.
        ga('send', 'event', 'link', 'click', text +' '+ url);

        console.warn("Track extern link click:", text, url);
      }

      //ev.preventDefault();
    });


    // OMP widget/ badge.
    var $widget = $(".omp-widget")
      , $area = $("#copy-area")
      , html = $widget[0].outerHTML
      , U = LOC.href.replace(/#.*/, '')
      ;

    $area.val(html.replace(/\.\//g, U));

    //TODO: ? http://stackoverflow.com/questions/5797539/jquery-select-all-text-from-a-textarea

    WIN.setTimeout(function () {
      if ("#share" === LOC.hash) {
        $("#share > button").trigger("click");
      }
    }, 100);


    if (LOC.search.match(/[\?&]anti.?glare=\w/)) {
      $("body").addClass("anti-glare");
    }


    // Accessibility: trigger tooltips on keyboard focus too!
    $(".navbar a[ title ], .navbar-toggle[ title ], .dropup [ title ]")
      .data("placement", "bottom");


    $("a[ title ], button[ title ], iframe.XX")
    ///$('[ data-toggle = tooltip ]')
      .on("focus", function() {
        $(this).tooltip();
      })
      .tooltip();


    // Copyright year
    $("footer .copyright-year").html((new Date()).getFullYear());
});
