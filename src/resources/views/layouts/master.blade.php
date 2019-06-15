<?php if ( empty(Session::get('user')) )  {
    header( 'Location: /login' ) ;
    die();
} else { ?>

<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<!-- datepicker -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- GENERAL JS -->
<script type="text/javascript">
$(document).ready(function() {
    // 6/14: maybe try storing session in a php variable and passing it to js
    // +++ NAV +++
    // add active class to link of page
    var pathname = window.location.pathname;
    $('.nav > li > a[href="' + pathname + '"]').parent().addClass('active'); // need to fix this for the dropdown
    
    if (pathname == "/add-incident") {
        // +++ ADD-INCIDENT +++
        $( "#datepicker" ).datepicker();
        $( "#incident-save" ).on('click', function() {
            var today = new Date();
            var date_choice = new Date( $( "#datepicker" ).val() );
            // date_choice might have to be reformatted to MM-DD-YY
            var result = ( date_choice.getMonth()+1 ) + '/' + date_choice.getDate() + '/' + date_choice.getFullYear() + ' ' + today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();
            $( "#datepicker" ).val(result);
        });
    } else if (pathname == "/search-resource") {
        // +++ SEARCH-RESOURCE +++
         // store_user_inp exceptions: backspace on hold, selection: replacing all or up to selection, copy and paste
         /*$("#keyword").on('keydown', function(event) {
            input_key_check(event);
        });
        */

        $("#resource-search").on('click', function(event) {
            event.preventDefault();
            load_doc();
            // -> PROBLEM: NEED TO HAVE PRIMARY FUNCTION REQUIRED
            //if ( $("#search_function").val() != 0 ) {
                // create the html to display php results
                // load_doc();
            //} else {
                // javascript error message
            //}
        });
        // AJAX
        function load_doc() {
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    }
            })

            var _token = $("input[name='_token']").val();

            $.ajax({
                method: 'POST',
                url: '/search-resource',
                data: {
                    _token: _token,
                    'keyword': $("#keyword").val(),
                    'prim_func': $("#search_function").val(),
                    'incident': $("#search_incident").val(),
                    'distance': $("#search_distance").val()
                },
                dataType: 'JSON',
                success: function(data) {
                    // remove the table rows
                    $(".search-body").children().remove();
                    var result = JSON.parse(data);

                    if (result.length > 0) {
                        // display the search result html
                        $("#search-result").show();
                        for (item in result) {
                            var cost_unit = "$" + result[item]['cost'] + "/" + result[item]['unit'];
                            // input respones data into an array to loop through and create html structure
                            var html_result = [];
                            html_result['owner'] = $("<td></td>").text(result[item]['owner']); // 0 owner
                            html_result['resource_id'] = $("<td></td>").text(result[item]['resource_id']); // 1 resource id
                            html_result['resource_name'] = $("<td></td>").text(result[item]['resource_name']); // 2 resource name
                            html_result['cost_unit'] = $("<td></td>").text(cost_unit); // 3 cost + unit
                            html_result['distance'] = $("<td></td>").text(result[item]['distance']); // 5 distance

                            $(".search-body").append("<tr>", html_result['resource_id'], html_result['resource_name'],
                            html_result['owner'], html_result['cost_unit'], html_result['distance'], "</tr>");

                        }
                    } else {
                        alert("No results found!");
                        $("#search-result").hide();
                    }
                }
            })
        }
    }
});
</script>

<title>Main</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="nav navbar-nav">
            <li class="nav-item"><a class="nav-link" href="/main">Main</a></li>
            <li class="nav-item"><a class="nav-link" href="/add-resource">Add Available Resource</a></li>
            <li class="nav-item"><a class="nav-link" href="/add-incident">Add Emergency Incident</a></li>
            <li class="nav-item"><a class="nav-link" href="/search-resource">Search Resources</a></li>
            <li class="nav-item"><a class="nav-link" href="/resource-report">Generate Resource Report</a></li>
        </ul>
        <ul class = "nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
            <div class="navbar-nav dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    {{ Session::get('display') }}
                </a>
                <div class ="dropdown-menu dropdown-menu-right">
                    @if ( Session::get('email') <> 0 )
                    <a class = "dropdown-item">{{ Session::get('email') }}</a>
                    @elseif ( Session::get('phone') <> 0)
                    <a class = "dropdown-item">{{ Session::get('phone') }}</a>
                    @elseif ( Session::get('add') <> 0)
                    <a class = "dropdown-item">{{ Session::get('add') }}</a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a href="/login"class="dropdown-item">Logout</a>
                </div>
            </div>
            </li>
        </ul>
    </nav>

    <div class="row">
        <div class="col-sm left">
                <h2>{{ Session::get('type') }}</h2> <!-- pick up here -->
            </div>
            <div class="col-sm right">
                <h5>{{ Session::get('display') }}</h5> <!-- want to have user name and add a drop down under with info and log out -->
                <!-- user specific info -->
                @if ( Session::get('email') <> 0 )
                    <h5>{{ Session::get('email') }}</h5>
                @elseif ( session('phone') <> 0)
                    <h5>{{ Session::get('phone') }}</h5>
                @elseif ( session('add') <> 0)
                    <h5>{{ Session::get('add') }}</h5>
                @endif
        </div>
    </div>

    <div>
    @yield('content')
    </div>

</body>
</html>

<?php } ?>