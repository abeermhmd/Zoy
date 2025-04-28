@extends('website.myAccountLayout')
@section('contentMyAccount')
<div class="col-lg-9">
    <div class="cont-saved wow fadeInUp">
        <div class="head-account">
            <p>2 @lang('website.Saved Cards')</p>
            <a class="btn-site btnReg" data-bs-toggle="modal" data-bs-target="#modalPaymet"><span>@lang('website.Add New Card')</span></a>
        </div>
        <div class="item-card">
            <div class="name-card">
                <figure><i class="icon icon-master-card"></i></figure>
                <div>
                    <p>Rehbar Raza Naqvi</p>
                    <span>Ending in 5539</span>
                </div>
            </div>
            <div class="expires-card">
                <p>Expires on 19/10/2025</p>
            </div>
            <div class="">
                <a class="btn-site btn-delete btnReg" data-bs-toggle="modal"
                    data-bs-target="#modalDelete"><span>@lang('website.Delete')</span></a>
            </div>
        </div>
        <div class="item-card">
            <div class="name-card">
                <figure><i class="icon icon-visa"></i></figure>
                <div>
                    <p>Raza Naqvi Rehbar</p>
                    <span>Ending in 5539</span>
                </div>
            </div>
            <div class="">
                <p>Expires on 08/12/2027</p>
            </div>
            <div class="">
                <a class="btn-site btn-delete btnReg" data-bs-toggle="modal"
                    data-bs-target="#modalDelete"><span>@lang('website.Delete')</span></a>
            </div>
        </div>
        <div class="item-card">
            <div class="name-card">
                <figure><i class="icon icon-sumsung-pay"></i></figure>
                <div>
                    <p>Rehbar Naqvi Raza</p>
                    <span>Ending in 4852</span>
                </div>
            </div>
            <div class="">
                <p>Expires on 14/02/2029</p>
            </div>
            <div class="">
                <a class="btn-site btn-delete btnReg" data-bs-toggle="modal"
                    data-bs-target="#modalDelete"><span>@lang('website.Delete')</span></a>
            </div>
        </div>
    </div>
    <div class="cont-saved wow fadeInUp" style="display: none">
        <div class="cont-empty">
            <figure><i class="icon-no-saved"></i></figure>
            <h5>@lang('website.No Saved Card')</h5>
            <p>@lang('website.No saved cards available') . <br />@lang('website.Please add a card to proceed') .</p>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPaymet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
    role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>@lang('website.Add Card')</h3>
                <button type="button" data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="inf-payment">
                    <p>@lang('website.Your payment information is safe with us') !</p>
                    <ul>
                        <li><i class="icon icon-visa"></i></li>
                        <li><i class="icon icon-master-card"></i></li>
                    </ul>
                </div>
                <form class="form-payment">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="@lang('website.Card holder name')" />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="@lang('website.Card number')" />
                    </div>
                    <div class="d-flex">
                        <div class="date-card">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="mm" />
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="yy" />
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="CVV" />
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn-site"><span>@lang('website.Add')</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
    role="dialog">
    <div class="wsmall modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="content-succes-sign">
                    <h3>@lang('website.Delete Card')</h3>
                    <p>@lang('website.Are you sure want to delete card')</p>
                    <ul>
                        <li><a class="btn-site btn-cancel" data-bs-dismiss="modal"
                                aria-label="Close"><span>@lang('website.no')</span></a></li>
                        <li><a class="btn-site" data-bs-dismiss="modal" aria-label="Close"><span>@lang('website.yes')</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
