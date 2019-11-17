// This JS file supports Tutorial Comments using Javascripts (Ajax) XMLHttp method,
// not the Jquery Method (which you will find is used by the speed trainer in trainer.js)

oReq = new XMLHttpRequest(); // Instantiate the Http Request Handler

 function setComments(prTxt)
 { // Updates the comments display and clears the comment text box user typed a new comments into
    var aDiv = document.getElementById("comments");
    aDiv.innerHTML = prTxt;
    var aDiv2 = document.getElementById("commentField");
    aDiv2.value = "";
 }

 function handler()
 { // Method to be called when a http request is completed, to process the response accordingly
    if(oReq.readyState == 4)
    {
        if(oReq.status == 200) //200 means the response was ok, where as 404 for example would imply an error
        {
         setComments(oReq.responseText); // pass the response onto the method that will update the display
        }
    }
 }

 function send(prValue)
 { // Method that is used when person clicks to send comment, sets up the http request and sends the comment value through the MVC
    if(oReq)
    {
        oReq.open("POST","?ctr=TutorialController&cmd=send",true);
        oReq.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        oReq.onreadystatechange = handler;
        oReq.send("comment="+prValue); // Post data is placed inside send(), while if I used GET, I would append this data with the URL
    }
 }