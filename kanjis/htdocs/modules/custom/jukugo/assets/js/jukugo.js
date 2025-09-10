/**
 * @file
 * Global utilities.
 *
 */
(function (Drupal, drupalSettings, once) {
  alert();
  Drupal.behaviors.jukugoColorLectures = {
    attach(context, settings) {
      once('jukugo-color-lectures', '.field--name-field-lecture ', context).forEach(function (el) {
        const text = el.textContent;

        if (/[\u3040-\u309F]/.test(text)) {
          el.classList.add('hiragana');
        } else if (/[\u30A0-\u30FF]/.test(text)) {
          el.classList.add('katakana');
        }
      });
    }
  };

  function hiraganaToKatakana(str) {
  return str.replace(/[\u3041-\u3096]/g, function(ch) {
    return String.fromCharCode(ch.charCodeAt(0) + 0x60);
  });
}

})(Drupal, drupalSettings, once);