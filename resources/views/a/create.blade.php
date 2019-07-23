@extends('layouts.main', ['title' => 'Создать заявку'])


@section('content')
    <form action="{{route('storeA')}}" id="form" enctype="multipart/form-data" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" class="form-control" id="name" name="name" required="required" placeholder="Введите имя"
                   required value={{ old('name') }} >
            @if($errors->has('title'))
                <font color="red"><p>  {{$errors->first('name')}}</p></font>
            @endif
        </div>
        <div class="form-group">
            <label for="femili">Фамилия:</label>
            <input type="text" class="form-control" id="femili" name="femili" required="required"
                   placeholder="Введите фамилию"
                   required value={{ old('femili') }} >
            @if($errors->has('femili'))
                <font color="red"><p>  {{$errors->first('femili')}}</p></font>
            @endif
        </div>
        <div class="form-group">
            <label for="phone">Телефон:</label>
            <input type="phone" class="form-control" id="phone" name="phone" required="required"
                   placeholder="Введите телефон"
                   required pattern="[0-9]{10}" value={{ old('phone') }} >
            @if($errors->has('title'))
                <font color="red"><p>  {{$errors->first('femili')}}</p></font>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required="required"
                   placeholder="Введите email"
                   required value={{ old('email') }} >
            @if($errors->has('email'))
                <font color="red"><p>  {{$errors->first('femili')}}</p></font>
            @endif
        </div>

        <div class="form-group">
            <label for="exampleInputFile">Текст заявки:</label><br><br>
            <textarea name="description" id="description" rows=11 cols=50 maxlength=250
                      required> {{old('description')}}</textarea>
        </div>


        Образование:
        <select style="width: 200px" class="education" name="education" class="form-control input-sm" id="education"
                required>
            @foreach($educations as $education)
                <option value="{{$education->id}}">{{$education->name}}</option>
            @endforeach
        </select>

        <table class="table table-bordered" id="dynamic_field">
            <tr>
                <td><input type="file" name="files[]" id="filesInfo" placeholder="Enter your Name"
                           class="form-control name_list" accept="image/gif,image/jpg, image/jpeg, image/png video/mp4"
                           required/></td>
                <td>
                    <button type="button" name="add" id="add" onclick="return f();" class="btn btn-success">Add More
                    </button>
                </td>
            </tr>
        </table>

        <!--hiden field for utm -->
        <input type="hidden" value="{{$utm}}" name="utm" id="utm">

        <br><br>
        <!-- <button type="submit" class="btn btn-default">Создать текст</button> -->
        <input type="submit">

    </form>
    <script type="text/javascript">

        $("form#form").submit(function (e) {
            e.preventDefault();
            var frm = $('#form');

            var att = frm.attr("action");
            var formData = new FormData(this);
            $.ajax({
                url: att,
                type: 'POST',
                data: formData,
                statusCode: {
                    200: function () {
                        console.log("200 - Success");
                        alert("Зайвка успешео создана!");
                        document.getElementById("form").reset();
                    },
                    404: function (request, status, error) {
                        console.log("404 - Not Found");
                        console.log(error);
                        alert("Ошибка. Страница не неадена!");
                    },
                    503: function (request, status, error) {
                        console.log("503 - Server Problem");
                        console.log(error);
                        alert("Проблема сервера.");
                    }
                },
                success: function (data) {
                    //alert(data)
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        $(document).ready(function () {
            var i = 1;
            $('#add').click(function () {
                i++;
                $('#dynamic_field').append('<tr id="row' + i + '"><td><input type="file" name="files[]"  accept="image/x-png,image/gif,image/jpeg" class="form-control name_list" required /></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function () {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });

        function f() {
            console.log("adding file");
        }


    </script>
@endsection