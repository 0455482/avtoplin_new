<!-- start: DASHBOARD TITLE -->
<div class="ng-scope" ng-controller="dashboardCtrl as dash" ng-init="initData()">
  <div style="margin-top: 0;" class="main-content ng-scope">
    <div class="wrap-content container fade-in-up ng-scope" id="container">
      <section id="page-title" class="padding-top-15 padding-bottom-15">
        <div class="row">
          <div class="col-sm-7">
            <h1 class="mainTitle">DASBOARD</h1>
            <span class="mainDescription">overview &amp; stats </span>
          </div>
          <div class="col-sm-5">
            <!-- start: MINI STATS WITH SPARKLINE -->
            <!-- /// controller:  'SparklineCtrl' -  localtion: assets/js/controllers/dashboardCtrl.js /// -->
            <!-- end: MINI STATS WITH SPARKLINE -->
          </div>
        </div>
      </section>
      <!-- end: DASHBOARD TITLE -->
      <!-- start: FEATURED BOX LINKS -->
      <div class="container-fluid container-fullw">
        <div class="row">
          <div class="col-md-12">
            <div class="margin-top-30 margin-bottom-30 csstransforms3d">
              <nav id="cl-effect-2" class="links cl-effect-2">
                <a ng-repeat="thumbnail in thumbnails" ng-if="(thumbnail.name != 'Arhiv' && thumbnail.name != 'Izbrisano')" href><span data-hover="{{thumbnail.count}}">{{thumbnail.name}}</span></a>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <!-- end: FEATURED BOX LINKS -->
      <!-- start: FIRST SECTION -->
      <div class="container-fluid container-fullw bg-white">
        <div style="margin-bottom: 30px;" class="row">
          <div class="col-md-6">
            <h5 class="text-bold margin-top-25 margin-bottom-15">Iskanje po datum</h5>
            <div class="input-group">
              <input type="text" class="form-control" ng-change="showOd()" uib-datepicker-popup="yyyy/MM/dd" ng-model="dt"  is-open="startOpened" ng-init="startOpened = false" min-date="'1970-12-31'" max-date="end" ng-required="true" close-text="Close"  ng-click="startOpen()"/>
              <span class="input-group-addon">to</span>
              <input type="text" class="form-control" ng-change="showDo()" uib-datepicker-popup="yyyy/MM/dd" ng-model="dm" is-open="endOpened" ng-init="endOpened = false" min-date="start" max-date="maxDate" ng-required="true" close-text="Close"  ng-click="endOpen()" />
            </div>
          </div>
          <div class="col-md-6">
            <h5 class="text-bold margin-top-25 margin-bottom-15">Iskanje</h5>
            <form ng-submit="setSearch(quick_text)">
              <span class="input-icon input-icon-right">
                <input type="text" placeholder="Text Field" ng-model="quick_text" id="form-field-17" class="form-control">
                <i ng-click="" class="fa fa-search"></i>
              </span>
              <input type="submit" style="display: none;" />
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <uib-tabset class="tabbable">
              <uib-tab ng-repeat="status in statuses" ng-model="tab" heading="{{status.name}}"
              active="status.active" disabled="tab.disabled"
              ng-click="$parent.status = status.name; $parent.tab_status_id = status.id; $parent.color = status.color; switchTab(status.name);">
              <div class="container-fluid container-fullw bg-white">
                <div class="row">
                  <div class="col-md-12">
                    <table class="table table-hover" id="sample-table-1">
                      <thead>
                        <tr ng-if="(tab_status_id != 5 && tab_status_id != 6) ? true : false">
                          <th class="center">
                            <input class="list_check" type="checkbox" ng-model="self.checkedAll" ng-click="checkAll(self.checkedAll)">
                          </th>
                          <th>LEAD ID</th>
                          <th class="hidden-xs">STRANKA</th>
                          <th>TELEFON</th>
                          <th class="hidden-xs">MODEL AVTA</th>
                          <th class="hidden-xs">DATUM VNOSA</th>
                          <th>OPOMBE</th>
                          <th class="hidden-xs">PREGLED</th>
                          <th></th>
                        </tr>
                        <tr ng-if="(tab_status_id == 5 || tab_status_id == 6) ? true : false">
                          <th class="center">
                            <input class="list_check" type="checkbox" ng-model="self.checkedAll" ng-click="checkAll(self.checkedAll)">
                          </th>
                          <th>INVOICE ID</th>
                          <th class="hidden-xs">ŠT. NAROČIL</th>
                          <th>CENA</th>
                          <th class="hidden-xs">DATUM VNOSA</th>
                          <th class="hidden-xs">PREGLED</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr ng-if="(tab_status_id != 5 && tab_status_id != 6) ? true : false" ng-repeat="row in rows track by $index">
                          <td class="center">
                            <input class="list_check" type="checkbox" ng-model="row.selected">
                          </td>
                          <td class="center">{{row.id}}</td>
                          <td class="hidden-xs">{{row.customer}}</td>
                          <td>{{row.telephone}}</td>
                          <td>
                            {{row.car_model}}
                          </td>
                          <td class="hidden-xs">{{row.date_created | date:'dd/MM/yyyy'}}</td>
                          <td class="hidden-xs">{{row.customer_profile}}</td>
                          <td class="center">
                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                              <a href="<?php echo base_url(); ?>index.php/order_details?order_id={{row.id}}" target="_self" class="btn btn-transparent btn-xs" tooltip-placement="top" uib-tooltip="Edit"><i class="fa fa-search-plus"></i></a>
                            </div>
                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                              <div class="btn-group" uib-dropdown is-open="status.isopen">
                                <button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" uib-dropdown-toggle>
                                  <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                  <li>
                                    <a href="#">
                                      Edit
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </div></td>
                          </tr>

                          <tr ng-if="(tab_status_id == 5 || tab_status_id == 6) ? true : false" ng-repeat="row in rows track by $index">
                            <td class="center">
                              <input class="list_check" type="checkbox" ng-model="row.selected">
                            </td>
                            <td class="center">{{row.invoice_num}}</td>
                            <td class="hidden-xs">{{row.num_of_orders}}</td>
                            <td>{{row.price}}</td>
                            <td>
                              {{row.date_created | date}}
                            </td>
                            <td class="center">
                              <div class="visible-md visible-lg hidden-sm hidden-xs">
                                <a href="<?php echo base_url(); ?>index.php/order_details?order_id={{row.id}}" target="_self" class="btn btn-transparent btn-xs" tooltip-placement="top" uib-tooltip="Edit"><i class="fa fa-search-plus"></i></a>
                              </div>
                              <div class="visible-xs visible-sm hidden-md hidden-lg">
                                <div class="btn-group" uib-dropdown is-open="status.isopen">
                                  <button type="button" class="btn btn-primary btn-o btn-sm dropdown-toggle" uib-dropdown-toggle>
                                    <i class="fa fa-cog"></i>&nbsp;<span class="caret"></span>
                                  </button>
                                  <ul class="dropdown-menu pull-right dropdown-light" role="menu">
                                    <li>
                                      <a href="#">
                                        Edit
                                      </a>
                                    </li>
                                  </ul>
                                </div>
                              </div></td>
                            </tr>
                          </tbody>
                        </table>
                        <div style="display: inline-flex">
                          <ul class="pagination margin-bottom-10">
                            <li>
                              <a href="#" ng-click="pagination.prevPage()"> <i class="ti-arrow-left"></i> </a>
                            </li>
                            <li>
                              <a href="#" ng-click="pagination.nextPage()"> <i class="ti-arrow-right"></i> </a>
                            </li>
                          </ul>
                          <div style="margin-top: 25px; margin-left: 10px;">
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
                        </div>
                      </div>
                    </div>
                  </div>
                </uib-tab>
                <!-- <uib-tab heading="Vse">

              </uib-tab> -->
            </uib-tabset>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
