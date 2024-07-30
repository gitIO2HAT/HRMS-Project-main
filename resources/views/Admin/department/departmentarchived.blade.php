@extends('layouts.app')

@section('content')

<body>

@if(Auth::user()->user_type == 0)

    
<a href="{{url('/SuperAdmin/Department')}}" class="m-1 btn btn-warning "><i class="far fa-file-archive" style="color: #000000;"></i> Back</a>
@elseif(Auth::user()->user_type == 1)

<a href="{{url('/Admin/Department')}}" class="m-1 btn btn-warning "><i class="far fa-file-archive" style="color: #000000;"></i> Back</a>
@endif
    @include('layouts._message')
    <form action="/Admin/Department/AddPosition" method="POST">
        @csrf
        <div>
            <label for="department">Department</label>
            <select id="department" name="department_id">
                <option value="">Select Department</option>
                @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            @if($errors->has('department_id'))
            <span class="text-danger">{{ $errors->first('department_id') }}</span>
            @endif
        </div>



        <div class="row g-4">
            <div class="col-sm-6 col-xl-6">
                <div class="fields">
                    <div class="input-field">
                        <label>Position</label>
                        <input type="text" placeholder="Position Name" class="form-control" name="name" value="">
                        @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>





    <form action="/Admin/Department/AddDepartment" method="POST">
        @csrf

        <div>
            <label for="department">Check the Department</label>
            <select id="department" name="department_id">
                <option value="">Select Department</option>
                @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
            @if($errors->has('department_id'))
            <span class="text-danger">{{ $errors->first('department_id') }}</span>
            @endif
        </div>
        <div class="row g-4">
            <div class="col-sm-6 col-xl-6">
                <div class="fields">
                    <div class="input-field">
                        <label>Department</label>
                        <input type="text" placeholder="Department Name" class="form-control" name="name" value="">
                        @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif

                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
    </form>



    <table class="table table-bordered">
        <thead class="text-dark text-center">
            <tr class="bg-title">
                <th class="centered">#</th>
                <th>Department Name</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($departments as $index => $list)
            <tr>
                <td class="text-dark">{{ $index + 1 }}</td>
                <td class="text-dark">{{$list->name}}</td>
                <td class="text-dark"></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="table table-bordered">
        <thead class="text-dark text-center">
            <tr class="bg-title">
                <td class="centered">Position List</th>
            </tr>

        </thead>
        <tbody class="text-center">
            <tr>
                <td id="position" class="text-dark"></td>
            </tr>
        </tbody>
    </table>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#department').on('change', function() {
                var departmentId = $(this).val();
                if (departmentId) {
                    $.ajax({
                        url: '/Admin/positions/' + departmentId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#position').empty();
                            $('#position').append('<option value="">Select Position</option>');
                            $.each(data, function(key, value) {
                                $('#position').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error: ' + status + error);
                        }
                    });
                } else {
                    $('#position').empty();
                    $('#position').append('<option value="">Select Position</option>');
                }
            });
        });
    </script>

   
</body>

@endsection