<div class="container mt-2">
    <div class="card card-body">
    @if(Session::has('message'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    @if(Session::has('error'))
      <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
        <h2>Users Table <a href="<?= url('/add-user');?>" class="btn btn-sm btn-info float-right">Add User</a></h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td> {{ $user->name }} </td>
                    <td> {{ $user->email }}</td>
                    <td class="text-right">
                        <a href="<?= url('/add-user/'. base64_encode($user->id));?>" class="btn btn-sm btn-info mr-2">Edit</a>
                        <a href="<?= url('/download-profile/'. base64_encode($user->id));?>" class="btn btn-sm btn-info mr-2">Download Profile</a>
                        <a href="<?= url('/remove-user/'. base64_encode($user->id));?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this?');">Remove</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>