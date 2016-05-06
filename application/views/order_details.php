<div class="main-content ng-scope" ng-controller="orderDetailsCtrl as self" ng-init="initData()">
    <uib-alert type="{{alert.type}}" close="closeAlert()" ng-if="show" dismiss-on-timeout="2000" class="alert">{{alert.msg}}</uib-alert>
    <div id="main_loading" ng-show="loading" class="loading_overlay">
        <div class="loading_fixed_wrap">
            <img class="loading_img" src="/avtoplin/resources/images/loading_2.gif" />
            <span class="loading_text">Loading</span>
        </div>
    </div>
    <div class="wrap-content container fade-in-up ng-scope" style="padding-bottom: 0px;" id="container">
        <section id="page-title" class="padding-top-15 padding-bottom-15">
            <div class="row">
                <div class="col-sm-7">
                    <h1 class="mainTitle">PODROBNOSTI</h1>
                    <span class="mainDescription">Order ID: {{orderDetails.id}}</span>
                </div>
            </div>
        </section>
        <div style="margin:15px 0px 10px 0px;">
            <button type="button" style="float:right; margin:0px 0px 10px 10px;" class="btn btn-wide btn-primary" ng-show="(orderDetails.order_status_id == 5 || orderDetails.order_status_id == 6) ? true : false" ng-click="openInvoces(orderDetails.invoices_id, $event)">Poglej račun</button>
            <button type="button" style="float:right; margin:0px 0px 10px 10px;" class="btn btn-wide btn-primary" ng-disabled="(orderDetails.order_status_id == 5 || orderDetails.order_status_id == 6) ? true : false" ng-click="openStatusModal(orderDetails, $event)">Označi kot</button>
            <button type="button" style="float:right; margin:0px 0px 10px 10px;" class="btn btn-wide btn-primary" ng-click="showSendSMSModal(orderDetails)">Pošlji SMS</button>
            <button type="button" style="float:right; margin:0px 0px 10px 10px;" class="btn btn-wide btn-primary" ng-click="showPonudbaModal($event)">Ponudba</button>
            <button type="button" style="float:right; margin:0px 0px 10px 10px;" class="btn btn-wide btn-primary" ng-click="oldOfferModal(orderDetails.id, $event)">Stare ponudbe</button>
            <button type="button" style="float:right; margin:0px 0px 10px 10px;" class="btn btn-wide btn-primary" ng-click="showHistoryModal(orderDetails.id, $event)">Zgodovina</button>
            <button type="button" style="float:right; margin:0px 0px 10px 10px;" class="btn btn-wide btn-primary" ng-click="isDisabled = !isDisabled; changeDate();">{{urediBtn}}</button>
        </div>
    </div>
    <div class="container-fluid container-fullw bg-white" style="border-top: 1px solid #eee;">
        <form ng-submit="submit_form(orderDetails)">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>
                            Ime in priimek
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-user"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Ime in priimek" ng-model="orderDetails.customer">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Naslov
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-home"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Naslov" ng-model="orderDetails.address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Poštna številka
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-envelope"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Poštna številka" ng-model="orderDetails.postal_code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Kraj
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-building-o"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Kraj" ng-model="orderDetails.city">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Telefonsko številko
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-phone"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Telefonsko številko" ng-model="orderDetails.telephone">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            E-naslov
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">@</span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="E-naslov" ng-model="orderDetails.email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Model avta
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-bus"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Model avta" ng-model="orderDetails.car_model">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Datum vpisa
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                            <input required type="text" class="form-control" placeholder="Datum vpisa" uib-datepicker-popup="{{format}}" ng-model="orderDetails.date_created" ng-disabled="true" ng-click="open1()" is-open="opened1"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" id="statusNarocila">
                        <label for="form-field-select-2">
                            Status naročila
                        </label>
                        <select required ng-disabled="true" class="cs-select cs-skin-slide" ng-model="orderDetails.name">
                            <option ng-repeat="name in names" value="{{name.name}}" ng-selected="orderDetails.name == name.name">{{name.name}}</option>
                        </select>
                    </div>
                    <div class="form-group" ng-show="orderDetails.order_status_id == 7">
                        <label>
                            Arhiv razlog
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="ti ti-harddrives"></i> </span>
                            <input required type="text" ng-disabled="true" class="form-control" placeholder="Arhiv razlog" ng-model="orderDetails.archive_comment">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Število KM na leto
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="ti ti-truck"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Število KM na leto" ng-model="orderDetails.droved_km_year">
                        </div>
                    </div>
                    <div class="form-group" id="gorivo">
                        <label for="form-field-select-2">
                            Gorivo
                        </label>
                        <select required ng-disabled="true" class="cs-select cs-skin-slide" ng-model="orderDetails.fuel">
                            <option ng-repeat="fuel in fuels" ng-click="orderDetails.bencin = fuel.price" value="{{name.name}}" ng-selected="(fuel.name == orderDetails.fuel) ? true : false; (fuel.name == orderDetails.fuel) ? orderDetails.bencin = fuel.price : false">{{ fuel.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>
                            Mesečna poraba goriva v EUR
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-eur"></i> </span>
                            <input required type="text" ng-model="orderDetails.fuel_month_expences" placeholder="Mesečna poraba goriva v EUR" ng-disabled="isDisabled" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Povprečna poraba na 100KM
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-calculator"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Povprečna poraba na 100KM" ng-model="orderDetails.average_consumption">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Komentar
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-comment"></i> </span>
                            <input required type="text" ng-disabled="isDisabled" class="form-control" placeholder="Komentar"  ng-model="orderDetails.customer_profile">
                        </div>
                    </div>
                    <div ng-show="(orderDetails.name == 'Rezervirano') ? true : false">
                        <div class="form-group">
                            <label>
                                Datum rezervacije
                            </label>
                            <div class="input-group">
                                <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                <input required type="text" class="form-control" placeholder="Datum rezervacije" uib-datepicker-popup="{{format}}" ng-model="orderDetails.reservation_date" ng-disabled="isDisabled" ng-click="open2()" is-open="opened2"/>
                            </div>
                        </div>
                        <div class="form-group" ng-show="!isDisabled" >
                            <label>
                                Čas rezervacije
                            </label>
                            <uib-timepicker ng-model="orderDetails.time" hour-step="1" minute-step="15" show-meridian="false"></uib-timepicker>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4>Amortizacija</h4>
                    </br>
                    <div class="form-group">
                        <label>
                            Cena bencina
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-eur"></i> </span>
                            <input required type="text" ng-model="orderDetails.bencin" placeholder="Cena bencina" disabled class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Cena avtoplina
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-eur"></i> </span>
                            <input required type="text" ng-model="orderDetails.avtoplin" placeholder="Cena avtoplina" disabled class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Poraba na 100 KM
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="fa fa-calculator"></i> </span>
                            <input required type="text" disabled class="form-control" placeholder="Poraba na 100 KM" ng-model="orderDetails.average_consumption">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Prevoženih KM na leto
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon"> <i class="ti ti-car"></i> </span>
                            <input required type="text" disabled class="form-control" placeholder="Prevoženih KM na leto" ng-model="orderDetails.droved_km_year">
                        </div>
                    </div>
                    <div style="background-color: rgba(225,225,225,1); padding: 10px 0px 5px 10px;">
                        <label>PRIHRANEK NA LETO: {{orderDetails.prihranek}} EUR</label>
                    </div>
                    </br>
                    </br>
                    </br>
                    <button type="submit" ng-disabled="isDisabled" style="float:right;" class="btn btn-wide btn-primary">Shrani</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container-fluid container-fullw padding-bottom-10">
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel panel-white no-radius">
                        <div class="panel-heading border-light">
                            <h4 class="panel-title">UTM</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group" style="display: table-caption;" ng-repeat="(key, val) in orderDetails.utm">
                                <label st>
                                    {{key}}
                                </label>
                                <input type="text" disabled ng-model="val">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="panel panel-white no-radius">
                        <div class="panel-heading border-bottom">
                            <h4 class="panel-title">Old orders</h4>
                        </div>
                        <div class="panel-body" style="max-height: 360px; overflow-y: auto; overflow-x: auto;">
                            <table class="table table-hover" id="sample-table-1" >
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="hidden-xs">Stranka</th>
                                        <th class="hidden-xs">E-naslov</th>
                                        <th class="hidden-xs">Datum ustvarjanja</th>
                                        <th class="hidden-xs">Status</th>
                                        <th class="hidden-xs">Telefon</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="order in oldOrderDetails track by $index">
                                        <td class="center">{{$index + 1}}</td>
                                        <td class="left">{{order.customer}}</td>
                                        <td class="left">{{order.email}}</td>
                                        <td class="hidden-xs">{{order.date_created}}</td>
                                        <td class="hidden-xs">{{order.name}}</td>
                                        <td class="hidden-xs">{{order.telephone}}</td>
                                        <td class="center" ng-click="openOldOrdersModal($event, order)">
                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                <a href="#" class="btn btn-transparent btn-xs" tooltip-placement="top" uib-tooltip="Detalje"><i class="fa fa-search"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="container-fluid container-fullw bg-white" style="margin-bottom:30px">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="over-title margin-bottom-15">Zgodovina leadov</h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th class="left">Uporabnik</th>
                                <th class="left">Datum spremembe</th>
                                <th class="left">Spremembe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="histor in orderHistory | orderBy: 'histor[$index].date_added'" >
                                <td class="center">{{$index}}</td>
                                <td class="left">{{history[$index].username}}</td>
                                <td class="center">{{history[$index].date_added}}</td>
                                <td>
                                    <table class="table table-hover" style="border: 1px solid #eee !important; border-bottom: 0px !important; background-color: #f7f7f8 !important;">
                                        <thead>
                                            <tr>
                                                <th class="center" ng-show="(key == 'reservation_flag' || key == 'realization_flag') ? false : true"  ng-repeat="(key, ch) in histor.changes"> {{key}} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="center" ng-show="(key == 'reservation_flag' || key == 'realization_flag') ? false : true" ng-repeat="(key, ch_val) in histor.changes"> {{ch_val}} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>
    <div class="container-fluid container-fullw bg-white" style="border-top: 1px solid #eee;">
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="over-title margin-bottom-15">Zgodovina poslane ponudbe </h4>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="center">Uporabnik</th>
                                <th class="center">Datum spremembe</th>
                                <th class="left">Spremembe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="histor in offerHistory | orderBy: 'histor[$index].date_added'" >
                                <td class="center">{{history[$index].username}}</td>
                                <td class="center">{{history[$index].date_added}}</td>
                                <td>
                                    <table class="table table-hover" style="border: 1px solid #eee !important; border-bottom: 0px !important; background-color: #f7f7f8 !important;">
                                        <thead>
                                            <tr>
                                                <th class="center" ng-show="(key == 'reservation_flag' || key == 'realization_flag') ? false : true"  ng-repeat="(key, ch) in histor.changes"> {{key}} </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="center" ng-show="(key == 'reservation_flag' || key == 'realization_flag') ? false : true" ng-repeat="(key, ch_val) in histor.changes"> {{ch_val}} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
        </div>
    </div>
</div>
