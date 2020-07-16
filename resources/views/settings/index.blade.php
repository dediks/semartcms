@extends('layouts.app')

@section('title', 'Setting Page')

@section('content')
    @content([
        'title' => 'Setting',
        'breadcrumb' => ['Settings'],
        'card_default' => true,
    ])
    <div class="card">
        {{-- <h5 class="card-header">Invite People to this Project</h5> --}}
        <div class="card-body">
          <h6>Invite People to this Project</h6>
          <p class="card-text">You can invite someone to contribute into your project</p>
          <div class="form-inline">
            <div class="form-group mr-2">
              <label for="inputEmail" class="sr-only">email</label>
              <input type="email" name="email" class="form-control" id="email-inputed" placeholder="Input an email" required>
            </div>
            {{-- <div class="form-group mr-4">
              <select name="role-selected" id="role-selected" class="form-control">
                <option value="">Select role</option>
                @isset($roles)
                  @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>                  
                  @endforeach                  
                @endisset
              </select>
            </div> --}}
            <div class="form-group">
              <button type="button" class="btn btn-primary mb-2" id="invite-user">Set now</button>
            </div>
          </div>
          <div class="mt-2">
            <span class="help-text"></span>
          </div>
        </div>
      </div>

    @endcontent
@endsection
@push('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    function runAjax(url, data){
      $.ajax({
        url: url,
        type : "post",
        data : data,
        success: function(e){
          $('.help-text').fadeIn().html(e);
        },
        error: function (err) {
          console.log("error");
          console.log(err)
          if (err.status == 422) { 
            $('.help-text').fadeIn().html(err.responseJSON.message);
          }
        }
      });
    }

    $('#invite-user').click(function(e){
        url = "/invite/store";
        let email = $('#email-inputed').val();
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        data = {
          _token: CSRF_TOKEN,
          email: email,
        },

        runAjax(url, data);
    });
</script>
@endpush
