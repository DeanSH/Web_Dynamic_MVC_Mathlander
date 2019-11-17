// This JS script handles the animation of the competition star seen on the home page, 
// making it bounce up, down and side to side, in and out of the screen from left to right,
// always aiming towards a random point on the web page, design this myself.

var lcTop = '0%';
var lcLeft = '0%';
var lcRandpos = (Math.random() * 100) + '%';

function animate_star() {
    lcRandpos = (Math.random() * 100) + '%';

    if (lcLeft == "-15%")
    {
        lcTop = "0%";
        lcLeft = lcRandpos;
    }
    else if (lcTop == "0%")
    {
        lcTop = lcRandpos;
        lcLeft = "115%";
    }
    else if (lcLeft == "115%")
    {
        lcTop = "80%";
        lcLeft = lcRandpos;
    }
    else
    {
        lcTop = lcRandpos;
        lcLeft = "-15%";
    }

    $('#bouncing-star').animate({top: lcTop, left: lcLeft}, 5000, "swing", animate_star);
}
                        
animate_star();