<?php

?>

@extends('admin.layouts.app')
@section('admin_content')
    <div class="card" style="margin-top: 60px;">
        <div class="card-body">
            <div class="row">
                <div class="container">
                    @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{session('success')}}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="col-12">
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{$error}}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-12 col-12 m-t-30">
                    <h5 class="text-center">Userlarni tasdiqlash</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-1 main-wrapper">
        <div class="row">
            <div class="col-md-12 col-12 p-2">
                <table class="table mb-0 example1">
                    <thead>
                    <tr>
                        <th style="border: 1px solid">ID</th>
                        <th style="border: 1px solid">User</th>
                        <th style="border: 1px solid">Video</th>
                        <th style="border: 1px solid">Apteka</th>
                        <th style="border: 1px solid">Test</th>
                        <th style="border: 1px solid">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <form id="user_check_{{ $user->id }}" action="{{route('lms-user-check')}}" method="POST">
                                @csrf
                          <td style="border: 1px solid">
                              <input type="hidden" name="user_id" value="{{$user->id}}">
                              {{$user->id}}
                          </td>
                          <td style="border: 1px solid">{{$user->first_name}},{{$user->last_name}} |{{$user->username}}|</td>
                          <td style="border: 1px solid">
                              <input type="checkbox" value="1" class="" id="video_{{$user->id}}" name="video" required data-form-id="{{ $user->id }}">
                              @error('video')
                              <div style="color: red" class="form-text">{{$message}}</div>
                              @enderror
                          </td>
                          <td style="border: 1px solid">
                              <input type="checkbox" value="1" class="" id="one_day_apteka_{{$user->id}}" name="one_day_apteka" required data-form-id="{{ $user->id }}">
                              @error('one_day_apteka')
                              <div style="color: red" class="form-text">{{$message}}</div>
                              @enderror
                          </td>
                          @foreach($test as $userData)
                              @if($user->id == $userData['user_id'])
                                        <input type="hidden" name="test" value="{{$userData['foiz']}}">
                                  <td style="border: 1px solid">{{ $userData['foiz'] }}</td>
                              @endif
                          @endforeach
                          <td style="border: 1px solid black;">
                              <!-- Check success -->
                              <button type="button" class="btn btn-success col-6 confirm-action" data-action="submit" data-form-id="{{ $user->id }}">
                                  <i class="fas fa-check-double" style="color: white"></i> Tasdiqlash
                              </button>

{{--                              <!-- Delete Button -->--}}
{{--                              <button type="button" class="btn btn-danger col-6 delete-action" data-action="delete" data-form-id="{{ $user->id }}">--}}
{{--                                  <i class="fas fa-times" style="color: white"></i> Delete--}}
{{--                              </button>--}}
                          </td>
                            </form>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('admin_script')
    <script type="text/javascript">
        $('.confirm-action').click(function() {
            var formId = $(this).data('form-id');
            var isVideoChecked = $('#video_' + formId).prop('checked');
            var isOneDayAptekaChecked = $('#one_day_apteka_' + formId).prop('checked');

            // Check if the required checkboxes are checked
            if (isVideoChecked && isOneDayAptekaChecked) {
                var userResponse = confirm('Sizni ishonchingiz komilmi?');
                if (userResponse) {
                    // If checkboxes are checked and user confirms, submit the form
                    $('#user_check_' + formId).submit();
                }
            } else {
                // If checkboxes are not checked, show an alert
                alert('Video va Bir kun dorixonada turganini belgilang!');
            }
        });

        $('.delete-action').click(function() {
            var formId = $(this).data('form-id');
            var isVideoChecked = $('#video_' + formId).prop('checked');
            var isOneDayAptekaChecked = $('#one_day_apteka_' + formId).prop('checked');

            // Check if the required checkboxes are checked
            if (isVideoChecked && isOneDayAptekaChecked) {
                var userResponse = confirm('Sizni ishonchingiz komilmi?');
                if (userResponse) {
                    // If checkboxes are checked and user confirms, submit the form
                    $('#user_check_' + formId).submit();
                }
            } else {
                // If checkboxes are not checked, show an alert
                alert('Video va Bir kun dorixonada turganini belgilang!');
            }
        });
    </script>
@endsection
