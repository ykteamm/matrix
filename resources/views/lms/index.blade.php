<?php

use App\Models\Pharmacy;
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
                            <div id="user_check_{{ $user->id }}">
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

                              <!-- Modal -->
                              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-xl">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Botga ro'yxatdan o'tkazish</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              <form action="{{route('lms-user-check')}}" method="POST">
                                                  @csrf
                                                  <input type="hidden" name="user_id" value="{{$user->id}}">
                                                  <input type="hidden" name="video" value="1">
                                                  <input type="hidden" name="one_day_apteka" value="1">
                                                  @foreach($test as $userData)
                                                      @if($user->id == $userData['user_id'])
                                                          <input type="hidden" name="test" value="{{$userData['foiz']}}">
                                                      @endif
                                                  @endforeach

                                                  <div class="row mb-5 mt-5 pt-2 pb-2" style="border: 1px solid black; border-radius:15px;">
                                                      <div class="col-md-4">
                                                          <div class="mt-4">
                                                              <img id="avatarImg" width="200" height="50px" class="avatar-img" src="https://academy.novatio.uz/storage/{{$user->image}}" alt="Profile Image">
                                                          </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                          <div class="mt-4">
                                                              <img id="avatarImg" width="200" height="50px" class="avatar-img" src="https://academy.novatio.uz/storage/{{$user->passport_image}}" alt="Profile Image">
                                                          </div>
                                                      </div>
                                                      <div class="col-md-4">
                                                          <div class="widget settings-menu">
                                                              <ul>
                                                                  <li class="nav-item">
                                                                      <a class="nav-link active">
                                                                          <i class="far fa-user"></i>
                                                                          <span>{{$user->first_name}} {{$user->last_name}}</span>
                                                                      </a>
                                                                  </li>
                                                                  <li class="nav-item">
                                                                      <a class="nav-link">
                                                                          <i class="fas fa-cog"></i>
                                                                          <span>{{$user->birthday}}</span>
                                                                      </a>
                                                                  </li>
                                                                  <li class="nav-item">
                                                                      <a class="nav-link">
                                                                          <i class="far fa-check-square"></i>
                                                                          <span>{{$user->region_name}}, {{$user->district_name}}</span>
                                                                      </a>
                                                                  </li>
                                                                  <li class="nav-item">
                                                                      <a class="nav-link">
                                                                          <i class="far fa-list-alt"></i>
                                                                          <span>Elchi</span>
                                                                      </a>
                                                                  </li>
                                                                  <li class="nav-item">
                                                                      <a class="nav-link">
                                                                          <i class="far fa-bell"></i>
                                                                          <span>{{$user->phone}}</span>
                                                                      </a>
                                                                  </li>
                                                              </ul>
                                                          </div>
                                                      </div>

                                                      @php
                                                          $pharmacy = Pharmacy::where('region_id',$user->region_id)->get();
                                                      @endphp

                                                      <div class="col-md-12 mt-5">
                                                          <div class="row">
                                                              <div class="col-md-4 col-sm-4 col-md-2 mb-3">
                                                                  <select class="form-control form-control-sm" name="pharma_id" required>
                                                                      <option value="">Apteka tanlang</option>
                                                                      @foreach($pharmacy as $pharm)
                                                                      <option value="{{$pharm->id}}">{{$pharm->name}}</option>
                                                                      @endforeach
                                                                  </select>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4 col-md-2 mb-3">
                                                                  <select class="form-control form-control-sm" name="teacher_id" required>
                                                                      <option value="">Ustoz tanlang</option>
                                                                      @foreach($teachers as $teacher)
                                                                      <option value="{{$teacher->id}}">{{$teacher->user_first_name}} {{$teacher->user_last_name}}</option>
                                                                      @endforeach
                                                                  </select>
                                                              </div>
                                                              <div class="col-md-4 col-sm-4 col-md-2 mb-3">
                                                                  <input id="timepicker" type="time" timeformat="24h" class="form-control form-control-sm" name="start_work" required>
                                                                  <input id="timepicker" type="time" timeformat="24h" class="form-control form-control-sm" name="end_work" required>
                                                              </div>

                                                          </div>
                                                      </div>

                                                      <div class="col-md-12 mt-5">
                                                          <div class="row">
                                                              <div class="col-md-6 col-sm-4 col-md-2 mb-3">
                                                                  <button type="submit" class="btn btn-block btn-outline-primary active">Qabul qilish </button>
                                                              </div>
                                                              <div class="col-md-6 col-sm-4 col-md-2 mb-3">
                                                                  <button type="button" class="btn btn-block btn-outline-warning active" onclick="cancel(`554`)">Bekor qilish </button>
                                                              </div>
                                                          </div>
                                                          <div class="col-12 col-sm-4 col-md-2 col-xl mb-3 mb-1 d-none input554">
                                                              <input type="textarea" class="form-control" name="comment554" placeholder="Izoh yozing...">
                                                          </div>
                                                      </div>
                                                  </div>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
{{--                              <!-- Delete Button -->--}}
{{--                              <button type="button" class="btn btn-danger col-6 delete-action" data-action="delete" data-form-id="{{ $user->id }}">--}}
{{--                                  <i class="fas fa-times" style="color: white"></i> Delete--}}
{{--                              </button>--}}
                          </td>
                            </div>
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
        // $('.confirm-action').click(function() {
        //     var formId = $(this).data('form-id');
        //     var isVideoChecked = $('#video_' + formId).prop('checked');
        //     var isOneDayAptekaChecked = $('#one_day_apteka_' + formId).prop('checked');
        //
        //     // Check if the required checkboxes are checked
        //     if (isVideoChecked && isOneDayAptekaChecked) {
        //         var userResponse = confirm('Sizni ishonchingiz komilmi?');
        //         if (userResponse) {
        //             // If checkboxes are checked and user confirms, submit the form
        //             $('#user_check_' + formId).submit();
        //         }
        //     } else {
        //         // If checkboxes are not checked, show an alert
        //         alert('Video va Bir kun dorixonada turganini belgilang!');
        //     }
        // });

        $('.confirm-action').click(function() {
            var formId = $(this).data('form-id');
            var isVideoChecked = $('#video_' + formId).prop('checked');
            var isOneDayAptekaChecked = $('#one_day_apteka_' + formId).prop('checked');

            // Check if the required checkboxes are checked
            if (isVideoChecked && isOneDayAptekaChecked) {
                var userResponse = confirm('Sizni ishonchingiz komilmi?');
                if (userResponse) {
                    // If checkboxes are checked and user confirms, open the modal
                    $('#exampleModal').modal('show');
                }
            } else {
                // If checkboxes are not checked, show an alert
                alert('Video va Bir kun dorixonada turganini belgilang!');
            }
        });

    </script>
@endsection
