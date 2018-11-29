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
                <div class="carousel-item active">
                    <div class="card text-white border-light">  
                        <img class="card-img-top" src="Images/3c169b7e-fce0-4af9-b0ec-510532accce6_rgb_2016.png">
                        <div class="card-footer text-muted">
                          Unknown
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card text-white border-light">  
                        <img class="card-img-top" src="Images/3c5e8fdf-812f-4fcc-8095-5a6226562a89_rgb_2016.png">
                        <div class="card-footer text-muted">
                          Unknown
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card text-white border-light">  
                        <img class="card-img-top" src="Images/8ad7a8ea-2f48-47fb-84f2-ade5edf146fc_rgb_2016.png">
                        <div class="card-footer text-muted">
                          Unknown
                        </div>
                    </div>
                </div>
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
            <div class="card text-white border-light">
              <img class="card-img-top" src="Images/906008fe-0e4e-4258-a480-7d043f471598_rgb_2016.png">
              <div class="card-footer bg-danger text-white">
                No Solar Panels
              </div>
            </div>          
            <div class="card border-light">
              <img class="card-img-top" src="Images/3459fd10-11ce-49df-a5f2-b3427f1bb83b_rgb_2016.png">
              <div class="card-footer bg-danger text-white">
                No Solar Panels
              </div>        
            </div>        
            <div class="card  border-light">
              <img class="card-img-top" src="Images/24cfc0dc-30fb-429e-a9e2-39123a7c543f_rgb_2016.png">
              <div class="card-footer bg-success text-white">
                Solar Panels
              </div>
            </div>        
            <div class="card border-dark">
              <img class="card-img-top" src="Images/3c169b7e-fce0-4af9-b0ec-510532accce6_rgb_2016.png">
              <div class="card-footer text-muted">
                Unknown
              </div>
            </div>        
            <div class="card border-light">
              <img class="card-img-top" src="Images/3c5e8fdf-812f-4fcc-8095-5a6226562a89_rgb_2016.png">
              <div class="card-footer text-muted">
                Unknown
              </div>
            </div>        
            <div class="card border-light">
              <img class="card-img-top" src="Images/8ad7a8ea-2f48-47fb-84f2-ade5edf146fc_rgb_2016.png">
              <div class="card-footer text-muted">
                Unknown
              </div>
            </div>        
            <div class="card border-light">
              <img class="card-img-top" src="Images/035356b6-e050-45bf-8693-fdfff0b21283_rgb_2016.png">
              <div class="card-footer text-muted">
                Unknown
              </div>
            </div>
          </div> 
        </div>
      </div>    
  </div>

  <!-- JavaScript libraries needed-->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
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

</script>
</body>
</html>