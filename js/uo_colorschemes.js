// The Union Organizer colorscheme switcher script.
(function (window, document) {

  let colorschemes = [
    '',
    'light',
    'dark',
    'vibrant'
  ];

  let currentColorscheme = '';

  let setColorScheme = function(colorcheme) {
    let components = document.querySelectorAll('*[data-component]');

    components.forEach((component) => {
      colorschemes.forEach((colorcheme_opt) => {
        component.classList.remove('cu-colorscheme--' + colorcheme_opt);
      });

      if (colorcheme) {
        component.classList.add('cu-colorscheme--' + colorcheme);
      }
    });

    currentColorscheme = colorcheme;
  };

  let cycleColorscheme = function() {
    const currentColorschemeIndex = colorschemes.indexOf(currentColorscheme);
    const nextColorschemeIndex = (currentColorschemeIndex + 1) % colorschemes.length;
    setColorScheme(colorschemes[nextColorschemeIndex]);
  };

  document.addEventListener('keydown', (event) => {
    if (event.ctrlKey && event.key === 'c') {
      cycleColorscheme();
    }
  });

  document.addEventListener('DOMContentLoaded', (event) => {
    const colorswitcher_el = document.createElement('ul');
    colorswitcher_el.classList.add('uo-colorswitcher');

    colorschemes.forEach((colorcheme) => {
      if (colorcheme) {
        let colorscheme_el = document.createElement('li');
        colorscheme_el.dataset.colorscheme = colorcheme;
        colorscheme_el.classList.add('uo-colorswitcher--scheme');
        colorscheme_el.textContent = colorcheme;
        colorswitcher_el.append(colorscheme_el);
      }
    });

    colorswitcher_el.addEventListener('click', (event) => {
      let target = event.target;

      if (target.dataset.colorscheme === currentColorscheme) {
        setColorScheme('');
      }
      else {
        setColorScheme(target.dataset.colorscheme);
      }
    });

    document.querySelector('body').append(colorswitcher_el);
  });

})(window, document);
