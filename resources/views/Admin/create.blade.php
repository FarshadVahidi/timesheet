<x-app-layout>
    @section('mainContent')
        <div class="container">
            <form name="myform" method="POST" action="{{route('admins.user.store')}}" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">{{__('Name')}}</label>
                    <input type="string" class="form-control" name="name" id="name" aria-describedby="emailHelp">
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
                if(email === "")
                {
                    alert('email required!');
                    return false;
                }
                if(document.myform.password.value === "")
                {
                    alert('password required!');
                    return false;
                }
                if (document.myform.role_id.value == 'Select Role') {
                    alert('choose role id for new user!');
                    return false;
                }
                document.myform.email.value = email+"@app.com";
                return true;

            }
        </script>
    @endsection
</x-app-layout>
