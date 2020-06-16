'use strict'



    let logo_nav_bar = document.querySelector('div.nav-bar img'); 

    var root = document.getElementsByTagName( 'html' )[0];
        


    function navScroll()
    {

        setTimeout(function() {

            if(pageYOffset > 10)
            {
                //document.getElementsByTagName('nav')[0].style.height = 70 + "px";
                document.querySelector('div.nav-bar').classList.add('scrollTop200');
    
                document.querySelector("nav a.logo").classList.add('scrollTop200');

                document.querySelector('div.nav-bar ul').style.paddingBottom =  0;
    
                logo_nav_bar.classList.add('scrollTop200');  

                // root.classList.add("sans-smooth");

                return;
            }
    
                document.querySelector('div.nav-bar').classList.remove('scrollTop200');
    
                logo_nav_bar.classList.remove('scrollTop200'); 
    
                document.querySelector("nav a.logo").classList.remove('scrollTop200');

                document.querySelector('div.nav-bar ul').style.paddingBottom =  " 35px";
        }, 200);

                    
    }




