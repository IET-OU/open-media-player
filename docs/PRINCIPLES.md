# Open Media Player principles

In order to continue to develop the best possible Media Player for [The Open University][], we lay down some guiding principles, and notes on how the current player seeks to meet those principles.

The [Open Media Player][] should:

1. Attain and exceed the highest standards for accessibility to those with disabilities.

    The current solution does this through:
    * Use of [the OU], [WCAG 2.0] and [WAI-ARIA] standards and guidelines (W3C),
    * User and expert testing by [IET] of early prototypes for new functionality, and of the Player, with time planned in to implement fixes;
    * [HTML5] player based on the third-party, open-source [MediaElement.js] libraries, with Javascript plugins to replace and extend functionality;

2. Be usable by the mainstream as well as those with disabilities;

    The current solution does this through:
    * User and expert testing by [IET] of early prototypes for new functionality, and of the Player, with time planned in to implement fixes;

3. Represent the OU appropriately. Carry the correct branding.

    The current solution does this through:
    * LTS designs visual theme(s) for the Player that are both accessible and usable, and that fit in with The Open University's overall [brand] and [values];

4. Be usable on mobiles and tablets.

    The current solution does this through:
    * HTML5 player based on MediaElement.js;

5. Be simple for authors to embed the Player in content;

    The current solution does this through:
    * Use of the [oEmbed] specification;

6. Be embeddable in a variety of platforms, (both OU-branded -- OU VLE, [OpenLearn], Study at OU, OU Drupal etc, and non-OU branded sites);

    The current solution does this through:
    * Use of a service-based approach;
    * Use of platform-specific plugins, for example, the oEmbed plugin for Drupal;

7. Be simple to deploy new features.

    The current solution does this through:
    * Platform specific themes and an update process which conforms to [IT] change request process.
    * Issues and changes logged and tracked via LTS Redmine

8. Track usage patterns, to help improve the Player and inform other University activity.

    The current implementation:
    * Use of Google Analytics for the [Podcast] Player variant;
    * Tracking of play, pause and completion events;
    * Planned: add a feedback form.

---
Source: [OUMPSG-6-1 OU-Media-player-principles-Jan-2014.docx], by Nick Freear & Will Woods, 15 January 2014.

[The Open University]: http://www.open.ac.uk/
[Open Media Player]: http://mediaplayer.open.ac.uk/
[OUMPSG-6-1 OU-Media-player-principles-Jan-2014.docx]: https://docs.google.com/document/d/1LAdmCS4FtyNBAUQOI8wjfohi01z8pVsXS6cRAdNrUfQ/edit#
[gist]: https://gist.github.com/nfreear/db9048dcb7cd666b07df
[the OU]: http://www.open.ac.uk/about/web-standards/standards/accessibility "Open University accessibility standard"
[brand]: http://www.open.ac.uk/about/web-standards/standards/design-standards/brand-guidelines "Open University brand"
[values]: http://www.open.ac.uk/about/main/mission "Open University mission"
[OpenLearn]: http://www.open.edu/openlearn/
[Podcast]: http://podcast.open.ac.uk/
[IET]: http://iet.open.ac.uk/ "Institute of Educational Technology"
[IT]: http://www.open.ac.uk/ "Open University central IT"

[WCAG 2.0]: http://w3.org/TR/WCAG20 "Web Content Accessibility Guidelines (WCAG) 2.0, W3C Recommendation 11 December 2008"
[WAI-ARIA]: http://w3.org/TR/wai-aria "Accessible Rich Internet Applications (WAI-ARIA) 1.0, W3C Recommendation 20 March 2014"
[HTML5]: http://w3.org/TR/html5 "W3C Recommendation 28 October 2014 (also WHATWG)"
[oEmbed]: http://oembed.com/
[MediaElement.js]: http://mediaelementjs.com/
