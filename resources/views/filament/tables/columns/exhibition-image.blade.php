@if($getState())
    @php
        $imageUrl = asset(str_replace('public/', '', $getState()));
    @endphp
    <div style="padding: 5px 0;">
        <img src="{{ $imageUrl }}"
             style="width: 60px !important;
                    height: 60px !important;
                    min-width: 60px !important;
                    min-height: 60px !important;
                    max-width: 60px !important;
                    max-height: 60px !important;
                    object-fit: cover;
                    border-radius: 6px;
                    margin: 0 auto;
                    border: 1px solid #e5e7eb;
                    display: block;">
    </div>
@else
    <span>-</span>
@endif
