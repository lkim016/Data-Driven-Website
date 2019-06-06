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

<title>Main</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="nav navbar-nav">
            <li class="nav-item"><a class="nav-link" href="/main">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="/add-resource">Add Available Resource</a></li>
            <li class="nav-item"><a class="nav-link" href="/add-incident">Add Emergency Incident</a></li>
            <li class="nav-item"><a class="nav-link" href="/search-resource">Search Resources</a></li>
            <li class="nav-item"><a class="nav-link" href="/resource-report">Generate Resource Report</a></li>
        </ul>
        <ul class = "nav navbar-nav ml-auto">
            <li class="nav-item dropdown">
            <!-- Dropdown -->
            <div class="navbar-nav dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    {!! session('login_disp') !!}
                </a>
                <div class ="dropdown-menu dropdown-menu-right">
                    @if ( session('login_email') <> 0 )
                    <a class = "dropdown-item">{{ session('login_email') }}</a>
                    @elseif ( session('login_phone') <> 0)
                    <a class = "dropdown-item">{{ session('login_phone') }}</a>
                    @elseif ( session('login_add') <> 0)
                    <a class = "dropdown-item">{{ session('login_add') }}</a>
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
                <h2>{{ session('user_type') }}</h2> <!-- pick up here -->
            </div>
            <div class="col-sm right">
                <h5>{!! session('login_disp') !!}</h5> <!-- want to have user name and add a drop down under with info and log out -->
                <!-- user specific info -->
                @if ( session('login_email') <> 0 )
                    <h5>{{ session('login_email') }}</h5>
                @elseif ( session('login_phone') <> 0)
                    <h5>{{ session('login_phone') }}</h5>
                @elseif ( session('login_add') <> 0)
                    <h5>{{ session('login_add') }}</h5>
                @endif
        </div>
    </div>

    <div>
    @yield('content')
    </div>
    
<!-- GENERAL JS -->
<script type="text/javascript">
$(document).ready(function() {
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
        $("#resource-search").on('click', function(event) { 
            event.preventDefault();
            // -> PROBLEM: NEED TO HAVE PRIMARY FUNCTION REQUIRED
            // display the search result html
            $("#search-result").show();
            // remove the table rows
            $(".search-body").children().remove();
            // create the html to display php results
            load_doc();
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
                    var result = JSON.parse(data);
                    for (item in result) {
                        var cost_unit = result[item]['cost'] + "/" + result[item]['unit'];
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
                }
            })
        }
    }
});
</script>

</body>
</html>