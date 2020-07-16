<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Semart CMS') &mdash; {{ config('app.name') }}</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  @stack('css-plugins')

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        @include('partials.topnav')
      </nav>
      <div class="main-sidebar">
        @include('partials.sidebar')
        @yield('sidebar')
      </div>

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <footer class="main-footer">
        @include('partials.footer')
      </footer>
    </div>
  </div>

  <div class="modal fade mt-5" id="relationModal" tabindex="-1" role="dialog" aria-labelledby="relationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="relationModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div id="list-of-data">
            </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  @yield('body')

  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  @stack('js-plugins')
  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  @stack('scripts')
</body>
</html>
<script>
  function showRelation(record_id, cm_name, target_name, modifier){
      $('#relationModal').modal({"backdrop" : false});
      
      try {
          $.ajax({
              url: '{{ route('content_model.load_related_model_data') }}',
              dataType: 'json',
              type: 'POST',
              data: {
                  "targetName" : target_name,
                  "cmName" : cm_name,
                  "recordId" : record_id,
                  "modifier" : modifier,
              },
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(res) {    
                  if(res){
                      if(modifier == "belongsTo" || modifier == "hasOne"){
                          singleData(res, target_name);
                      }else{
                          manyData(res, target_name);
                      }
                  }else{
                      $('#list-of-data').html("No data ");
                  }
              },
              error: function(x, e) {
                  $('#relationModalLabel').html("<h5>Error</h5>");
                  $('#list-of-data').html("No data<br>"+x.responseJSON.message);
              }
          });
          
      } catch (error) {
          console.log(error);
      }

  }

  function singleData(data, target_name){
      html_element = '<table class="table">';

      Object.keys(data)
          .forEach(function eachKey(key) { 
              html_element += `
                  <tr>
                      <td class="font-weight-bold">${ key }</td>
                      <td>${ data[key] }</td>
                  </tr>
              `;
          });

      html_element += '</table>';

      $('#relationModalLabel').html("<h5>"+target_name+"</h5>");
      $('#list-of-data').html(html_element);
  }

  function manyData(data, target_name){
      html_element = `
          <table class="table">
          <thead>
          `;
      
      // header table
      count = 1;
      Object.keys(data[0]).forEach(
          function eachKey(key){
              if(count == 6){
                  return;
              };

              html_element += `<th>${ key }</th>`;
              
              count++;
          }
      );

      html_element += `</thead>`;

      data.forEach(el => {
          html_element += `<tr>`;

          count = 1;
           Object.keys(el).forEach(function eachKey(key) { 
              if(count == 6){
                  return;
              };

              html_element += `
                  <td>${ el[key] }</td>
              `;                

              count++;
          });
          
          html_element += `</tr>`;
      });
      html_element += `</table>`;

      $('#relationModalLabel').html("<h5>"+target_name+"</h5>");
      $('#list-of-data').html(html_element);
  }
</script>
