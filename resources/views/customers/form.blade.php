@section('content')
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
            <a class="btn" href="{{ route('customers.index') }}"><i class="fas fa-chevron-left"></i></a>
        </div>
        <h1>{{$title}}</h1>
      </div>

      <div class="section-body">
        @alert

    	<div class="row">
    	    <div class="col-12">
    	        <div class="card card-primary">
    	            <div class="card-header">
    	                <h4>{{$title}}</h4>
    	            </div>
    	            <div class="card-body">
                        @isset($edit)
                        {{ Form::model($customer, ['route' => [$action, $id], 'enctype' => 'multipart/form-data']) }}
                        @else
    	            	<form method="post" action="{{ $action }}" enctype="multipart/form-data">
                        @endisset
                            @csrf
                            {{ isset($method) ? method_field($method) : '' }}

                            @field([
                'label' => "Nama",
                'name' => "nama",
                'type' => "text",
            ])
@field([
                'label' => "Username",
                'name' => "username",
                'type' => "text",
            ])
@field([
                'label' => "Password",
                'name' => "password",
                'type' => "text",
            ])
@field([
                'label' => "Email",
                'name' => "email",
                'type' => "text",
            ])
@field([
                'label' => "Address",
                'name' => "address",
                'type' => "text",
            ])
@field([
                'label' => "Phone",
                'name' => "phone",
                'type' => "text",
            ])

    		                <div class="form-group row mb-4">
    		                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    		                    <div class="col-sm-12 col-md-7">
    		                        <button class="btn btn-primary">{{ $button }}</button>
    		                    </div>
    		                </div>
    		            </form>
    	            </div>
    	        </div>
    	    </div>
    	</div>
      </div>
    </section>
@endsection
