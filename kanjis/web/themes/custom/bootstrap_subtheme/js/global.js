/**
 * @file
 * Global utilities.
 *
 */
(function (Drupal, drupalSettings, once) {

  Drupal.behaviors.fixLayout = {
    attach(context) {
      // Set printer margins to all recto.
      const container = once('fixLayout', '.view-display-id-page_recto', context);
      container.forEach(setMainMargin);

      const containerS = once('fixLayout', '.view-display-id-verso_att', context);
      containerS.forEach(setPageBreak);

      const attachements = once('fixLayout2', '.view-display-id-verso_att', context);
      attachements.forEach(setVersoPos);
    }
  };


  function setMainMargin(domitem, index) {
    console.log('setMainMargin',drupalSettings['printSettings']);
    // Set padding
    domitem.style.paddingTop    = drupalSettings['printSettings']['marginT']+'mm';
    domitem.style.paddingBottom = 1*drupalSettings['printSettings']['marginB']
                                +(1*297)+'mm';
    domitem.style.paddingRight  = drupalSettings['printSettings']['marginW']+'mm';
    domitem.style.paddingLeft   = drupalSettings['printSettings']['marginW']+'mm';

 
    setPageBreak(domitem, index);
  }


  function setPageBreak(domitem, index) {
    console.log('setPageBreak', drupalSettings['printSettings']);

    // Add page-break after each last card on page.
    const pH =  297
              - drupalSettings['printSettings']['marginT']
              - drupalSettings['printSettings']['marginB'],
          pW =  210
              - 2*drupalSettings['printSettings']['marginW'],
          cH =  60, // mm
          cW =  35; // mm

    cardsPerCol = Math.floor(pH / cH);
    cardsPerRow = Math.floor(pW / cW);
    cardsPerPage = cardsPerCol * cardsPerRow;
        console.log('cardsPerCol',cardsPerCol);
        console.log('cardsPerRow',cardsPerRow);
        console.log('cardsPerPage',cardsPerPage);

    itemlist = domitem.querySelectorAll(':scope > .view-content > .item-list > ul > li');
    console.log('itemlist:', itemlist);
    for (var i = cardsPerPage; i < itemlist.length; i+=cardsPerPage) {
      let div = document.createElement("div");
      div.classList.add("breakpage");
      itemlist[i-1].after(div);

      // give it a margin top to reach next page + let place for verso
      // const spac = ( 297 - drupalSettings['printSettings']['marginT'] - (cH*cardsPerCol)
      // Page break does the stuff ... give only space for verso   
      itemlist[i].style.marginTop = 1*drupalSettings['printSettings']['marginT']
                                    +297 +"mm";
    }
    // add last page break ... not needed.
    // let div = document.createElement("div");
    // div.classList.add("breakpage");
    // itemlist[itemlist.length-1].after(div);
  }

  function setVersoPos(domitem, index) {
    console.log('setVersoPos',drupalSettings['printSettings']);
    const pH =  297
              - drupalSettings['printSettings']['marginT']
              - drupalSettings['printSettings']['marginB'],
          pW = 210
              - 2*drupalSettings['printSettings']['marginW'],
          cH =  60, // mm
          cW =  35; // mm

    cardsPerCol = Math.floor(pH / cH);
    cardsPerRow = Math.floor(pW / cW);

    const top =  297 
                + 1*drupalSettings['printSettings']['marginT']
                + 1*drupalSettings['printSettings']['versoOffsetY']
                +'mm',
          width = cardsPerRow*cW+'mm';
          // Verso est flippé avec un bête style direction: rtl;
          // mais faut de toue façon  inverser la marge ...
          // les marges gauche/droite de l'imprimante étant fixes
          // on doit prendre la max pour les 2 cotés.
          margeVerso =  210
                      - 1*drupalSettings['printSettings']['marginW']
                      - 1*drupalSettings['printSettings']['versoOffsetX']
                      - cardsPerRow*cW
                      +'mm';

    console.log('top, width, margeVerso:',top+ ", "+width+", "+margeVerso);
    domitem.style.top = top;
    domitem.style.width = width;
    domitem.style.left = margeVerso;
  }
    
}(Drupal, drupalSettings, once));

