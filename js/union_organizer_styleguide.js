/**
 * Enhancements for the basic union styleguide.
 */
(function (window, document, location) {
  var openDetails = function() {
    var hash = location.hash.substring(1);
    if (hash) {
      var details = document.getElementById(hash);
    }
    if (details && details.tagName.toLowerCase() === 'details') {
      details.open = true;
    }
  };
  window.addEventListener('hashchange', openDetails);
  window.addEventListener('load', openDetails);
  window.addEventListener('DOMContentLoaded', function() {
    var elements = document.getElementsByTagName('summary');
    for (i = 0; i < elements.length; i++) {
      elements[i].addEventListener('click', function(e) {
        if (e.target.parentNode.open) {
          history.replaceState({}, document.title, location.pathname + location.search);
        }
        else {
          location.hash = e.target.parentNode.id;
        }
      });
    }
  });
}(window, document, location));
