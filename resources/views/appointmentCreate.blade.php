@extends('layouts.primary')

@section('content')
<div class="container">
    @if (session('successMsg'))
    <div class="alert alert-success" role="alert">
        {{ session('successMsg') }}
    </div>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="selectHourModal" tabindex="-1" role="dialog" aria-labelledby="selectHourLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectHourLabel"> hour</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select class="select form-select" size="7" aria-label="select example">
                    <!-- Available hours -->
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="saveHour btn btn-primary" data-bs-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<!-- Content -->
<div class="container">
    <a href="/" class="btn btn-danger">Back</a>
    
    <h1>Create appointment</h1>
    <p style="color:red">all fields marked with * are mandatory</p>
    <br><br>

    @if (session('errorMsg'))
        <div class="alert alert-danger" role="alert">
            {{ session('errorMsg') }}
        </div>
    @endif

    <form id="create" action="{{route('appointment.create')}}" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf

        <div class="form-group">
            <label for="date">Date*</label>
            <input type="date" name="date" placeholder="YYYY/MM/DD" class="form-control" id="configDate" required>
        </div>

        <div class="form-group">
            <label for="hour">Hour*</label>
            <button type="button" class="checkHours btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#selectHourModal" disabled>Choose the desired time</button>
            <br><br>
            <input type="text" name="hour" class="hourInput form-control" readonly required>
        </div>

        <div class="form-group">
            <label for="fullName">Full Name*</label>
            <input type="text" name="fullName" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="phoneNumber">Phone Number*</label>
            <input type="text" name="phoneNumber" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">Email*</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button type="submit" class="submit btn btn-primary">Create appointment</button>
    </form>
</div>
@stop
<!-- End Content -->

<!-- Scripts -->
@section('scripts')

<!-- Ajax Post Request -->
<script>
    $(document).ready(function() {
        $(document).on('click', 'submit', function(e) {
            e.preventDefault();

            var data = {
                'date'          : $('input[name="date"]').val(),
                'hour'          : $('input[name="hour"]').val(),
                'fullName'      : $('input[name="fullName"]').val(),
                'phoneNumber'   : $('input[name="phoneNumber"]').val(),
                'email'         : $('input[name="email"]').val(),
            }
            // console.log(data);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                type: "POST",
                url: "/create",
                data: data,
                dataType: "json",
                success: function(response) {
                  console.log(response);
                }
            })
        });
    });
</script>

<!-- Available hours -->
<script>
    $(document).ready(function() {
        $(document).on('click', '.checkHours', function(e) {
            fetchhours();
                function fetchhours() {
                    
                    let possibleHours = ["09:00", "10:30", "12:00", "15:30", "17:00", "18:30", "20:00"];
                    let date = $('input[name="date"]').val();
                    $('.select').html("");
                    
                    $.ajax({
                        type: "GET",
                        url: "/selectBy/" + date,
                        dataType: "json",
                        success: function(response) {
                            if (response !== null) {
                                $.each(response.hours, function(key, item) {
                                    possibleHours = possibleHours.filter(hour => hour !== item.hour);
                                });
                            }
 
                            if(possibleHours.length === 0){
                                $('.select').append('<option>No hours available</option>');
                            }else{
                                possibleHours.forEach(function(hour) {
                                    $('.select').append('<option value="' + hour + '">' + hour + '</option>')
                                })
                            }
                        }
                    })
                }
        })
    });
</script>

<!-- Date config - remove weekend days -->
<script>
    //activate hours button if the date is selected
    $(document).ready(function() {
        $('#configDate').on('input',function(e){
            $('.checkHours').prop("disabled", false);
            $('.hourInput').val("");
        });
    });

    config = {
        minDate: "today",
        dateFormat: "Y-m-d",
        "disable": [
            function(date) {
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ],
    }

    flatpickr("#configDate", config)
</script>

<!-- Set hour input value -->
<script>
    $(document).ready(function() {
        $(document).on('click', '.saveHour', function(e) {
            let selectedHour = $('.select').val();
            $('.hourInput').val(selectedHour);
        })
        });
</script>
@stop

<!-- End Scripts -->