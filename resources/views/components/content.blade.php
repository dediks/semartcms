<section {{ isset($id) ? 'id='.$id.' ' : '' }}class="section{{ isset($section_class) ? ' ' . $section_class : ''}}">
  <div class="section-header">
    @if(isset($back) && $back)
    <div class="section-header-back">
        <a class="btn" href="{{ $back }}"><i class="fas fa-chevron-left"></i></a>
    </div>
    @endif
    <h1>{{ $title }}</h1>

    @stack('section-button')
    
    @if(isset($btn_create) || isset($custom_btn_create))
        <div class="section-header-button">
            @isset($custom_btn_create)
                {{ $custom_btn_create }}
            @else
                <a href="{{ $btn_create['route'] }}" class="btn btn-primary btn-icon icon-right">
                    {{ $btn_create['text'] ?? 'Create' }} <i class="{{  $btn_create['icon'] ?? 'fas fa-plus' }}"></i>
                </a>
            @endif
        </div>
    @endif
    <div class="section-header-breadcrumb">
        @breadcrumb(['segments' => $breadcrumb])
    </div>
  </div>
  <div class="section-body">
    @isset($section_title)
    <h2 class="section-title">{{ $section_title }}</h2>

        @isset($section_description)
        <h6 class="mt-n2">{{ $section_description }}</h6>
        @endisset
    @endisset

    @alert

    @stack('section-body')

    @if(isset($card_default) && $card_default == false)
        {{ $slot }}
    @else
        <div class="row">
            <div class="col-md-12">
                @stack('card-outer-start')
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{ $card_title ?? $title }}</h4>
                    </div>
                    <div class="card-body {{ (!isset($card_padding) ? 'p-0' : '') }}">
                        {{ $slot }}
                    </div>

                    @stack('card-footer')
                </div>
                @stack('card-outer-end')
            </div>
        </div>
    @endif
  </div>
</section>
