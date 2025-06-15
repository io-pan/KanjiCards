/**
 * @file
 * Global utilities.
 *
 */
(function (Drupal, drupalSettings, once) {

  Drupal.behaviors.fixLayout = {
    attach(context) {


      const traitsDeCoupe = once('settraitsDeCoupe', '.view-content > .item-list > ul', context);
      traitsDeCoupe.forEach(setTraitsDeCoupe);


      // Set printer margins to all recto.
      const container = once('fixLayout', '.view-display-id-page_recto', context);
      container.forEach(setMainMargin);

      const containerS = once('fixLayout', '.view-display-id-verso_att', context);
      containerS.forEach(setPageBreak);

      const attachements = once('fixLayout2', '.view-display-id-verso_att', context);
      attachements.forEach(setVersoPos);
    }
  };


  function setTraitsDeCoupe(domitem, index) {
    console.log('traitsDeCoupe');

    document.documentElement.style.setProperty('--traitCoupe', drupalSettings['printSettings']['traitCoupe']+'mm');

    // on laisse la pace aux traits de coupe.
    domitem.style.padding = drupalSettings['printSettings']['traitCoupe']+'mm';

    let   itemlist = domitem.querySelectorAll(':scope > li > article.teaser');
    const pH =  drupalSettings['printSettings']['pageH']
                - drupalSettings['printSettings']['marginT']
                - drupalSettings['printSettings']['marginB']
                - 2*drupalSettings['printSettings']['traitCoupe'],
          pW =  drupalSettings['printSettings']['pageW']
                - 2*drupalSettings['printSettings']['marginW']
                - 2*drupalSettings['printSettings']['traitCoupe'],
          cH =  drupalSettings['printSettings']['cardLandscape']
                ? drupalSettings['printSettings']['cardW']
                : drupalSettings['printSettings']['cardH'], // mm
          cW =  drupalSettings['printSettings']['cardLandscape']
                ? drupalSettings['printSettings']['cardH']
                : drupalSettings['printSettings']['cardW'], // mm

          cardsPerCol = Math.floor(pH / cH),
          cardsPerRow = Math.floor(pW / cW),
          cardsPerPage = cardsPerRow * cardsPerCol,
          remainder = itemlist.length % cardsPerPage,
          missingCards = remainder === 0 ? 0 : cardsPerPage - remainder;
  

    // console.log('itemlist',itemlist);
    // console.log('cardsPerCol',cardsPerCol);
    // console.log('cardsPerRow',cardsPerRow);
 
    // On duplique la dernière carte pour remplir la grille.
    // Sinon on a pas les traits de coupe.
    let li, article;
    for (let imiss = 0; imiss < missingCards; imiss++) {
      li = document.createElement("li");
      article = itemlist[itemlist.length-1].cloneNode(true);
      li.appendChild(article);
      domitem.appendChild(li);
    }
    // On récupère le dom modifié.
    itemlist = domitem.querySelectorAll(':scope > li > article.teaser');
   
    // Insertion des traits de coupe.
    for (let i = 0; i < itemlist.length; i++) {
      const page = Math.floor(i / cardsPerPage),
            positionInPage = i % cardsPerPage,
            row = Math.floor(positionInPage / cardsPerRow) + 1,
            col = (positionInPage % cardsPerRow) + 1;
      // console.log(`Carte ${i + 1}: page ${page + 1}, ligne ${row}, colonne ${col}`);

      // les coins
      if(row==1 && col==1) {
        let div = document.createElement("div");
        div.classList.add('coupe', 'TopLeft');
        itemlist[i].appendChild(div);
       // console.log(`Carte ${i + 1}: page ${page + 1}, ligne ${row}, colonne ${col}`);
      }
      if(row==1 && col==cardsPerRow) {
        let div = document.createElement("div");
        div.classList.add('coupe', 'TopRight');
        itemlist[i].appendChild(div);
       // console.log(`Carte ${i + 1}: page ${page + 1}, ligne ${row}, colonne ${col}`);
      }
      if(row==cardsPerCol && col==1) {
        let div = document.createElement("div");
        div.classList.add('coupe', 'BottomLeft');
        itemlist[i].appendChild(div);
      }
      if(row==cardsPerCol && col==cardsPerRow) {
        let div = document.createElement("div");
        div.classList.add('coupe', 'BottomRight');
        itemlist[i].appendChild(div);
      }

//.. dernier si pas ?
      // horizontaux
      if(i%2==0 && row==1) {
        let div = document.createElement("div");
        div.classList.add('coupe','top');
        itemlist[i].appendChild(div);
      }
      if(i%2==0 && row==cardsPerCol) {
        let div = document.createElement("div");
        div.classList.add('coupe','bottom');
        itemlist[i].appendChild(div);
      }


      // verticaux
      if(col==1 && row%2==0) {
        let div = document.createElement("div");
        div.classList.add('coupe','left');
        itemlist[i].appendChild(div);
      }
      if(col==cardsPerRow && row%2==0) {
        let div = document.createElement("div");
        div.classList.add('coupe','right');
        itemlist[i].appendChild(div);
      }

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
          cH =  drupalSettings['printSettings']['cardLandscape']
                ? drupalSettings['printSettings']['cardW']
                : drupalSettings['printSettings']['cardH'], // mm
          cW =  drupalSettings['printSettings']['cardLandscape']
                ? drupalSettings['printSettings']['cardH']
                : drupalSettings['printSettings']['cardW']; // mm

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

