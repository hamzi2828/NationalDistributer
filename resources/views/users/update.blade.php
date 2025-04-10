<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post" enctype="multipart/form-data"
                                      action="{{ route ('users.update', ['user' => $user -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-10 mb-1">
                                                <div class="row">
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">Country</label>
                                                        <select class="form-control select2"
                                                                required="required" name="country-id"
                                                                data-placeholder="Select">
                                                            <option></option>
                                                            @if(count($countries) > 0)
                                                                @foreach($countries as $country)
                                                                    <option value="{{ $country -> id }}" @selected(old ('country-id', $user -> country_id) == $country -> id)>
                                                                        {{ $country -> title }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">Branch</label>
                                                        <select class="form-control select2"
                                                                required="required" name="branch-id"
                                                                data-placeholder="Select">
                                                            <option></option>
                                                            @if(count($branches) > 0)
                                                                @foreach($branches as $branch)
                                                                    <option value="{{ $branch -> id }}" @selected(old ('branch-id', $user -> branch_id) == $branch -> id)>
                                                                        {{ $branch -> fullname() }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="role">Role</label>
                                                        <select name="roles[]" class="form-control select2 form-select"
                                                                multiple="multiple"
                                                                id="role" required="required" data-placeholder="Select">
                                                            <option></option>
                                                            @if(count($roles) > 0)
                                                                @foreach($roles as $key => $role)
                                                                    <option value="{{ $role -> id }}"
                                                                            @foreach($user -> roles as $userRole) @if($role -> id == $userRole -> role_id)selected="selected"@endif @endforeach>
                                                                        {{ $role -> title }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="name">Name</label>
                                                        <input type="text" id="name" class="form-control"
                                                               required="required" autofocus="autofocus"
                                                               name="name" placeholder="Name"
                                                               value="{{ old ('name', $user -> name) }}" />
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="email-id">Email</label>
                                                        <input type="email" id="email-id" class="form-control"
                                                               required="required" name="email"
                                                               placeholder="Email"
                                                               value="{{ old ('email', $user -> email) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="password">Password</label>
                                                        <input type="password" id="password" class="form-control"
                                                               name="password"
                                                               placeholder="Password" />
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="contact-info">Mobile</label>
                                                        <input type="text" id="contact-info" class="form-control"
                                                               name="mobile" placeholder="Mobile"
                                                               value="{{ old ('mobile', $user -> mobile) }}"
                                                               maxlength="15" />
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="cnic">Identity No</label>
                                                        <input type="text" id="cnic" class="form-control"
                                                               name="identity-no"
                                                               placeholder="Identity No"
                                                               value="{{ old ('identity-no', $user -> identity_no) }}" />
                                                    </div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="gender">Gender</label>
                                                        <select name="gender" class="form-control select2 form-select"
                                                                id="gender" required="required"
                                                                data-placeholder="Select">
                                                            <option></option>
                                                            <option value="1" @selected(old ('gender', $user -> gender) == 'Male')>
                                                                Male
                                                            </option>
                                                            <option value="0" @selected(old ('gender', $user -> gender) == 'Female')>
                                                                Female
                                                            </option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4">Date of Birth</label>
                                                        <input type="text" id="fp-default" required="required"
                                                               class="form-control flatpickr-basic" name="dob"
                                                               placeholder="YYYY-MM-DD"
                                                               value="{{ old ('dob', $user -> dob) }}" />
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-1">
                                                        <label class="col-form-label font-small-4" for="user-customers">Customer(s)</label>
                                                        <select name="customers[]" class="form-control select2"
                                                                id="user-customers"
                                                                multiple="multiple" data-placeholder="Select">
                                                            <option></option>
                                                            @if(count ($customers) > 0)
                                                                @foreach($customers as $customer)
                                                                    <option value="{{ $customer -> id }}" @selected(in_array ($customer -> id, $user_customers))>
                                                                        {{ $customer -> name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-12 mb-1">
                                                        <label class="col-form-label font-small-4">Address</label>
                                                        <textarea class="form-control" rows="5"
                                                                  name="address">{{ old ('address', $user -> address) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-1">
                                                <div class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                                                    <div class="custom-avatar">
                                                        <a href="#" class="mb-1">
                                                            <img
                                                                    src="{{ (!empty(trim ($user -> avatar))) ? asset ($user -> avatar) : asset ('/assets/img/default-thumbnail.jpg') }}"
                                                                    id="account-upload-img"
                                                                    class="uploadedAvatar rounded"
                                                                    alt="profile image"
                                                                    height="150"
                                                                    width="150"
                                                            />
                                                        </a>
                                                        <div class="mt-1">
                                                            <label for="account-upload"
                                                                   class="btn btn-sm btn-primary mb-75 me-25">Upload</label>
                                                            <input type="file" id="account-upload" hidden="hidden"
                                                                   accept="image/*" name="avatar">
                                                            <button type="button" id="account-reset"
                                                                    class="btn btn-sm btn-outline-secondary mb-75">Reset
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-dashboard>