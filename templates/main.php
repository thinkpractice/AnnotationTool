<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  
  <title>Annotation Tool</title>
  <style>
  fieldset {
    margin-bottom: 1em;
  }
  input {
    display: block;
    margin-bottom: .25em;
  }
  #print-output {
    width: 100%;
  }
  .print-output-line {
    white-space: pre;
    padding: 5px;
    font-family: monaco, monospace;
    font-size: .7em;
  }
  </style>  
</head>
<body>   
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
      AnnotationTool
    </a>
  </nav>
  <div class="container-fluid"> 
    <div class="row justify-content-center">
      <div class="col-3 m-5">
            <div id="imageCarousel" data-interval="false" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                
              </div>
              <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card-deck">
           
        </div>
      </div>    
    </div>
  </div>

  <!-- JavaScript libraries needed-->
  <script  src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="https://api.jquery.com/resources/events.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 
  <script>
  var xTriggered = 0;
  $(document).keypress(function( event ) {
    if ( event.which == 13 ) {
      event.preventDefault();
    }
    else if (event.which == 38) {
      $('.imageCarousel').carousel("next")
    }
    else if (event.which == 37) {
      $('.imageCarousel').carousel("prev")
    }

    //37: left, 39: right, 38: up, 40: down, 13: enter, 8: backspace
    /*xTriggered++;
    var msg = "Handler for .keypress() called " + xTriggered + " time(s).";
    $.print( msg, "html" );
    $.print( event );*/
  });

  function cardFromJson(item, active, darkBorder)
  {
        var borderColor = darkBorder ? "border-dark" : "border-light";
        return `<div class="card ${borderColor}">
                    <img class="card-img-top" src="${item.image_url}">
                    <div class="card-footer ${item.color} ${item.textstyle}">
                        ${item.label}
                    </div>
                </div>`
  }

  function carouselItemFromJson(item, active)
  {
      var card = cardFromJson(item, active, false);
      return `<div class="carousel-item ${active}">${card}</div>`  
  }

  $(document).ready(function() {
    $.getJSON("get_images/").done(function(data){
            $.each(data, function(i, item) { 
                var active = item.active ? 'active' : '';              
                $(".carousel-inner").append(carouselItemFromJson(item, active));
                $(".card-deck").append(cardFromJson(item, active, active));
            }); 
      });
  });

</script>
</body>
</html>