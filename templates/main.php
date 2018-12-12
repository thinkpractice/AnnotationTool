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

  function cardFromJson(item, active, categories, darkBorder)
  {
        var borderColor = darkBorder ? "border-dark" : "border-light";
        var categoryItems = [];
        $.each(categories, function (i, categoryItem) {
            categoryItems.push(`<a class="dropdown-item" href="set_category/${item.id}/${categoryItem.id}/">${categoryItem.label}</a>`);
        });
        var categoryHtml = categoryItems.join("");

        return `<div class="card ${borderColor}">
                    <img class="card-img-top" src="${item.image_url}">
                    <div class="card-footer ${item.color} ${item.textstyle}">                                             
                        <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          ${item.label}  
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          ${categoryHtml}
                        </div>
                      </div>
                    </div>
                </div>`
  }

  function carouselItemFromJson(item, active, categories)
  {
      var card = cardFromJson(item, active, categories, false);
      return `<div class="carousel-item ${active}">${card}</div>`  
  }

  $(document).ready(function() {
    $.getJSON("get_images/").done(function(data){            
            $.each(data.images, function(i, item) { 
                var active = item.active ? 'active' : '';              
                $(".carousel-inner").append(carouselItemFromJson(item, active, data.categories));
                $(".card-deck").append(cardFromJson(item, active, data.categories, active));
            }); 
      });
  });

</script>
</body>
</html>