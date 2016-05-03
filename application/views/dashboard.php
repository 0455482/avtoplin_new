<?php
    // echo '<pre>';
    // var_dump($product_filter);
    // echo '</pre>';
?>
<title>Namizje</title>
<div ng-controller="dashboardCtrl as ctrl" ng-init="initData()" id="content" class="dashboard_content">
    <uib-alert style="cursor: pointer;" type="{{alert.type}}" ng-click="clickNoty(redirectToStatus)" close="closeAlert()" ng-if="show" dismiss-on-timeout="5000" class="alert">{{alert.msg}} <b>KLIK</b></uib-alert>
    <!-- Main orders table wrap -->
    <section class="main_orders_wrap">
        <header class="clearfix">

            <div class="thumbnails">
                <ul>
                    <li ng-repeat="thumbnail in thumbnails" ng-if="(thumbnail.name != 'Arhiv' && thumbnail.name != 'Izbrisano')">
                        <p class="heading">{{thumbnail.name}}</p>
                        <p class="number"><b>{{thumbnail.count}}</b></p>
                    </li>
                </ul>
            </div>

            <!-- Search panel -->
            <div id="search_panel" class="search_inputs clearfix">
            <!-- Date from-to -->
                <div>
                    <md-datepicker ng-model="dt" ng-change="showOd()" ng-required="false" md-placeholder="Od"></md-datepicker>
                    <md-datepicker ng-model="dm" ng-change="showDo()" ng-required="false" md-placeholder="Do"></md-datepicker>
                </div>
                <!--SEARCH IN TABLE-->
                <div class="text_search_wrap">
                    <form ng-submit="setSearch(quick_text)">
                    <md-input-container md-no-float class="md-block">
                        <md-icon style="cursor: pointer;" ng-click="setSearch(quick_text)" md-svg-src="/avtoplin/resources/images/ic_search_black_24px.svg"></md-icon>
                        <input ng-model="quick_text" type="text" placeholder="Iskanje">
                    </md-input-container>
                    <input type="submit" style="display: none;" />
                    </form>
                </div>
            </div>

            <!-- Table header wrap -->
            <div class="dashboard_table_header">
                <!-- Orders tabs-->
                <ul id="main_table_tabs" class="tabs_wrap clearfix">
                    <li ng-repeat="status in statuses" ng-model="tab" ng-class="{active: tab == '{{status.name}}'}" style="border-top-color:{{status.color}}" ng-click="$parent.tab = status.name; $parent.tab_status_id = status.id; $parent.color = status.color; switchTab(status.name);">{{status.name}}</li>
                </ul>


            <md-button ng-disabled="(selectedOrdersCount == 0) ? true : false" class="md-raised" ng-click="showSelectedOrdersModal(selectedOrders)">Izbranih: {{selectedOrdersCount}}</md-button>
            </div>

        </header>

        <div class="dashboard_content">
            <!-- Main orders table -->
            <table id="main_orders_table" class="default_table">
                <thead id="main_table_head" style="background-color: {{color}}" class="main_table_head">
                    <tr ng-if="(tab_status_id != 5 && tab_status_id != 6) ? true : false">
                        <th class="center sort selected left">
                            <input class="list_check" type="checkbox" ng-model="$parent.checkedAll" ng-click="checkAll()">
                        </th>
                        <th class="sort selected left">
                            <span class="title">LEAD ID</span>
                        </th>
                        <th class="sort left">
                            <span class="title">STRANKA</span>
                        </th>
                        <th class="sort left">
                            <span class="title">TELEFON</span>
                        </th>
                        <th class="sort left">
                            <span class="title">MODEL AVTA</span>
                        </th>
                        <th class="sort left">
                            <span class="title">DATUM VNOSA</span>
                        </th>
                        <th class="sort left">
                            <span class="title">OPOMBE</span>
                        </th>
                        <th class="sort left">
                            <span class="title">PREGLED</span>
                        </th>
                    </tr>
                    <tr ng-if="(tab_status_id == 5 || tab_status_id == 6) ? true : false">
                        <th class="center sort selected left">
                            <input class="list_check" type="checkbox" ng-model="$parent.checkedAll" ng-click="checkAll()">
                        </th>
                        <th class="sort selected center">
                            <span class="title">INVOICE ID</span>
                        </th>
                        <th class="sort center">
                            <span class="title">ŠT. NAROČIL</span>
                        </th>
                        <th class="sort left">
                            <span class="title">CENA</span>
                        </th>
                        <th class="sort left">
                            <span class="title">DATUM VNOSA</span>
                        </th>
                        <th class="sort left">
                            <span class="title">PREGLED</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="main_table_body">
                    <tr ng-if="(tab_status_id != 5 && tab_status_id != 6) ? true : false" ng-repeat="row in rows track by $index">
                        <td class="center">
                            <input class="list_check" type="checkbox" ng-model="row.selected">
                        </td>
                        <td class="center">{{row.id}}</td>
                        <td class="left">{{row.customer}}</td>
                        <td class="left">{{row.telephone}}</td>
                        <td class="left">{{row.car_model}}</td>
                        <td class="center">{{row.date_created | date:'dd/MM/yyyy'}}</td>
                        <td class="left">{{row.customer_profile}}</td>
                        <td class="center">
                            <a href="<?php echo base_url(); ?>index.php/order_details?order_id={{row.id}}" target="_self">
                                <button type="button" class="glyphicon_btn">
                                    <span class="glyphicon glyphicon-zoom-in"></span>
                                </button>
                            </a>
                        </td>
                    </tr>
                    <tr ng-if="(tab_status_id == 5 || tab_status_id == 6) ? true : false" ng-repeat="row in rows track by $index">
                        <td class="center">
                            <input class="list_check" type="checkbox" ng-model="row.selected">
                        </td>
                        <td class="center">{{row.invoice_num}}</td>
                        <td class="center">{{row.num_of_orders}}</td>
                        <td class="left">{{row.price}}</td>
                        <td class="left">{{row.date_created | date}}</td>
                        <td class="center">
                            <button ng-click="openInvoicesModal(row.id)" type="button" class="glyphicon_btn">
                                <span class="glyphicon glyphicon-zoom-in"></span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination control panel -->
            <div id="pagination_controls_main" class="clearfix pagination_controls_wrap">
                <!-- Pagination commands -->
                <ul class="pagination_controls">
                    <li class="pagination_btn paging_first" ng-click="pagination.firstPage()" title="First">
                        <span class="glyphicon glyphicon-step-backward"></span>
                    </li>
                    <li class="pagination_btn paging_left" ng-click="pagination.prevPage()" title="Prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </li>
                    <li class="pagination_btn paging_right" ng-click="pagination.nextPage()" title="Next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </li>
                    <li class="pagination_btn paging_last" ng-click="pagination.lastPage()" title="Last">
                        <span class="glyphicon glyphicon-step-forward"></span>
                    </li>
                </ul>
                <!-- Pagination counter -->
                <span class="pagination_counter">
                    <span>
                        <span class="from">
                            {{pagination.start_item}}<!-- First item on page number -->
                        </span>
                        <span>-</span>
                        <span class="to">
                           {{pagination.numPerPage}}<!-- Last item on page number -->
                        </span>
                    </span>
                    <span>of</span>
                    <span class="total">
                        {{pagination.all_data}}
                        <!-- Total items number goes here -->
                    </span>
                </span>
            </div>
            <!-- Loading -->
            <div id="main_loading" ng-show="loading" class="loading_overlay">
                <div class="loading_fixed_wrap">
                    <img class="loading_img" src="/avtoplin/resources/images/loading_2.gif" />
                    <span class="loading_text">Loading</span>
                </div>
            </div>
        </div>
    </section>
</div>

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

<script type="text/ng-template" id="SelectedOrdersModal.html" >
    <md-dialog aria-label="Izbrana Naročila" ng-cloak style="width: 650px; height: 650px;">
        <md-toolbar style="background-color: #3375BD;">
            <div class="md-toolbar-tools">
                <h2>Izbrana Naročila</h2>
                <span flex></span>
                <md-button class="md-icon-button" ng-click="cancel()">
                    <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content>
            <div class="md-dialog-content">
                <div style="min-height:150px;">
                    <md-content class="md-padding" layout="column">
                        <md-chips ng-model="orders"></md-chips>
                    </md-content>
                </div>

                <div>
                    <div ng-switch="statusHeading">
                        <div ng-switch-when="Spremeni status">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title" href="#" ng-model="collapsed">
                                        <a href="#" >{{statusHeading}}</a>
                                    </h4>
                                </div>
                                <div>
                                <ul class="list-group" ng-show="collapsed">
                                    <li style="list-style: none; text-align: center;" ng-repeat="status in next_statuses">
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
                                    <form name="formRacun" ng-submit="submitInvoice(invoice)">
                                        <md-input-container md-no-float class="md-block">
                                            <input ng-model="invoice.invoiceNum" type="text" placeholder="Številka računa" required>
                                        </md-input-container>
                                        <md-datepicker ng-model="invoice.date_export" ng-required="true" md-placeholder="Datum izdaje"></md-datepicker>
                                        <md-datepicker ng-model="invoice.date_done" ng-required="true" md-placeholder="Datum opravljene storitve"></md-datepicker>
                                        <md-datepicker ng-model="invoice.date_deadline" ng-required="true" md-placeholder="Rok plačila"></md-datepicker>
                                        <md-button type="submit" class="md-raised" ng-disabled="formRacun.$invalid">Potrdi</md-button>
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
                                            <textarea ng-model="comment" wrap="soft" placeholder="Razlog..." style="width:570px;"></textarea>
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
                <form method="post" target="_blank" action="<?php echo base_url();?>index.php/Actions/exportOrders">
                  <input ng-repeat="o in orders" type="hidden" name="orders[]" value="{{o}}"/>
                  <md-button type="submit" class="md-raised" style="width:100%; margin:0 auto;">Izvozi Narocila</md-button>
                </form>
            </div>
        </md-dialog-content>
    </md-dialog>
</script>
