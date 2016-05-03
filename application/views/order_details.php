<title> Order details </title>

<div ng-controller="orderDetailsCtrl" ng-init="initData()" class="sample" layout="column" ng-cloak>
    <uib-alert type="{{alert.type}}" close="closeAlert()" ng-if="show" dismiss-on-timeout="5000" style="alert">{{alert.msg}}</uib-alert>
    <header layout-margin>
        <h2>Podrobnosti</h2>
        <h4>Order ID: {{orderDetails.id}}</h4>
        <md-button style="float: right;" ng-show="(orderDetails.order_status_id == 5 || orderDetails.order_status_id == 6) ? true : false" ng-click="openInvoces(orderDetails.invoices_id, $event)" class="md-raised">Poglej račun</md-button>
        <md-button style="float: right;" ng-disabled="(orderDetails.order_status_id == 5 || orderDetails.order_status_id == 6) ? true : false" ng-click="openStatusModal(orderDetails, $event)" class="md-raised">Označi kot</md-button>
        <md-button style="float: right;" ng-click="showSendSMSModal(orderDetails)" class="md-raised">Pošlji SMS</md-button>
        <md-button style="float: right;" ng-click="showPonudbaModal($event)" class="md-raised">Ponudba</md-button>
        <md-button style="float: right;" ng-click="oldOfferModal(orderDetails.id, $event)" class="md-raised">Stare ponudbe</md-button>
        <md-button style="float: right;" ng-click="showHistoryModal(orderDetails.id, $event)" class="md-raised">Zgodovina</md-button>
        <md-button style="background-color: lightgray; float: right;" ng-click="isDisabled = false; changeDate();" ng-show="isDisabled" class="md-raised">Uredi</md-button>
        <md-button style="background-color: lightgray; float: right;" ng-click="isDisabled = true; changeDate();" ng-show="!isDisabled" class="md-raised">Nazaj</md-button>
    </header>
    <form ng-submit="submit_form(orderDetails)">
        <div layout-margin layout="row" class="border" layout-xs="column" layout-sm="column">
            <div flex-gt-sm="70" layout="column" layout-margin class="without_right_border" flex>
                <div layout="row" class="order_details_form" layout-margin layout-align="start start">
                    <div flex="50" flex-gt-sm layout="column" layout-margin layout-align="start start">
                        <div>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_person_black_24px.svg"></md-icon>
                                <input ng-disabled="isDisabled" ng-model="orderDetails.customer" type="text" placeholder="Ime in priimek">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_business_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.address" type="text" placeholder="Naslov">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_local_post_office_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.postal_code" type="text" placeholder="Poštna številka">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_location_city_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.city" type="text" placeholder="Kraj">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_call_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.telephone" type="text" placeholder="Telefonsko stevilko">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_drafts_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.email" type="text" placeholder="E - naslov">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_time_to_leave_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.car_model" type="text" placeholder="Model avta">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_date_range_black_24px.svg"></md-icon>
                                <input required ng-disabled="true" disabled ng-model="orderDetails.date_created" type="text" placeholder="Datum vpisa">
                            </md-input-container>
                        </div>
                    </div>
                    <div flex="50" flex-gt-sm layout="column" layout-margin layout-align="start start">
                        <div>
                            <md-input-container class="md-icon-float md-block" flex-gt-sm>
                                <label>Status narocila</label>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_swap_vertical_circle_black_24px.svg" class="name"></md-icon>
                                <md-select ng-disabled="true" required ng-model="orderDetails.name">
                                    <md-option ng-repeat="name in names" ng-selected="(name.name == orderDetails.name) ? true : false">{{ name.name }}</md-option>
                                </md-select>
                                <div class="md-errors-spacer"></div>
                            </md-input-container>
                            <md-input-container ng-show="orderDetails.order_status_id == 7" class="md-icon-float md-block" flex-gt-sm>
                                <label>Arhiv razlog</label>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_swap_vertical_circle_black_24px.svg" class="name"></md-icon>
                                <input ng-disabled="true" required ng-model="orderDetails.archive_comment" type="text" placeholder="">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_confirmation_number_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.droved_km_year" type="text" placeholder="Število KM na leto">
                            </md-input-container>
                            <md-input-container class="md-icon-float md-block" flex-gt-sm>
                                <label>Gorivo</label>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_local_gas_station_black_24px.svg" class="name"></md-icon>
                                <md-select required ng-disabled="isDisabled" ng-model="orderDetails.fuel">
                                <md-option ng-repeat="fuel in fuels" ng-click="orderDetails.bencin = fuel.price" ng-selected="(fuel.name == orderDetails.fuel) ? true : false; (fuel.name == orderDetails.fuel) ? orderDetails.bencin = fuel.price : false">{{ fuel.name }}</md-option>
                                </md-select>
                                <div class="md-errors-spacer"></div>
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_euro_symbol_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.fuel_month_expences" type="text" placeholder="Mesečna poraba goriva v EUR">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_unarchive_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.average_consumption" type="text" placeholder="Povprečna poraba na 100KM">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_insert_comment_black_24px.svg"></md-icon>
                                <input required ng-disabled="isDisabled" ng-model="orderDetails.customer_profile" type="text" placeholder="Komentar">
                            </md-input-container>
                            <div ng-show="(orderDetails.name == 'Rezervirano') ? true : false">
                                <md-datepicker ng-if="!isDisabled" ng-disabled="false" ng-model="orderDetails.reservation_date" md-placeholder="Datum rezervacije"></md-datepicker>
                                <uib-timepicker ng-if="!isDisabled" style="margin-left: 20px;" ng-model="orderDetails.time" hour-step="1" minute-step="15" show-meridian="false"></uib-timepicker>
                                <md-input-container ng-if="isDisabled" class="md-block" flex-gt-sm>
                                    <md-icon md-svg-src="/avtoplin/resources/images/ic_date_range_black_24px.svg"></md-icon>
                                    <input required ng-disabled="true" disabled ng-model="orderDetails.reservation_date" type="text" placeholder="Datum rezervacije">
                                </md-input-container>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div flex-gt-sm="30" layout="column" layout-margin class="without_left_border" flex>
                <header style="display: table-row;">
                    <h2 style="float: left; display: table-cell;">Amortizacija</h2>
                </header>
                <div layout="row" class="order_details_form" layout-margin layout-align="start start">
                    <div layout="column" layout-margin layout-align="start start">
                        <div>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_local_gas_station_black_24px.svg"></md-icon>
                                <input disabled ng-model="orderDetails.bencin" type="text" placeholder="Cena bencina">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_local_gas_station_black_24px.svg"></md-icon>
                                <input disabled ng-model="orderDetails.avtoplin" type="text" placeholder="Cena avtoplina">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_unarchive_black_24px.svg"></md-icon>
                                <input disabled ng-model="orderDetails.average_consumption" type="text" placeholder="Poraba na 100 KM">
                            </md-input-container>
                            <md-input-container class="md-block" flex-gt-sm>
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_confirmation_number_black_24px.svg"></md-icon>
                                <input disabled ng-model="orderDetails.droved_km_year" type="text" placeholder="Prevoženih KM na leto">
                            </md-input-container>
                            <div class="gray_wrap">
                                <label>PRIHRANEK NA LETO: {{orderDetails.prihranek}} EUR</label>
                            </div>
                            </br>
                            </br>
                            </br>
                            <md-button type="submit" ng-disabled="isDisabled" style="float: right; background-color: #3375BD;" class="left_submit md-raised md-primary">Shrani</md-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if($this->session->userdata['data']['type'] == 'admin') { ?>
        <div layout-margin ng-show="showUTM" class="border">
            <h2> UTM </h2>
            <div flex layout="row" layout-margin>
                <div flex layout="row" layout-margin>
                    <!-- <label ng-repeat="(key, val) in orderDetails.utm">{{key}}: {{val}}</label> -->
                    <div flex layout="column" ng-repeat="(key, val) in orderDetails.utm" layout-margin layout-align="start start">
                        <md-input-container class="md-block" flex-gt-sm>
                            <input disabled ng-model="val" type="text" placeholder="{{key}}">
                        </md-input-container>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </form>
    <div layout="column" class="border" layout-margin layout-xs="column">
        <h2>Old Orders<h2>
        <div class="content_table_wrap_overflow clearfix">
            <table class="content_table default_table">
                <thead>
                    <tr>
                        <th class="left">Stranka</th>
                        <th class="left">E - naslov</th>
                        <th class="left">Datum ustvarjanja</th>
                        <th class="left">Status</th>
                        <th class="left">Telefon</th>
                        <th class="center icon">Detalje</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="order in oldOrderDetails">
                        <td class="left">{{order.customer}}</td>
                        <td class="left">{{order.email}}</td>
                        <td class="left">{{order.date_created}}</td>
                        <td class="left">{{order.name}}</td>
                        <td class="left">{{order.telephone}}</td>
                        <td class="center icon">
                        <button type="button" ng-click="openOldOrdersModal($event, order)" class="glyphicon_btn">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div id="main_loading" ng-show="loading" class="loading_overlay">
        <div class="loading_fixed_wrap">
            <img class="loading_img" src="/avtoplin/resources/images/loading_2.gif" />
            <span class="loading_text">Loading</span>
        </div>
    </div>
</div>

<script type="text/ng-template" id="dateModal.html">
  <md-dialog aria-label="Old order details" class="old_order_modal" ng-cloak>
    <form ng-submit="setDate(date)">
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Datum rezervacije</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
            <md-datepicker ng-model="date" md-placeholder="Datum rezervacije"></md-datepicker>
        </div>
      </md-dialog-content>
      <md-dialog-actions layout="row">
        <md-button type="submit" style="background-color: #3375BD;" class="md-raised md-primary">Dodaj</md-button>
      </md-dialog-actions>
    </form>
  </md-dialog>
</script>

<script type="text/ng-template" id="historyModal.html">
  <md-dialog aria-label="Old order details" class="old_order_modal" ng-cloak>
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Zgodovina spremembe</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
            <div class="content_table_wrap_overflow clearfix">
            <label style="text-align: center;">Zgodovina leadov </label>
            <table class="content_table default_table">
                <thead>
                    <tr>
                        <th class="center">Uporabnik</th>
                        <th class="center">Datum spremembe</th>
                        <th class="left">Spremembe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="histor in orderHistory | orderBy: 'histor[$index].date_added'" >
                        <td class="center">{{history[$index].username}}</td>
                        <td class="center">{{history[$index].date_added}}</td>
                        <td>
                            <table class="content_table default_table">
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
            <label style="text-align: center;">Zgodovina poslane ponudbe </label>
            <table class="content_table default_table">
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
                            <table class="content_table default_table">
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
      </md-dialog-content>
  </md-dialog>
</script>

<script type="text/ng-template" id="statusesModal.html">
  <md-dialog aria-label="Old order details" class="old_order_modal" ng-cloak>
    <form ng-submit="setDate(date)">
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Spremeni status</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
                <div>
                    <div ng-init="collapsed = true" ng-switch="statusHeading">
                        <div ng-switch-when="Spremeni status">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title" href="#" ng-model="collapsed">
                                        <a href="#" >{{statusHeading}}</a>
                                    </h4>
                                </div>
                                <div>
                                <ul style="margin-bottom: 0;" class="list-group" ng-show="collapsed">
                                    <li style="list-style: none; text-align: center;" ng-show="(status_id != 5) ? true : false" ng-repeat="status in next_statuses">
                                        <a href="" ng-click="changeStatus(status)" class="list-group-item">{{status.name}}</a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                        <div ng-switch-when="Račun">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title" href="#" ng-click="backToStatuses()">
                                        <a href="#" >{{statusHeading}}</a><i class="glyphicon glyphicon-chevron-left pull-right"></i>
                                    </h4>
                                </div>
                                <div class="panel-container">
                                    <form name="formRacun"">
                                        <md-input-container md-no-float class="md-block">
                                            <input ng-model="invoice.invoiceNum" type="text" placeholder="Številka računa" required>
                                        </md-input-container>
                                        <md-datepicker ng-model="invoice.date_export" ng-required="true" md-placeholder="Datum izdaje"></md-datepicker>
                                        <md-datepicker ng-model="invoice.date_done" ng-required="true" md-placeholder="Datum opravljene storitve"></md-datepicker>
                                        <md-datepicker ng-model="invoice.date_deadline" ng-required="true" md-placeholder="Rok plačila"></md-datepicker>
                                        <md-button type="submit" ng-click="submitInvoice(invoice)" class="md-raised" ng-disabled="formRacun.$invalid">Potrdi</md-button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div ng-switch-when="Rezervirano">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title" href="#" ng-click="backToStatuses()">
                                        <a href="#" >{{statusHeading}}</a><i class="glyphicon glyphicon-chevron-left pull-right"></i>
                                    </h4>
                                </div>
                                <div class="panel-container">
                                    <form name="formRezervirano" ng-submit="submitDateAndTime(date, time)">
                                        <div style="display: flex;">
                                            <md-datepicker style="align-self: center;" ng-model="date" md-placeholder="Datum" required></md-datepicker>
                                            <uib-timepicker style="margin-left: 20px;" ng-model="time" hour-step="1" minute-step="15" show-meridian="false"></uib-timepicker>
                                        </div>
                                        <md-button type="submit" class="md-raised" ng-disabled="formRezervirano.$invalid">Potrdi</md-button>
                                     </form>
                                </div>
                            </div>
                        </div>
                        <div ng-switch-when="Izbrisano">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title" href="#" ng-click="backToStatuses()">
                                        <a href="#" >{{statusHeading}}</a><i class="glyphicon glyphicon-chevron-left pull-right"></i>
                                    </h4>
                                </div>
                                <div class="panel-container">
                                    <form name="formRezervirano" ng-submit="finalDelete(deleted)">
                                        <div>
                                            <md-checkbox ng-model="deleted" aria-label="Checkbox">Dokončno zbriši</md-checkbox>
                                        </div>
                                        <md-button type="submit" class="md-raised" ng-disabled="formRezervirano.$invalid">Potrdi</md-button>
                                     </form>
                                </div>
                            </div>
                        </div>
                        <div ng-switch-when="Arhiv">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title" href="#" ng-click="backToStatuses()">
                                        <a href="#" >{{statusHeading}}</a><i class="glyphicon glyphicon-chevron-left pull-right"></i>
                                    </h4>
                                </div>
                                <div class="panel-container">
                                    <form name="formArhiv" ng-submit="archive(comment)">
                                        <div>
                                            <textarea ng-model="comment" wrap="soft" placeholder="Razlog..." style="width:470px;"></textarea>
                                        </div>
                                        <md-button type="submit" class="md-raised" ng-disabled="formArhiv.$invalid">Potrdi</md-button>
                                     </form>
                                </div>
                            </div>
                        </div>
                        <div ng-switch-default>
                            <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title" href="#" ng-click="backToStatuses()">
                                            <a href="#" >{{statusHeading}}</a><i class="glyphicon glyphicon-chevron-left pull-right"></i>
                                        </h4>
                                    </div>
                                    <div class="panel-container">
                                        <md-button class="md-raised" ng-click="postStatus()">Potrdi</md-button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </md-dialog-content>
    </form>
  </md-dialog>
</script>

<script type="text/ng-template" id="ponudbaModal.html">
    <md-dialog aria-label="Nova ponudba" ng-cloak>
        <form ng-submit="(offer_form.$valid) ? submitOffer(offer) : false" name="offer_form">
        <md-toolbar style="background-color: #3375BD;">
            <div class="md-toolbar-tools">
            <h2>Nova ponudba</h2>
            <span flex></span>
            <md-button class="md-icon-button" ng-click="cancel()">
                <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
            </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
            <div class="md-dialog-content">
            <h4> Izberite motor </h4>
                <div style="margin-bottom: 20px;" layout="row" ng-class="{validation_error: !offer_form.motor.$valid && offer_form.$submitted}" layout-margin>
                    <div ng-model="offer.motor" name="motor" required class="motors_wrap">
                        <div ng-class="{boxed: !leftHidden}" ng-init="leftHidden = true" ng-click="leftHidden = false; rightHidden = true; offer.motor = 'direct_motor'; offer.lubricant = 0;" class="left">
                            <img ng-class="{selected: leftHidden}" class="checked" src="/avtoplin/resources/images/check-64.png" />
                            <label>Direct</label>
                            <img class="inside_pic" src="/avtoplin/resources/images/direct.jpg" />
                        </div>
                        <div ng-class="{boxed: !rightHidden}" ng-init="rightHidden = true" ng-click="leftHidden = true; rightHidden = false; offer.motor = 'navadni_motor'; offer.lubricant = undefined;" class="right">
                            <img ng-class="{selected: rightHidden}" class="checked" src="/avtoplin/resources/images/check-64.png" />
                            <label>Navadni</label>
                            <img class="inside_pic" src="/avtoplin/resources/images/navadni.jpg" />
                        </div>
                    </div>
                </div>
                <h4> Izberite tip motorja </h4>
                <div layout="row" ng-class="{validation_error: !offer_form.motor_type.$valid && offer_form.$submitted}" layout-margin>
                    <div ng-model="offer.motor_type" name="motor_type" required class="motors_type_wrap">
                        <div ng-class="{boxed: !leftHide}" ng-init="leftHide = true" ng-click="leftHide = false; rightHide = true; rightRightHide = true; offer.motor_type = 'v4';" class="left">
                            <img ng-class="{selected: leftHide}" class="checked" src="/avtoplin/resources/images/check-64.png" />
                            <label class="naslov">V4</label>
                            <img class="inside_pic" src="/avtoplin/resources/images/v4.jpg" />
                        </div>
                        <div ng-class="{boxed: !rightHide}" ng-init="rightHide = true" ng-click="leftHide = true; rightHide = false; rightRightHide = true; offer.motor_type = 'v6';" class="right">
                            <img ng-class="{selected: rightHide}" class="checked" src="/avtoplin/resources/images/check-64.png" />
                            <label class="naslov">V6</label>
                            <img class="inside_pic" src="/avtoplin/resources/images/v6.jpg" />
                        </div>
                        <div ng-init="rightRightHide = true" ng-click="leftHide = true; rightHide = true; rightRightHide = false; offer.motor_type = 'v8';" ng-class="{boxed: !rightRightHide}" class="right">
                            <img ng-class="{selected: rightRightHide}" class="checked" src="/avtoplin/resources/images/check-64.png" />
                            <label class="naslov">V8</label>
                            <img class="inside_pic" src="/avtoplin/resources/images/v8.jpg" />
                        </div>
                    </div>
                </div>
                <h4> Dodatno mazanje ventilov </h4>
                <div ng-class="{disable_section: (offer.motor == 'navadni_motor') ? false : true}">
                    <div layout="row" ng-class="{validation_error: !offer_form.lubricant.$valid && offer_form.$submitted}" layout-margin>
                        <div ng-model="offer.lubricant" name="lubricant" required class="motors_type_wrap">
                            <div ng-class="{boxed: !yes}" ng-init="yes = true" ng-click="yes = false; no = true; offer.lubricant = 1;" class="left">
                                <img ng-class="{selected: yes}" class="checked" src="/avtoplin/resources/images/check-64.png" />
                                <label>DA</label>
                                <img class="inside_pic" src="/avtoplin/resources/images/oil.jpg" />
                            </div>
                            <div ng-class="{boxed: !no}" ng-init="no = true" ng-click="yes = true; no = false; offer.lubricant = 0;" class="right">
                                <img ng-class="{selected: no}" class="checked" src="/avtoplin/resources/images/check-64.png" />
                                <label>NE</label>
                                <img class="inside_pic" src="/avtoplin/resources/images/oil_not.jpg" />
                            </div>
                        </div>
                    </div>
                </div>
                <h4> Subvencija </h4>
                <div layout="row" layout-margin>
                    <div ng-model="offer.discount" ng-init="offer.discount = 1" class="subvencija_wrap">
                        <div ng-class="{boxed: !!offer.discount}" ng-click="(offer.discount == 1) ? offer.discount = 0 : offer.discount = 1; " class="left">
                            <img ng-class="{selected: !offer.discount}" class="checked" src="/avtoplin/resources/images/check-64.png" />
                        </div>
                    </div>
                </div>
            </div>
            <div layout-margin ng-show="offer_form.$submitted && !offer_form.$valid">
                <div class="validation_error_text" ng-show="!offer_form.$valid">Select marked fields</div>
            </div>
            <div id="main_loading" ng-show="loading" class="loading_overlay">
                <div class="loading_fixed_wrap">
                    <img class="loading_img" src="/avtoplin/resources/images/loading_2.gif" />
                    <span class="loading_text">Loading</span>
                </div>
            </div>
        </md-dialog-content>
        <md-dialog-actions ng-switch="show_actions" layout="row">
                <div ng-switch-when="false">
                	<md-button type="submit" style="background-color: #3375BD;" class="md-raised md-primary">Shrani</md-button>
                </div>
        </form>
            <form action="<?php echo base_url(); ?>index.php/actions/viewOffer" target="_blank" method="post" layout="row">
                <input style="display:none;" name="offer_id" value="{{offer_id}}" />
                <div ng-switch-when="true">
                    <md-button type="button" ng-click="sendEmail(offer_id)" style="background-color: #3375BD;" class="md-raised md-primary">Pošlji kot email</md-button>
                </div>
                <div ng-switch-when="true">
                    <md-button type="submit" style="background-color: #3375BD;" class="md-raised md-primary">Poglej</md-buton>
                </div>
            </form>
        </md-dialog-actions>
    </md-dialog>
</script>

<script type="text/ng-template" id="oldOffersModal.html">
  <md-dialog style="max-width: 22%;" aria-label="Old order details" class="old_order_modal" ng-cloak>
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Old Offers</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
         <div class="offer_table">
          <div class="offer_row form">
                <div class="offer_cell">
                    <label>Datum</label>
                </div>
                <div class="offer_cell icon">
                    <label>Poglej</label>
                </div>
                <div class="offer_cell icon">
                    <label>Pošlji kot mail</label>
                </div>
          </div>
          <div ng-repeat="old_offer in oldOffers" class="offer_row">
              <form target="_blank" method="post" action="<?php echo base_url(); ?>index.php/actions/viewOffer">
                <div class="offer_cell">
                    {{old_offer.date_created}}
                </div>
                <div class="offer_cell icon">
                    <input type="hidden" name="offer_id" value="{{old_offer.id}}" />
                    <button type="submit" class="glyphicon_btn">
                        <span class="glyphicon glyphicon-edit"></span>
                    </button>
                </div>
                <div class="offer_cell icon">
                    <button ng-click="sendEmail(old_offer.id)" type="button" class="glyphicon_btn">
                        <span class="glyphicon glyphicon-edit"></span>
                    </button>
                </div>
             </form>
          </div>
        </div>
        </div>
      </md-dialog-content>
  </md-dialog>
</script>

<script type="text/ng-template" id="oldOrderDetailsModal.html">
  <md-dialog aria-label="Old order details" class="old_order_modal" ng-cloak>
    <form ng-submit="updateUser(user)">
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Old Order Details</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
          <div layout-gt-sm="row">
            <div flex="50" layout="column" layout-margin layout-align="start start">
                <div>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_person_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.customer" type="text" placeholder="Ime in priimek">
                    </md-input-container>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_person_outline_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.customer_profile" type="text" placeholder="Profil uporabnika">
                    </md-input-container>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_drafts_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.email" type="text" placeholder="E - naslov">
                    </md-input-container>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_call_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.telephone" type="text" placeholder="Telefonsko stevilko">
                    </md-input-container>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_time_to_leave_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.car_model" type="text" placeholder="Model avta">
                    </md-input-container>
                </div>
            </div>
            <div flex="50" layout="column" layout-margin layout-align="start start">
                <div>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_confirmation_number_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.droved_km_year" type="text" placeholder="Število KM na leto">
                    </md-input-container>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_local_gas_station_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.fuel" type="text" placeholder="Gorivo">
                    </md-input-container>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_date_range_black_24px.svg"></md-icon>
                        <input disabled disabled ng-model="oldOrderDetails.date_created" type="text" placeholder="Datum vpisa">
                    </md-input-container>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_date_range_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.reservation_date" type="text" placeholder="Datum rezervacije">
                    </md-input-container>
                    <md-input-container class="md-block" flex-gt-sm>
                        <md-icon md-svg-src="/avtoplin/resources/images/ic_date_range_black_24px.svg"></md-icon>
                        <input disabled ng-model="oldOrderDetails.realization_date" type="text" placeholder="Datum realizacije">
                    </md-input-container>
                </div>
            </div>
          </div>
        </div>
      </md-dialog-content>
    </form>
  </md-dialog>
</script>

<script type="text/ng-template" id="SendSMSModal.html" >
    <md-dialog aria-label="Pošlji SMS" ng-cloak style="width: 500px; height: 410px;">
        <md-toolbar style="background-color: #3375BD;">
            <div class="md-toolbar-tools">
                <h2>Pošlji SMS</h2>
                <span flex></span>
                <md-button class="md-icon-button" ng-click="cancel()">
                    <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content ng-init="initData()" style="width: 550px; height:400px">
            <div class="content">
                <div id="main_loading" ng-show="loading" class="loading_overlay">
                    <div class="loading_fixed_wrap">
                        <img class="loading_img" src="/avtoplin/resources/images/loading_2.gif" />
                        <span class="loading_text">Loading</span>
                    </div>
                </div>
                <form name="formSMS" ng-submit="sendSMS()">
                    <div class="row">
                        <div class="col-md-4">
                            <md-input-container class="md-block" style="width:120px;">
                                <label>SMS Template</label>
                                <md-select ng-model="selectedSMSTemplate" ng-change="changeTemplate()">
                                    <md-option ng-repeat="option in smsTemplates" value="{{option.id}}">{{option.name}}</md-option>
                                </md-select>
                            </md-input-container>
                        </div>
                        <div class="col-md-4">
                            <md-input-container class="md-block">
                                <md-icon md-svg-src="/avtoplin/resources/images/ic_call_black_24px.svg"></md-icon>
                                <input required ng-model="telephone" ng-pattern="'^[0-9]*'" type="text" placeholder="Telephone">
                            </md-input-container>
                        </div>
                        <div class="col-md-4">
                            <md-button type="submit" class="md-raised" ng-disabled="formSMS.$invalid" style="display:block; width:120px;">Pošlji</md-button>
                        </div>
                    </div>
                    <label class="label-material-style">Text</label>
                    <textarea ng-model="smsText" wrap="soft" style="display:block; height:150px; width:462px;"></textarea>
                </form>
            </div>
        </md-dialog-content>
    </md-dialog>
</script>
<script type="text/ng-template" id="invoicesModal.html">
  <md-dialog style="max-width: 22%;" aria-label="Invoices" class="old_order_modal" ng-cloak>
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Naročila</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
            <div class="content_table_wrap clearfix">
              <table class="content_table default_table">
                  <thead>
                      <tr>
                          <th class="center">Lead ID</th>
                          <th class="left">Stranka</th>
                          <th class="left">Model Avta</th>
                          <th class="left">Datum vnosa</th>
                          <th class="center">Pregled</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="order in orders">
                      <td class="center">{{order.id}}</td>
                      <td class="left">{{order.customer}}</td>
                      <td class="left">{{order.car_model}}</td>
                      <td class="left">{{order.date_created | date}}</td>
                      <td class="center icon">
                        <a href="<?php echo base_url(); ?>index.php/order_details?order_id={{order.id}}" target="_blank">
                            <button type="button" class="glyphicon_btn">
                                <span class="glyphicon glyphicon-zoom-in"></span>
                            </button>
                        </a>
                      </td>
                    </tr>
                 </tbody>
              </table>
            </div>
        </div>
      </md-dialog-content>
      <md-dialog-actions layout="row">
        <form method="post" target="_blank" action="<?php echo base_url(); ?>index.php/actions/previewInvoice">
            <input type="hidden" name="inv_id" value="{{invoice_id}}" />
            <md-button type="submit" class="md-raised">Poglej</md-button>
        </form>
        <md-button ng-click="sendInvoiceEmail(invoice_id)" class="md-raised">Pošlji kot email</md-button>
        <md-button ng-click="payCheck()" style="background-color: #3375BD;" class="md-raised md-primary">Plačano</md-button>
      </md-dialog-actions>
  </md-dialog>
</script>
