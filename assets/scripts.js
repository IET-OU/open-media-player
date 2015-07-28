
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');


$(function () {

    var W = window
      , L = window.location
      , d = new Date()
      ;

    ga('create', 'UA-24005173-1', 'auto');
    ga('send', 'pageview', '/iet-ou.github.io' + L.pathname + L.search);

    //console.log('pageview', '/iet-ou.github.io' + L.pathname + L.search);

    // Event tracking: https://developers.google.com/analytics/devguides/collection/analyticsjs/events
    $("a").on("click", function (ev) {
      var url = $(this).attr("href")
        , text = $(this).text();

      if (url.match(/^https?:/)) {
        // External URL.
        ga('send', 'event', 'link', 'click', text +' '+ url);

        console.log("Track extern link click:", text, url);
      }

      //ev.preventDefault();
    });

    // Copyright year
    $("footer .copyright-year").html(d.getYear() + 1900);
});
