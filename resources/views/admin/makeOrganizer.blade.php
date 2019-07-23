@extends('layouts.main', ['title' => 'Назначить организаторов'])

@section('content')


    <table id="example2" class="table table-striped table-bordered">
        <thead>
        <tr>
            <th scope="col">Имя</th>
            <th scope="col">Email</th>
            <th scope="col">Куратор A</th>
            <th scope="col">Куратор B</th>
        </tr>
        </thead>
        <tbody id="body">


        </tbody>
    </table>


    <script>
        var k = 1;
        window.onload = function () {
            f();

        };

        function f() {
            // $("#body").remove();
            $("#example2").find("tr:not(:first)").remove();
            console.log("f");
            $.ajax({
                url: 'getUsers',
                data: null,
                type: 'get',
                success: function (data) {

                },
            }).done(function (data) {
                console.log(data);
                var i = 0;

                $.each(data, function (index, subcatObj) {
                    var x = document.getElementById('body').insertRow(0);
                    var y = x.insertCell(0);
                    var z = x.insertCell(1);
                    var subcatObj2 = subcatObj;
                    //   console.log(subcatObj);
                    y.innerHTML = '';
                    const did = y.appendChild(document.createElement('input'));
                    const rand = z.appendChild(document.createElement('input'));
                    did.type = 'button';
                    rand.type = 'button';
                    this.i = subcatObj.id;
                    if (subcatObj.a_org == null) {
                        did.value = 'Назначить организатором ';
                        did.addEventListener('click', () => makeA(subcatObj));
                    }
                    else {
                        did.value = 'Снять';
                        did.addEventListener('click', () => deleteA(subcatObj));
                    }
                    if (subcatObj.b_org == null) {
                        rand.value = 'Назначить организатором';
                        rand.addEventListener('click', () => makeB(subcatObj));

                    }
                    else {
                        rand.value = 'Снять';
                        rand.addEventListener('click', () => deleteB(subcatObj));

                    }

                    var y = x.insertCell(0);
                    var z = x.insertCell(1);
                    y.innerHTML = subcatObj.name;
                    z.innerHTML = subcatObj.email;
                })

            });
        }

        function makeB(item) {
            $.ajax({
                type: "POST",
                url: '/admin/makeB',
                data: {id: item.id, _token: '{{csrf_token()}}'},
                success: function (data) {
                    console.log(data);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
            f()
        }

        function deleteB(item) {
            console.log('delete b');
            console.log(item);
            $.ajax({
                type: "POST",
                url: '/admin/deleteB',
                data: {id: item.id, user: item.name, _token: '{{csrf_token()}}'},
                success: function (data) {
                    console.log(data);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
            f()
        }

        function makeA(item) {
            console.log(item);
            $.ajax({
                type: "POST",
                url: '/admin/makeA',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": item.id,
                },
                success:
                    function (data) {
                        console.log(data);
                    }

                ,
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                }
                ,
            })
            ;
            f()
        }

        function deleteA(item) {
            console.log('delete a');
            console.log(item);
            $.ajax({
                type: "POST",
                url: '/admin/deleteA',
                data: {id: item.id, user: item.name, _token: '{{csrf_token()}}'},
                success: function (data) {
                    console.log(data);
                },
                error: function (data, textStatus, errorThrown) {
                    console.log(data);
                },
            });
            f()
        }
    </script>
@endsection
