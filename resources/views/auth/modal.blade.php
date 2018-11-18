<div class="modal" id="login-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content container">
            <div class="row">
                <div class="col-sm-12 text-right">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h3>{{ __('system.login') }}</h3>
                    @include('partials.error')
                    {!! form($login) !!}
                </div>
                <div class="col-sm-12 col-md-6">
                    <h3>{{ __('system.register') }}</h3>
                    @include('partials.error')
                    {!! form($register) !!}
                </div>
            </div>
        </div>
    </div>
</div>