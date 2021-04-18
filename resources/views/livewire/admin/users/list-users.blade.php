<div>
    <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Users</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

    <!-- Main content -->
  <div class="content">
    <div class="container-fluid">

      <div class="row">
        <div class="col-lg-12">
        	<div class="d-flex justify-content-between mb-2">
        		<button wire:click.prevent="addNew" class="btn btn-primary"><i class="fa fa-plus-circle mr-1"></i> Add New User</button>
            <x-search-input wire:model="searchTerm" />
        	</div>
          <div class="card">
            <div class="card-body">
              <table class="table table-hover">
      				  <thead>
      				    <tr>
      				      <th scope="col">#</th>
      				      <th scope="col">Name</th>
      				      <th scope="col">Email</th>
                    <th scope="col">Registerd Date</th>
      				      <th scope="col">Options</th>
      				    </tr>
      				  </thead>
      				  <tbody wire:loading.class="text-muted">
                  @forelse($users as $user)
      				    <tr>
      				      <th scope="row">{{ $loop->iteration }}</th>
      				      <td>
                      <img src="{{ $user->avatar_url }}" style="width: 50px;" class="img img-circle mr-1" alt="">
                      {{ $user->name }}
                    </td>
      				      <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->toFormattedDate() }}</td>
      				      <td>
      				      	<a href="" wire:click.prevent="edit({{ $user }})">
      				      		<i class="fa fa-edit mr-2"></i>
      				      	</a>

      				      	<a href="" wire:click.prevent="confirmUserRemoval({{ $user->id }})">
      				      		<i class="fa fa-trash text-danger"></i>
      				      	</a>
      				      </td>
      				    </tr>
                  @empty
                  <tr class="text-center">
                    <td colspan="5">
                      <img src="https://42f2671d685f51e10fc6-b9fcecea3e50b3b59bdc28dead054ebc.ssl.cf5.rackcdn.com/v2/assets/empty.svg" alt="No results found">
                      <p class="mt-2">No results found</p>
                    </td>
                  </tr>
                  @endforelse
      				  </tbody>
      				</table>
            </div>
            <div class="card-footer d-flex justify-content-end">
              {{ $users->links() }}
            </div>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->

  <!-- Modal -->
<div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
  <div class="modal-dialog" role="document">
    <form autocomplete="off" wire:submit.prevent="{{ $showEditModal ? 'updateUser' : 'createUser' }}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          @if($showEditModal)
            <span>Edit User</span>
          @else
            <span>Add New User</span>
          @endif
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<div class="form-group">
		    <label for="name">Name</label>
		    <input type="text" wire:model.defer="state.name" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="nameHelp" placeholder="Enter full name">
        @error('name')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
		  </div>

		  <div class="form-group">
		    <label for="email">Email address</label>
		    <input type="text" wire:model.defer="state.email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="emailHelp" placeholder="Enter email">
        @error('email')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
		  </div>

		  <div class="form-group">
		    <label for="password">Password</label>
		    <input type="password" wire:model.defer="state.password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
        @error('password')
          <div class="invalid-feedback">
            {{ $message }}
          </div>
        @enderror
		  </div>

		  <div class="form-group">
		    <label for="passwordConfirmation">Confirm Password</label>
		    <input type="password" wire:model.defer="state.password_confirmation" class="form-control" id="passwordConfirmation" placeholder="Confirm Password">
		  </div>

      <div class="form-group">
        <label for="customFile">Profile Photo</label>

        <div class="custom-file">
          <input wire:model="photo" type="file" class="custom-file-input" id="customFile">
          <label class="custom-file-label" for="customFile">
            @if ($photo)
              {{ $photo->getClientOriginalName() }}
            @else
              Choose Image
            @endif
          </label>
        </div>
      </div>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
        <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i>
          @if($showEditModal)
            <span>Save Changes</span>
          @else
            <span>Save</span>
          @endif
        </button>
      </div>
    </div>
    </form>
  </div>
</div>

  <!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Delete User</h5>
      </div>

      <div class="modal-body">
        <h4>Are you sure you want to delete this user?</h4>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times mr-1"></i> Cancel</button>
        <button type="button" wire:click.prevent="deleteUser" class="btn btn-danger"><i class="fa fa-trash mr-1"></i>Delete User</button>
      </div>
    </div>
  </div>
</div>
</div>
