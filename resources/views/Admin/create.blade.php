<x-app-layout>
    @section('myScript')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous"></script>
    @endsection

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @section('mainContent')

                    @if(Session::has('message'))
                        <script>
                            swal("OK!", "{!! Session::get('message') !!}", "success",{
                                button:"OK",
                            })
                        </script>
                    @endif

                    @if(Session::has('error'))
                        <script>
                            swal("OOPS!", "{!! Session::get('message') !!}", "error",{
                                button:"OK",
                            })
                        </script>
                    @endif

                    <div class="container">
                        <form name="myform" method="POST" action="{{route('admins.user.store')}}"
                              onsubmit="return validateForm()">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">{{__('Name')}}</label>
                                <input type="string" class="form-control" name="name" id="name"
                                       aria-describedby="emailHelp">
                                {{ $errors->first('name') }}
                            </div>

                            <div class="input-group mb-3">
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email"
                                       aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">@app.com</span>
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>

                            <div class="mb-3">
                                <select
                                    class="form-text block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    name="role_id">
                                    <option class="disabled">Select Role</option>
                                    <option value="user">User</option>
                                    <option value="administrator">Administrator</option>
                                </select>
                                {{ $errors->first('role_id') }}
                            </div>

                            @csrf

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                @endsection
            </div>
        </div>
    </div>

    @section('myScript')
        <script>
            function validateForm() {
                let name = document.myform.name.value;
                let email = document.myform.email.value;
                if (name.length > 50) {
                    alert('name can not be too long!');
                    return false;
                }
                if (name === "") {
                    alert('name required!');
                    return false;
                }
                if (email === "") {
                    alert('email required!');
                    return false;
                }
                if (document.myform.password.value === "") {
                    alert('password required!');
                    return false;
                }
                if (document.myform.role_id.value == 'Select Role') {
                    alert('choose role id for new user!');
                    return false;
                }
                document.myform.email.value = email + "@app.com";
                return true;

            }
        </script>
    @endsection
</x-app-layout>
