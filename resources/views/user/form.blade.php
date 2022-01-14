<div class="container mt-2">
    <div class="card card-body">
        <h2>New User <a href="<?= url('/user');?>" class="btn btn-sm btn-info float-right">back</a></h2>
        <form action="<?= url('save-user');?>" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" id="id" placeholder="Enter id" name="id" value="<?= $user->id;?>">
            <div class="form-group">
                <div class="">
                    <div class="">
                        @if($user->img_name)
                        <div class="col-2 float-right">
                        <img src="<?= url('uploads/profile/'. $user->img_name);?>" alt="<?= $user->img_name;?>" width="100" height="100">
                        </div>
                        @endif
                        <div class="col-4 card-body border">
                            <label for="name">Choose Profile:</label> <br>
                            <input type="file" class="" id="file" name="file">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="name">User Name:</label>
                <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name"
                    value="<?= ($errors->first('name')) ? old('name') : $user->name;?>">
                <label for="" class="text-danger"><?= $errors->first('name');?></label>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email"
                    value="<?= ($errors->first('email')) ? old('email') : $user->email;?>">
                <label for="" class="text-danger"><?= $errors->first('email');?></label>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" placeholder="Enter password" name="password"
                    value="<?= $user->password;?>">
            </div>
            <div class="form-group form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="remember"> Remember me
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>