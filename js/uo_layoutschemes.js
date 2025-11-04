// The Union Organizer layoutscheme switcher script.
(function (window, document) {

  let layoutschemes = [
    '',
    'reversed'
  ];

  let currentLayoutscheme = '';

  let setLayoutScheme = function(layoutscheme) {
    let components = document.querySelectorAll('*[data-component]');

    components.forEach((component) => {
      layoutschemes.forEach((layoutscheme_opt) => {
        component.classList.remove('cu-layoutscheme--' + layoutscheme_opt);
      });

      if (layoutscheme) {
        component.classList.add('cu-layoutscheme--' + layoutscheme);
      }
    });

    currentLayoutscheme = layoutscheme;
  };

  document.addEventListener('DOMContentLoaded', (event) => {
    const layoutscehemeswitcher_el = document.createElement('ul');
    layoutscehemeswitcher_el.classList.add('uo-layoutscehemeswitcher');

    layoutschemes.forEach((layoutscheme) => {
      if (layoutscheme) {
        let layoutscheme_el = document.createElement('li');
        layoutscheme_el.dataset.layoutscheme = layoutscheme;
        layoutscheme_el.classList.add('uo-layoutscehemeswitcher--scheme');
        layoutscheme_el.textContent = layoutscheme;
        layoutscehemeswitcher_el.append(layoutscheme_el);
      }
    });

    layoutscehemeswitcher_el.addEventListener('click', (event) => {
      let target = event.target;

      if (target.dataset.layoutscheme === currentLayoutscheme) {
        setLayoutScheme('');
        target.classList.remove('active');
      }
      else {
        setLayoutScheme(target.dataset.layoutscheme);
        target.classList.add('active');
      }
    });

    document.querySelector('body').append(layoutscehemeswitcher_el);
  });

})(window, document);
