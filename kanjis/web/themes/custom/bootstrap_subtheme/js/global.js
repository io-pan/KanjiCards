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

      const traitsDeCoupe = once('settraitsDeCoupe', '.view-content > .item-list > ul', context);
      traitsDeCoupe.forEach(setTraitsDeCoupe);
    }
  };


  function setTraitsDeCoupe(domitem, index) {
    console.log('traitsDeCoupe');

    document.documentElement.style.setProperty('--traitCoupe', drupalSettings['printSettings']['traitCoupe']+'mm');

    // on laisse la pace aux traits de coupe.
    domitem.style.padding = drupalSettings['printSettings']['traitCoupe']+'mm';

    const pH =  drupalSettings['printSettings']['pageH']
          - drupalSettings['printSettings']['marginT']
          - drupalSettings['printSettings']['marginB']
          - 2*drupalSettings['printSettings']['traitCoupe'],
      pW =  drupalSettings['printSettings']['pageW']
          - 2*drupalSettings['printSettings']['marginW']
          - 2*drupalSettings['printSettings']['traitCoupe'],
      cH =  drupalSettings['printSettings']['cardH'], // mm
      cW =  drupalSettings['printSettings']['cardW']; // mm

    cardsPerCol = Math.floor(pH / cH);
    cardsPerRow = Math.floor(pW / cW);
 
    // scan cards and select 1st/last row, 1st/last column of page.
    curcol=0;
    currow=0;
    itemlist = domitem.querySelectorAll(':scope > li > article.teaser');
    for (var i = 0; i < itemlist.length; i++) {

      if(i%(cardsPerRow*cardsPerCol)==0){
        curcol=0;
        currow=0;
      }
      if(i%cardsPerCol==0){
        curcol=0;
      }
      curcol++;
      if(i%cardsPerRow==0){
        currow++;
      }  

      // les coins
      if(currow==1 && curcol==1) {
        let div = document.createElement("div");
        div.classList.add('coupe', 'TopLeft');
        itemlist[i].appendChild(div);
      }
      if(currow==1 && curcol==cardsPerCol) {
        let div = document.createElement("div");
        div.classList.add('coupe', 'TopRight');
        itemlist[i].appendChild(div);
      }
      if(currow==cardsPerRow && curcol==1) {
        let div = document.createElement("div");
        div.classList.add('coupe', 'BottomLeft');
        itemlist[i].appendChild(div);
      }
      if(currow==cardsPerRow && curcol==cardsPerCol) {
        let div = document.createElement("div");
        div.classList.add('coupe', 'BottomRight');
        itemlist[i].appendChild(div);
      }



      // horizontaux
      if(i%2==0 && currow==1) {
        let div = document.createElement("div");
        div.classList.add('coupe','top');
        itemlist[i].appendChild(div);
      }
      if(i%2==0 && currow==cardsPerRow) {
        let div = document.createElement("div");
        div.classList.add('coupe','bottom');
        itemlist[i].appendChild(div);
      }


      // verticaux
      if(curcol==1 && currow%2==0) {
        let div = document.createElement("div");
        div.classList.add('coupe','left');
        itemlist[i].appendChild(div);
      }
      if(curcol==cardsPerCol && currow%2==0) {
        let div = document.createElement("div");
        div.classList.add('coupe','right');
        itemlist[i].appendChild(div);
      }

      // console.log('curcol row', i+ ' : '+curcol +  ' - ' +currow);
    }
 
  }

  function setMainMargin(domitem, index) {
    console.log('setMainMargin',drupalSettings['printSettings']);
    // Set padding
    domitem.style.paddingTop    = drupalSettings['printSettings']['marginT']+'mm';
    domitem.style.paddingBottom = 1*drupalSettings['printSettings']['marginB']
                                +(1*drupalSettings['printSettings']['pageH'])+'mm';
    domitem.style.paddingRight  = drupalSettings['printSettings']['marginW']+'mm';
    domitem.style.paddingLeft   = drupalSettings['printSettings']['marginW']+'mm';

 
    setPageBreak(domitem, index);
  }


  function setPageBreak(domitem, index) {
    console.log('setPageBreak', drupalSettings['printSettings']);

    // Add page-break after each last card on page.
    const pH =  drupalSettings['printSettings']['pageH']
              - drupalSettings['printSettings']['marginT']
              - drupalSettings['printSettings']['marginB']
              - 2*drupalSettings['printSettings']['traitCoupe'],
          pW =  drupalSettings['printSettings']['pageW']
              - 2*drupalSettings['printSettings']['marginW']
              - 2*drupalSettings['printSettings']['traitCoupe'],
          cH =  drupalSettings['printSettings']['cardH'], // mm
          cW =  drupalSettings['printSettings']['cardW']; // mm

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
      itemlist[i].style.marginTop = ((1*drupalSettings['printSettings']['marginT'])
                                    +(1*drupalSettings['printSettings']['pageH'])
                                    +(1*drupalSettings['printSettings']['traitCoupe'])) +"mm";
    }
    // add last page break ... not needed.
     let div = document.createElement("div");
     div.classList.add("breakpage");
     itemlist[itemlist.length-1].after(div);
  }

  function setVersoPos(domitem, index) {
    console.log('setVersoPos',drupalSettings['printSettings']);
    const 
      pW =  drupalSettings['printSettings']['pageW']
          - 2*drupalSettings['printSettings']['marginW'],

      top =   1*drupalSettings['printSettings']['pageH'] 
            + 1*drupalSettings['printSettings']['marginT']
            + 1*drupalSettings['printSettings']['versoOffsetY']
            + 'mm',

      // Verso est flippé avec un bête style direction: rtl;
      // mais faut de toue façon  inverser la marge ...
      // les marges gauche/droite de l'imprimante étant fixes
      // on doit prendre la max pour les 2 cotés.
      margeVerso =  1*drupalSettings['printSettings']['marginW']
                  + 1*drupalSettings['printSettings']['versoOffsetX']
                  +'mm';

    console.log('top, width, margeVerso:',top+ ", " +pW+', '+margeVerso);
    domitem.style.top   = top;
    domitem.style.width = pW+'mm';
    domitem.style.left  = margeVerso;
  }
    
}(Drupal, drupalSettings, once));

