/*!
 * jquery oembed plugin
 *
 * Copyright (c) 2009 Richard Chamorro
 * Licensed under the MIT license
 *
 * Author: Richard Chamorro
 */

/*!
 * Open Media Player modifications: © 2011 The Open University.
 */

// Revision #23 on Google Code (was #20).

/* eslint no-useless-escape: "off" */
/* global getOEmbedProvider */

(function ($) {
  $.fn.oembed = function (url, options, embedAction) {
    settings = $.extend(true, $.fn.oembed.defaults, options);

    initializeProviders();

    return this.each(function () {
      var container = $(this);

      var resourceURL = (url != null) ? url : container.attr('href');

      var provider;

      if (embedAction) {
        settings.onEmbed = embedAction;
      } else {
        settings.onEmbed = function (oembedData) {
          $.fn.oembed.insertCode(this, settings.embedMethod, oembedData);
        };
      }

      if (resourceURL != null) {
        provider = $.fn.oembed.getOEmbedProvider(resourceURL);

        if (provider != null) {
          provider.params = getNormalizedParams(settings[provider.name]) || {};
          provider.maxWidth = settings.maxWidth;
          provider.maxHeight = settings.maxHeight;
          embedCode(container, resourceURL, provider);
        } else {
          settings.onProviderNotFound.call(container, resourceURL);
        }
      }

      return container;
    });
  };

  var settings; var activeProviders = [];

  // Plugin defaults
  $.fn.oembed.defaults = {
    maxWidth: null,
    maxHeight: null,
    embedMethod: 'replace', // "auto", "append", "fill"
    defaultOEmbedProvider: 'oohembed', // "oohembed", "embed.ly", "none"
    allowedProviders: null,
    disallowedProviders: null,
    customProviders: null, // [ new $.fn.oembed.OEmbedProvider("customprovider", null, ["customprovider\\.com/watch.+v=[\\w-]+&?"]) ]
    defaultProvider: null,
    greedy: true,
    onProviderNotFound: function () { },
    beforeEmbed: function () { },
    afterEmbed: function () { },
    onEmbed: function () { },
    onError: function () {},
    ajaxOptions: {}
  };

  /* Private functions */
  function getRequestUrl (provider, externalUrl) {
    var url = provider.apiendpoint; var qs = ''; var callbackparameter = provider.callbackparameter || 'callback'; var i;

    if (url.indexOf('?') <= 0) { url = url + '?'; } else { url = url + '&'; }

    if (provider.maxWidth != null && provider.params['maxwidth'] == null) { provider.params['maxwidth'] = provider.maxWidth; }

    if (provider.maxHeight != null && provider.params['maxheight'] == null) { provider.params['maxheight'] = provider.maxHeight; }

    for (i in provider.params) {
      // We don't want them to jack everything up by changing the callback parameter
      if (i === provider.callbackparameter) { continue; }

      // allows the options to be set to null, don't send null values to the server as parameters
      if (provider.params[i] != null) { qs += '&' + escape(i) + '=' + provider.params[i]; }
    }

    url += 'format=json&url=' + escape(externalUrl) + qs + '&' + callbackparameter + '=?';

    return url;
  }

  function embedCode (container, externalUrl, embedProvider) {
    var requestUrl = getRequestUrl(embedProvider, externalUrl);

    var ajaxopts = $.extend({
      url: requestUrl,
      type: 'get',
      dataType: 'json',
      // error: jsonp request doesnt' support error handling
      success: function (data) {
        var oembedData = $.extend({}, data);
        switch (oembedData.type) {
          case 'photo':
            oembedData.code = $.fn.oembed.getPhotoCode(externalUrl, oembedData);
            break;
          case 'video':
            oembedData.code = $.fn.oembed.getVideoCode(externalUrl, oembedData);
            break;
          case 'rich':
            oembedData.code = $.fn.oembed.getRichCode(externalUrl, oembedData);
            break;
          default:
            oembedData.code = $.fn.oembed.getGenericCode(externalUrl, oembedData);
            break;
        }
        settings.beforeEmbed.call(container, oembedData);
        settings.onEmbed.call(container, oembedData);
        settings.afterEmbed.call(container, oembedData);
      },
      error: settings.onError.call(container, externalUrl, embedProvider)
    }, settings.ajaxOptions || { });

    $.ajax(ajaxopts);
  }

  function initializeProviders () {
    activeProviders = [];

    var defaultProvider; var restrictedProviders = []; var i; var provider;

    if (!isNullOrEmpty(settings.allowedProviders)) {
      for (i = 0; i < $.fn.oembed.providers.length; i++) {
        if ($.inArray($.fn.oembed.providers[i].name, settings.allowedProviders) >= 0) { activeProviders.push($.fn.oembed.providers[i]); }
      }
      // If there are allowed providers, jquery-oembed cannot be greedy
      settings.greedy = false;
    } else {
      activeProviders = $.fn.oembed.providers;
    }

    if (!isNullOrEmpty(settings.disallowedProviders)) {
      for (i = 0; i < activeProviders.length; i++) {
        if ($.inArray(activeProviders[i].name, settings.disallowedProviders) < 0) { restrictedProviders.push(activeProviders[i]); }
      }
      activeProviders = restrictedProviders;
      // If there are allowed providers, jquery-oembed cannot be greedy
      settings.greedy = false;
    }

    if (!isNullOrEmpty(settings.customProviders)) {
      $.each(settings.customProviders, function (n, customProvider) {
        if (customProvider instanceof $.fn.oembed.OEmbedProvider) {
          // ou-specific: Bug fix.
          // activeProviders.push(provider);
          activeProviders.push(customProvider);
        } else {
          provider = new $.fn.oembed.OEmbedProvider();
          if (provider.fromJSON(customProvider)) { activeProviders.push(provider); }
        }
      });
    }

    // If in greedy mode, we add the default provider
    defaultProvider = getDefaultOEmbedProvider(settings.defaultOEmbedProvider);
    if (settings.greedy === true) {
      activeProviders.push(defaultProvider);
    }
    // If any provider has no apiendpoint, we use the default provider endpoint
    for (i = 0; i < activeProviders.length; i++) {
      if (activeProviders[i].apiendpoint == null) { activeProviders[i].apiendpoint = defaultProvider.apiendpoint; }
    }
  }

  function getDefaultOEmbedProvider (defaultOEmbedProvider) {
    var url = 'http://oohembed.com/oohembed/';
    if (defaultOEmbedProvider === 'embed.ly') { url = 'https://api.embed.ly/v1/api/oembed?'; }
    return new $.fn.oembed.OEmbedProvider(defaultOEmbedProvider, null, null, url, 'callback');
  }

  function getNormalizedParams (params) {
    if (params == null) { return null; }
    var key; var normalizedParams = {};
    for (key in params) {
      if (key != null) { normalizedParams[key.toLowerCase()] = params[key]; }
    }
    return normalizedParams;
  }

  function isNullOrEmpty (object) {
    if (typeof object === 'undefined') { return true; }
    if (object == null) { return true; }
    if ($.isArray(object) && object.length === 0) { return true; }
    return false;
  }

  /* Public functions */
  $.fn.oembed.insertCode = function (container, embedMethod, oembedData) {
    if (oembedData == null) { return; }

    switch (embedMethod) {
      case 'auto':
        if (container.attr('href') != null) {
          $.fn.oembed.insertCode(container, 'append', oembedData);
        } else {
          $.fn.oembed.insertCode(container, 'replace', oembedData);
        }
        break;
      case 'replace':
        container.replaceWith(oembedData.code);
        break;
      case 'fill':
        container.html(oembedData.code);
        break;
      case 'append':
        var oembedContainer = container.next();
        if (oembedContainer == null || !oembedContainer.hasClass('oembed-container')) {
          oembedContainer = container
            .after('<div class="oembed-container"></div>')
            .next('.oembed-container');
          if (oembedData != null && oembedData.provider_name != null) { oembedContainer.toggleClass('oembed-container-' + oembedData.provider_name); }
        }
        oembedContainer.html(oembedData.code);
        break;
    }
  };

  $.fn.oembed.getPhotoCode = function (url, oembedData) {
    var code; var alt = oembedData.title ? oembedData.title : '';
    alt += oembedData.author_name ? ' - ' + oembedData.author_name : '';
    alt += oembedData.provider_name ? ' - ' + oembedData.provider_name : '';
    code = '<div><a href="' + url + '" target=\'_blank\'><img src="' + oembedData.url + '" alt="' + alt + '"/></a></div>';
    if (oembedData.html) { code += '<div>' + oembedData.html + '</div>'; }
    return code;
  };

  $.fn.oembed.getVideoCode = function (url, oembedData) {
    var code = oembedData.html;

    return code;
  };

  $.fn.oembed.getRichCode = function (url, oembedData) {
    var code = oembedData.html;
    return code;
  };

  $.fn.oembed.getGenericCode = function (url, oembedData) {
    var title = (oembedData.title != null) ? oembedData.title : url;

    var code = '<a href="' + url + '">' + title + '</a>';
    if (oembedData.html) { code += '<div>' + oembedData.html + '</div>'; }
    return code;
  };

  $.fn.oembed.isProviderAvailable = function (url) {
    var provider = getOEmbedProvider(url);
    return (provider != null);
  };

  $.fn.oembed.getOEmbedProvider = function (url) {
    for (var i = 0; i < activeProviders.length; i++) {
      if (activeProviders[i].matches(url)) { return activeProviders[i]; }
    }
    return null;
  };

  $.fn.oembed.OEmbedProvider = function (name, type, urlschemesarray, apiendpoint, callbackparameter) {
    this.name = name;
    this.type = type; // "photo", "video", "link", "rich", null
    this.urlschemes = getUrlSchemes(urlschemesarray);
    this.apiendpoint = apiendpoint;
    this.callbackparameter = callbackparameter;
    this.maxWidth = 500;
    this.maxHeight = 400;
    var i, property, regExp;

    this.matches = function (externalUrl) {
      for (i = 0; i < this.urlschemes.length; i++) {
        regExp = new RegExp(this.urlschemes[i], 'i');
        if (externalUrl.match(regExp) != null) { return true; }
      }
      return false;
    };

    this.fromJSON = function (json) {
      for (property in json) {
        if (property !== 'urlschemes') { this[property] = json[property]; } else { this[property] = getUrlSchemes(json[property]); }
      }
      return true;
    };

    function getUrlSchemes (urls) {
      if (isNullOrEmpty(urls)) { return ['.']; }
      if ($.isArray(urls)) { return urls; }
      return urls.split(';');
    }
  };

  /* Native & common providers */
  $.fn.oembed.providers = [
    // ou-specific
    /* __PROVIDERS__ */
    // new $.fn.oembed.OEmbedProvider("youtube", "video", ["youtube\\.com/watch.+v=[\\w-]+&?"]), // "https://www.youtube.com/oembed" (no jsonp)
    // ou-specific ends.
    new $.fn.oembed.OEmbedProvider('flickr', 'photo', [ 'flickr\.com\/photos' ], 'https://www.flickr.com/services/oembed', 'jsoncallback'),
    // new $.fn.oembed.OEmbedProvider("flickr", "photo", ["flickr\\.com/photos/[-.\\w@]+/\\d+/?"], "https://flickr.com/services/oembed", "jsoncallback"),
    new $.fn.oembed.OEmbedProvider('viddler', 'video', ['viddler\.com']), // "https://lab.viddler.com/services/oembed/" (no jsonp)
    new $.fn.oembed.OEmbedProvider('blip', 'video', ['blip\\.tv/.+'], 'https://blip.tv/oembed/'),
    new $.fn.oembed.OEmbedProvider('hulu', 'video', ['hulu\\.com/watch/.*'], 'https://www.hulu.com/api/oembed.json'),
    new $.fn.oembed.OEmbedProvider('vimeo', 'video', ['\/\/www\.vimeo\.com\/groups\/.*\/videos\/.*', 'www\.vimeo\.com\/.*', 'vimeo\.com\/groups\/.*\/videos\/.*', 'vimeo\.com\/.*'], 'https://vimeo.com/api/oembed.json'),
    new $.fn.oembed.OEmbedProvider('dailymotion', 'video', ['dailymotion\\.com/.+']), // "https://www.dailymotion.com/api/oembed/" (callback parameter does not return jsonp)
    new $.fn.oembed.OEmbedProvider('scribd', 'rich', ['scribd\\.com/.+']), // ", "https://www.scribd.com/services/oembed"" (no jsonp)
    // ou-specific - 1 line, V2 api.
    new $.fn.oembed.OEmbedProvider('slideshare', 'rich', ['slideshare\.net'], 'https://www.slideshare.net/api/oembed/2'),
    new $.fn.oembed.OEmbedProvider('photobucket', 'photo', ['photobucket\\.com/(albums|groups)/.*'], 'https://api.photobucket.com/oembed/')
    // new $.fn.oembed.OEmbedProvider("vids.myspace.com", "video", ["vids\.myspace\.com"]), // "https://vids.myspace.com/index.cfm?fuseaction=oembed" (not working)
    // new $.fn.oembed.OEmbedProvider("screenr", "rich", ["screenr\.com"], "https://screenr.com/api/oembed.json") (error)
    // new $.fn.oembed.OEmbedProvider("qik", "video", ["qik\\.com/\\w+"], "https://qik.com/api/oembed.json"),
    // new $.fn.oembed.OEmbedProvider("revision3", "video", ["revision3\.com"], "https://revision3.com/api/oembed/")
  ];
})(window.jQuery);
