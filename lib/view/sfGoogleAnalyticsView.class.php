<?php

class sfGoogleAnalyticsView extends sfPHPView
{
  /**
   * Loop through all template slots and fill them in with the results of presentation data.
   *
   * @param  string $content  A chunk of decorator content
   *
   * @return string A decorated template
   */
  protected function decorate($content)
  {
    // Load google analytics tracking code
    die(sfConfig::get('app_sf_cms_google_analytics'));
    return !sfConfig::get('app_sf_cms_google_analytics') ? parent::decorate($content) : parent::decorate($content).sprintf(<<<EOF
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '%s']);
  _gaq.push(['_setDomainName', '%s']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
EOF
            , sfConfig::get('app_sf_cms_google_analytics'), @$_SERVER['SERVER_NAME']);
  }
}