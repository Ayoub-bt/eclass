@extends('admin.layouts.master')
@section('title','All Instructor')
@section('maincontent')
@component('components.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('Instructors') }}
@endslot

@slot('menu1')
{{ __('Instructors') }}
@endslot

@slot('button')

<div class="col-md-4 col-lg-4">
    <div class="widgetbar">
        <button type="button" class="float-right btn btn-danger-rgba mr-2 " data-toggle="modal"
            data-target="#bulk_delete"><i class="feather icon-trash mr-2"></i> {{ __('Delete Selected') }}</button>
        <a href="{{route('allinstructor.add')}}" class="float-right btn btn-primary-rgba mr-2"><i
                class="feather icon-plus mr-2"></i>{{ __('Add Instructor') }}</a>

    </div>
</div>

@endslot
@endcomponent

<div class="contentbar">
    <div class="row">

        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('All Instructors') }}</h5>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <input id="checkboxAll" type="checkbox" class="filled-in" name="checked[]"
                                            value="all" />
                                        <label for="checkboxAll" class="material-checkbox"></label> #
                                    </th>
                                    <th>{{ __('adminstaticword.Image') }}</th>
                                    <th>{{ __('adminstaticword.Users') }}</th>
                                    <th>{{ __('adminstaticword.Role') }}</th>
                                    <th>{{ __('adminstaticword.Country') }}</th>
                                    <th>{{ __('adminstaticword.Status') }}</th>
                                    <th>{{ __('adminstaticword.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=0;?>
                                @foreach ($users as $user)
                                @if($user->id != Auth::User()->id)
                                <?php $i++;?>
                                <tr>

                                    <td>

                                        <input type='checkbox' form='bulk_delete_form'
                                            class='check filled-in material-checkbox-input' name='checked[]'
                                            value="{{ $user->id }}" id='checkbox{{ $user->id }}'>
                                        <label for='checkbox{{ $user->id }}' class='material-checkbox'></label>
                                        <?php echo $i; ?>
                                        <div id="bulk_delete" class="delete-modal modal fade" role="dialog">
                                            <div class="modal-dialog modal-sm">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                        <div class="delete-icon"></div>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <h4 class="modal-heading">{{ __('Are You Sure') }} ?</h4>
                                                        <p>{{ __('Do you really want to delete selected item names here? This process
                                                                    cannot be undone') }}.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form id="bulk_delete_form" method="post"
                                                            action="{{ route('user.bulk_delete') }}">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="reset" class="btn btn-gray translate-y-3"
                                                                data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">{{ __('Yes') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @if($image = @file_get_contents('../public/images/user_img/'.$user->user_img))
                                    <td>
                                        <img @error('photo') is-invalid @enderror
                                                src="{{ url('images/user_img/'.$user->user_img) }}" alt="profilephoto"
                                                class="img-responsive img-circle" data-toggle="modal"
                                                data-target="#exampleStandardModal{{ $user->id }}">
                                    </td>

                                    @else


                                    <td> <img @error('photo')
                                                is-invalid @enderror
                                                src="{{ Avatar::create($user->fname)->toBase64() }}" alt="profilephoto"
                                                class="img-responsive img-circle" data-toggle="modal"
                                                data-target="#exampleStandardModal{{ $user->id }}">
                                    </td>
                                    @endif
                                    <td>
                                        <p><b>{{ __('Name') }}</b>: {{ $user['fname'] }} {{ $user['lname'] }}</p>
                                        <p><b>{{ __('Email') }}</b>: {{ $user['email'] }}</p>

                                        <p><b>{{ __('Mobile') }}</b>: @if(isset($user->mobile))
                                            {{ $user->mobile }}
                                            @endif</p>
                                    </td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        @if(isset($user->country))
                                        {{  $user->country->nicename  }}
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('user.quick',$user->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            <label class="switch">
                                                <input class="user" type="checkbox" data-id="{{$user->id}}"
                                                    name="status" {{ $user->status == '1' ? 'checked' : '' }}>
                                                <span class="knob"></span>
                                            </label>


                                        </form>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-round btn-outline-primary" type="button"
                                                id="CustomdropdownMenuButton1" data-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false"><i
                                                    class="feather icon-more-vertical-"></i></button>
                                            <div class="dropdown-menu" aria-labelledby="CustomdropdownMenuButton1">
                                                <a class="dropdown-item"
                                                    href="{{ route('allinstructor.edit',$user->id) }}"><i
                                                        class="feather icon-edit mr-2"></i>{{ __('Edit') }}</a>
                                                <a class="dropdown-item btn btn-link" data-toggle="modal"
                                                    data-target="#delete{{ $user->id }}">
                                                    <i class="feather icon-delete mr-2"></i>{{ __("Delete") }}</a>
                                                </a>
                                                <button type="button" class="dropdown-item" data-toggle="modal"
                                                    data-target="#exampleStandardModal{{ $user->id }}">
                                                    <i class="feather icon-eye mr-2"></i>View
                                                </button>
                                            </div>
                                        </div>

                                        <!-- delete Modal start -->
                                        <div class="modal fade bd-example-modal-sm" id="delete{{$user->id}}"
                                            tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleSmallModalLabel">
                                                            {{ __('Delete') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h4>{{ __('Are You Sure ?')}}</h4>
                                                        <p>{{ __('Do you really want to delete')}}
                                                            <b>{{$user->fname}}</b>?
                                                            {{ __('This process cannot be undone.')}}</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post"
                                                            action="{{ route('user.delete',$user->id) }}"
                                                            class="pull-right">
                                                            {{csrf_field()}}
                                                            {{method_field("DELETE")}}
                                                            <button type="reset" class="btn btn-secondary"
                                                                data-dismiss="modal">{{ __('No') }}</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">{{ __('Yes') }}</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- delete Model ended -->
                                        <div class="modal fade" id="exampleStandardModal{{$user->id}}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleStandardModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleStandardModalLabel">
                                                            {{ $user->fname }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="col-lg-12">
                                                            <div class="card m-b-30">
                                                                <div class="card-body py-5">
                                                                    <div class="row">
                                                                        <div class="user-modal">
                                                                            @if($image =
                                                                            @file_get_contents('../public/images/user_img/'.$user->user_img))
                                                                            <img @error('photo') is-invalid @enderror
                                                                                src="{{ url('images/user_img/'.$user->user_img) }}"
                                                                                alt="profilephoto"
                                                                                class="img-responsive img-circle">
                                                                            @else
                                                                            <img @error('photo') is-invalid @enderror
                                                                                src="{{ Avatar::create($user->fname)->toBase64() }}"
                                                                                alt="profilephoto"
                                                                                class="img-responsive img-circle">
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-lg-12">
                                                                            <h4 class="text-center">
                                                                                {{ $user->fname }}{{ $user->lname }}
                                                                            </h4>
                                                                            <div class="button-list mt-4 mb-3">
                                                                                <button type="button"
                                                                                    class="btn btn-primary-rgba"><i
                                                                                        class="feather icon-email mr-2"></i>{{ $user->email }}</button>
                                                                                <button type="button"
                                                                                    class="btn btn-success-rgba"><i
                                                                                        class="feather icon-phone mr-2"></i>{{ $user->mobile }}</button>
                                                                            </div>
                                                                            <div class="table-responsive">
                                                                                <table
                                                                                    class="table table-borderless mb-0 user-table">
                                                                                    <tbody>
                                                                                        @isset($user->dob)

                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Date Of Birth :</th>
                                                                                            <td class="p-1">
                                                                                                {{ $user->dob }}</td>
                                                                                        </tr>
                                                                                        @endisset
                                                                                        @isset($user->address)

                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Address :</th>
                                                                                            <td class="p-1">
                                                                                                {{ $user->address}}</td>
                                                                                        </tr>
                                                                                        @endisset
                                                                                        @isset($user->gender)

                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Gender :</th>
                                                                                            <td class="p-1">
                                                                                                {{ $user->gender}}</td>
                                                                                        </tr>
                                                                                        @endisset

                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Role :</th>
                                                                                            <td class="p-1">
                                                                                                {{ $user->role}}</td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Country-State-City</th>
                                                                                            <td class="p-1">
                                                                                                {{ optional($user->country)->name}}-{{ optional($user->state)->name}}-{{ optional($user->city)->name}}
                                                                                            </td>
                                                                                        </tr>
                                                                                        @isset($user->youtube_url)

                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Youtube Url</th>
                                                                                            <td class="p-1">
                                                                                                <a
                                                                                                    href="{{$user->youtube_url}}">{{str_limit($user->youtube_url, '30')}}</a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @endisset

                                                                                        @isset($user->fb_url)

                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Facebook Url</th>
                                                                                            <td class="p-1">
                                                                                                <a
                                                                                                    href="{{$user->fb_url}}">{{str_limit($user->fb_url, '30')}}</a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @endisset

                                                                                        @isset($user->twitter_url)

                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Twitter Url</th>
                                                                                            <td class="p-1">
                                                                                                <a
                                                                                                    href="{{$user->twitter_url}}">{{str_limit($user->twitter_url, '30')}}</a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @endisset

                                                                                        @isset($user->linkedin_url)

                                                                                        <tr>
                                                                                            <th scope="row" class="p-1">
                                                                                                Linkedin Url</th>
                                                                                            <td class="p-1">
                                                                                                <a
                                                                                                    href="{{$user->linkedin_url}}">{{str_limit($user->linkedin_url, '30')}}</a>
                                                                                            </td>
                                                                                        </tr>
                                                                                        @endisset

                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End col -->
    </div>
    <!-- End row -->
</div>

@endsection
@section('script')
<!-- script for datatable start -->
<script>
    $(function () {
        $('#example1').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            'paging': true,
            'lengthChange': true,
            'searching': true,
            'ordering': true,
            'info': true,
            'autoWidth': true
        })
    })
</script>
<script>
    $(document).on("change", ".user", function () {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: 'user/status',
            data: {
                'status': $(this).is(':checked') ? 1 : 0,
                'id': $(this).data('id')
            },
            success: function(data){
            var warning = new PNotify( {
                title: 'success', text:'Status Update Successfully', type: 'success', desktop: {
                desktop: true, icon: 'feather icon-thumbs-down'
                }
              });
              warning.get().click(function() {
                warning.remove();
              });
          }
        });
    })
</script>
<script>
    $("#checkboxAll").on('click', function () {
        $('input.check').not(this).prop('checked', this.checked);
    });
</script>
<!-- script for datatable end -->

@endsection