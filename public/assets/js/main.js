document.addEventListener("DOMContentLoaded", function() {
   
    let header = document.getElementsByTagName('header')[0];
    let content_nav_bar = document.querySelector('div.nav-bar');
    let buttom_submit_contact = document.querySelector('form[name="contact"] button[type="submit"]');

    let search = document.querySelector('input[name="search"]');
    let contenuAjax = document.getElementById('testAjax');
    
    if(document.location.href.substring(document.location.href.lastIndexOf("/")+1) == "list_user")
    {
       
    }

    if(document.location.href.substring(document.location.href.lastIndexOf('/')+1) == "" || document.location.href.substring(document.location.href.lastIndexOf('/')+1) == "#formulaire")
    {

        navScroll();
    

        document.addEventListener('scroll',()=> {

            navScroll();

            // console.log($('header nav li a'));
            // console.log('nav a ciblé : ' + $('headre nav a').eq(3));


            let cible = ""

            setTimeout(lien_actif_au_scroll, 800);
            //lien_actif_au_scroll();

            function lien_actif_au_scroll()
            {
                if(pageYOffset + innerHeight > document.getElementsByTagName('footer')[0].offsetTop +100)
                {
                    cible = 3;
                // cible = $('headre nav a').eq(3);
                    console.log('coco 3');
                    return;
                }
                if(pageYOffset > innerHeight -150)
                {
                    cible = 2;
                // cible = $('header nav a').eq(2);
                    console.log('coco 2');
                    return;
                }
                
                cible = 1;
                    //cible = $('headre nav a').eq(1);
                    console.log('coco 1');
                    return;

            }

            setTimeout(function() {

                $('header nav li a').eq(cible).addClass('active');
                $('header nav li a').eq(cible).parent().siblings().children().each(function() {
                    $(this).removeClass('active');
                });

            }, 820);




        });
    }

    window.addEventListener('resize', re_initialize);
    window.addEventListener('orientationchange', re_initialize);



    /* TEST D ECRITURE POUR ESSAYER DE SE BRANCHER SUR UNE FEUILLE DE STYLE PATICULIERE LORSQU ON CLIQUE SUR LE BOUTTON SUBMIT, MAIS CA NE FONCTIONNE PAS !

        if( document.location.href.substring(document.location.href.lastIndexOf('/')+1) == "" )
        {
            buttom_submit_contact.addEventListener('click',function(e) {        // console.log("attribute : " + document.styleSheets[9].getAttribute("href") );


                for (var i=0; i<document.styleSheets.length; i++) {
                    var sheet = document.styleSheets[i];
                    if (sheet.title == "transit") {
                    sheet = document.styleSheets[i];
                    }
                }
                sheet.disabled = false;
                alert( sheet.disabled);
                    // var root = document.getElementsByTagName( 'html' )[0];
                    // root.classList.add("sans-smooth");
                // sheet.removeAttribute('disabled');
            

                    setTimeout(function() {
                        console.log('j attens un instant');
                    }, 15000);

                    // document.styleSheets[9].insertRule( 'html { scroll-behavior: ""; }', document.styleSheets[9].cssRules.length);

                    // document.styleSheets[9].insertRule( 'body { background: green; }', document.styleSheets[9].cssRules.length);
                    
                    // console.log(document.styleSheets[9].CSSRules);
                    document.styleSheets.title = "transit";
                    
                    // alert(document.styleSheets[9]);
                


            });

        }
     */  // FIN DU TEST POUR LA TENTAIVE DE BRANCHEMENT SUR UNE FEUILLE DE STYLE
    
    let tab_url_caroussel = [                               
                                "../assets/img/bonne_mere.jpg",
                                "../assets/img/mucem.webp",                       
                                "../assets/img/major_generale.webp",
                                "../assets/img/calanque.webp",
                                "../assets/img/parc_longchamp.jpg",
                              ];

    
    let contenu_h1_header = [
                            "location de véhicule avec chauffeur",
                            "toutes distances sur Marseille",
                            "toutes distances en region PACA",
                            "pour des trajets ponctuels ou réguliers",
                            "professionnel ou particulier"
                            ];



        let list_item_caroussel = '';

        //  On construit autant d'élément html que d'image dans le tableau
        for( let i = 0; i < tab_url_caroussel.length; i++)
        {
            list_item_caroussel += '<section class="header" style="opacity:0;"><aside style="background:url(\''+tab_url_caroussel[i]+'\') no-repeat center;background-size:cover"></aside></section>';
        }

        header.innerHTML = list_item_caroussel;
        header.appendChild(content_nav_bar);

        for(let i = 0; i < contenu_h1_header.length; i++)
        {
            let h1 = document.createElement('h1');
            h1.innerText = contenu_h1_header[i];
            header.appendChild(h1);

        }

        let h1 = document.querySelectorAll('header h1');
        
        for(let i = 0; i < h1.length; i++)
        {
            h1[i].style.top = innerHeight*0.25+"px";
        }

        let p = document.createElement('p');
        let a = document.createElement('a');
        a.setAttribute('href', '#footer');
        a.innerText = "contact";
        p.appendChild(a);
        header.appendChild(p);
        p.style.bottom = innerHeight*0.2+"px";
       // p.style.bottom = "0px";
       
        

       //   Calcul la position H1 dans le header, ainsi que la position du bouton "contact"
        function re_initialize()
        {
            //console.log('innerHeight :' + innerHeight+' bottom px :'+innerHeight*0.1);
            p.style.bottom = innerHeight*0.2+"px";

            for(let i = 0; i < h1.length; i++)
            {
                h1[i].style.top = innerHeight*0.2+"px";
            }
        }

       

        var index_max_caroussel = tab_url_caroussel.length;
        var index_caroussel = -1;

        // 
        next();
        var caroussel_Interval = setInterval( next, 5000);

        function next() 
        {
            index_caroussel ++;

            if(index_caroussel >= index_max_caroussel)
            {
                index_caroussel = 0;
            }

            // 
            let h1 = $('header h1').eq(index_caroussel);
            let section_Header = $('section.header').eq(index_caroussel);
            
            section_Header.css("opacity", 1).siblings('.header').each(function() {
                $(this).css('opacity', 0);

            });

           h1.css("opacity", 1).siblings('h1').each(function() {
                $(this).css('opacity', 0);

            });

            
            p.style.opacity = 0;
           
            setTimeout(function() {

                p.style.display = "none"
                p.style.transform = "translateY(70px)";
                p.style.display = "inline-block";
                
            }, 1000); 
            
            
            setTimeout(function () {
                p.style.opacity = 1;
                p.style.transform = "translateY(0px)";
            }, 1900);

            
        }



        //  Détecte l'élément cliqué et lui ajoute la class "active", on enlève la class "active aux autre lien frère "
        $('header nav a').click(function() {

            $(this).addClass('active');
            $(this).parent().siblings().children().each(function() {
                $(this).removeClass('active');
            })

        });

        
        

});