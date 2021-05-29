@extends('layouts.app')

@push('add-on-meta')
	<meta name="userId" content="{{ $user->id }}">
	<meta name="userName" content="{{ $user->created_at }}">
	<meta name="userGender" content="{{ $user->gender ?? "null" }}">
@endpush

@push('add-on-style')
  <link 
    rel="stylesheet" 
    href="{{ url('css/buyer/account_setting.css') }}">
@endpush

@section('title')
  Pengaturan Akun
@endsection

@section('content')
  <div id="content">
    <div id="collapsedWindow">
      <div id="collapsedSidebar">
        <div 
          class="menu-sidebar" 
          id="MenuUbahProfilSidebar"
          @click="changeSelectedSection(1, 'MenuUbahProfil', 'section-ubah-profil')">
          <div class="menu-sign d-inline-block menu-sign-red"></div>
          <p class="d-inline-block">Ubah Profil</p>
          <hr class="red-hr">
        </div>
        <div 
          class="menu-sidebar" 
          id="MenuUbahPasswordSidebar"
          @click="changeSelectedSection(2, 'MenuUbahPassword', 'section-ubah-password')">
          <div class="menu-sign d-inline-block menu-sign-white"></div>
          <p class="d-inline-block">Ubah Password</p>
          <hr>
        </div>
        <div 
          class="menu-sidebar" 
          id="MenuHapusAkunSidebar"
          @click="changeSelectedSection(3, 'MenuHapusAkun', 'section-hapus-akun')">
          <div class="menu-sign d-inline-block menu-sign-white"></div>
          <p class="d-inline-block">Hapus Akun</p>
          <hr>
        </div>
      </div>
      <img 
        id="closeCollapsedWindow"
        src="{{ url("/image/close_button.png") }}"
        @click="hideCollapsedWindow()">
    </div>
    <img 
      id="rightArrow"
      src="{{ url("/image/right_arrow.png") }}"
      @click="showCollapsedWindow()">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2" id="sidebar">
          <div class="d-flex justify-content-center">
            <p id="userName">{{ $user->name }}</p>
          </div>
          <div class="d-flex justify-content-center">
            <p id="memberJoinFrom">Member sejak <span>{{ $user->created_at_month }}</span> {{ $user->created_at_year }}</p>
          </div>

          <div 
            class="menu-sidebar" 
            id="MenuUbahProfil"
            @click="changeSelectedSection(1, 'MenuUbahProfil', 'section-ubah-profil')">
            <div class="menu-sign d-inline-block menu-sign-red"></div>
            <p class="d-inline-block">Ubah Profil</p>
            <hr class="red-hr">
          </div>
          <div 
            class="menu-sidebar" 
            id="MenuUbahPassword"
            @click="changeSelectedSection(2, 'MenuUbahPassword', 'section-ubah-password')">
            <div class="menu-sign d-inline-block menu-sign-white"></div>
            <p class="d-inline-block">Ubah Password</p>
            <hr>
          </div>
          <div 
            class="menu-sidebar" 
            id="MenuHapusAkun"
            @click="changeSelectedSection(3, 'MenuHapusAkun', 'section-hapus-akun')">
            <div class="menu-sign d-inline-block menu-sign-white"></div>
            <p class="d-inline-block">Hapus Akun</p>
            <hr>
          </div>
        </div>
        <div class="col-10" id="mainbar">
          <section 
            class="section-content" 
            id="section-ubah-profil"
            v-show="selectedSection === 1">
            <form 
              id="changeProfileForm" 
              class="mb-2"
              v-on:submit.prevent="submitChangeProfileForm()">
              <h3 class="font-weight-bold">Ubah Profil</h3>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="inputFirstName">Nama depan</label>
                  <input 
                    type="text" 
                    name="firstName" 
                    id="inputFirstName" 
                    class="form-control" 
                    required 
                    value="{{ $user->firstName }}">
                  <small id="errorFirstName" class="d-none">error nama depan</small>
                </div>
                <div class="form-group col-md-6">
                  <label for="inputLastName">Nama belakang</label>
                  <input 
                    type="text" 
                    name="lastName" 
                    id="inputLastName"
                    value="{{ $user->lastName }}"
                    class="form-control">
                  <small id="errorLastName" class="d-none">error nama belakang</small>
                </div>
              </div>
              <div class="form-group">
                <label for="inputBirthDay">Tanggal Lahir (opsional)</label>
                <input 
                  type="date" 
                  class="form-control" 
                  max="{{ $currentDate }}" 
                  id="inputBirthDay" 
                  name="birthDay"
                  value="{{ $user->birthDay }}">
                <small id="errorBirthDay" class="d-none">error tanggal lahir</small>
              </div>
              <div class="form-group">
                <label for="inputPhoneNumber">No HP (opsional)</label>
                <input 
                  type="tel" 
                  class="form-control" 
                  id="inputPhoneNumber" 
                  name="phoneNumber"
                  maxlength="12"
                  minlength="10"
                  pattern="[0]{1}[8]{1}[0-9]{8,10}"
                  value="{{ $user->phoneNumber ?? "" }}"
                  placeholder="08xxxxxxxxxx">
                <small id="errorPhoneNumber" class="d-none">error NoHP</small>
              </div>
              <label for="">Jenis Kelamin (opsional)</label> <br>
              <div class="form-check form-check-inline">
                <input 
                  class="form-check-input" 
                  type="radio" 
                  name="gender" 
                  id="inputRadioLK" 
                  value="male" 
                  :checked="userGender == 'male'">
                <label 
                  class="form-check-label" 
                  for="inputRadioLK">Laki-laki</label>
              </div>
              <div class="form-check form-check-inline">
                <input 
                  class="form-check-input" 
                  type="radio" 
                  name="gender" 
                  id="inputRadioPR" 
                  value="female" 
                  :checked="userGender == 'female'">
                <label 
                  class="form-check-label" 
                  for="inputRadioPR">Perempuan</label>
              </div>
              <div class="form-check form-check-inline">
                <small id="errorGender" class="d-none">error Jenis Kelamin</small>
              </div>
              <div class="btn-container d-flex flex-row-reverse">
                <button type="submit" class="btn btn-danger">Ubah Profil</button>
              </div>
            </form>
          </section>
          <section 
            class="section-content" 
            id="section-ubah-password"
            v-show="selectedSection === 2">
            <form 
              id="changePasswordForm"
              v-on:submit.prevent="submitChangePasswordForm()">
              <h3 class="font-weight-bold">Ubah Password</h3>
              <div class="form-group row">
                <label 
                  for="inputOldPassword" 
                  class="col-sm-2 col-form-label">Password Lama</label>
                <div class="col-sm-12">
                  <input 
                    type="password" 
                    class="form-control" 
                    id="inputOldPassword" 
                    minlength="8" 
                    required>
                  <small 
                    id="errorOldPassword" 
                    class="d-none">error Old Password</small>
                </div>
              </div>
              <div class="form-group row">
                <label 
                  for="inputNewPassword" 
                  class="col-sm-12 col-form-label">Password Baru</label>
                <div class="col-sm-12">
                  <input 
                    type="password" 
                    class="form-control" 
                    id="inputNewPassword" 
                    minlength="8" 
                    v-on:keyup="inputNewPasswordKeyupListener" 
                    required>
                  <small 
                    id="errorNewPassword" 
                    class="d-none">error New Password</small>
                </div>
              </div>
              <div class="form-group row">
                <label 
                  for="inputRetypeNewPassword" 
                  class="col-sm-12 col-form-label">Ulangi Password Baru</label>
                <div class="col-sm-12">
                  <input 
                    type="password" 
                    class="form-control" 
                    id="inputRetypeNewPassword" 
                    minlength="8" 
                    v-on:keyup="inputRetypeNewPasswordKeyupListener"
                    required>
                  <small 
                    id="errorRetypeNewPassword" 
                    class="d-none">error Retype New Password</small>
                </div>
              </div>
              <div 
                class="btn-container d-flex flex-row-reverse">
                <button 
                  type="submit" 
                  class="btn btn-danger" 
                  id="btnSubmitChangePassword">Ubah Password</button>
              </div>
            </form>
          </section>
          <section 
            class="section-content" 
            id="section-hapus-akun"
            v-show="selectedSection === 3">
            <h3 class="font-weight-bold">Hapus Akun</h3>
            <div class="d-flex justify-content-between">
              <p>Ingin menghapus akun Vervays mu?</p>
              <p 
                id="deleteAccount"
                @click="deleteAccount()">Hapus Akun</p>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('add-on-script')
  <script src="{{ url('js/view/buyer/account_setting.js') }}" type="text/javascript"></script>
@endpush