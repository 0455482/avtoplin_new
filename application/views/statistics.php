<div class="main-content ng-scope" ng-controller="statisticsCtrl as self" ng-init="initData()">
    <uib-alert type="{{alert.type}}" close="closeAlert()" ng-if="show" dismiss-on-timeout="2000" class="alert">{{alert.msg}}</uib-alert>
    <div class="wrap-content container fade-in-up ng-scope" id="container">
        <section id="page-title" class="padding-top-15 padding-bottom-15">
            <div class="row">
                <div class="col-sm-7">
                    <h1 class="mainTitle">STATISTIKA</h1>
                    <span class="mainDescription">statistika naročil, profit, statistika rezerviranih, statistika realiziranih, uspešnost, UTM statistika...</span>
                </div>
            </div>
        </section>
        <div class="container-fluid container-fullw padding-bottom-10">
        	<div class="row">
        		<div class="col-sm-12">
        			<div class="row">
                        <div class="col-md-5 col-lg-4">
                            <div class="panel panel-white no-radius">
                                <div class="panel-heading border-light">
                                    <h4 class="panel-title"> Nastavitve </h4>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label for="form-field-select-2">
                                            Čas
                                        </label>
                                        <select class="cs-select cs-skin-elastic" ng-model="selectedDateOption" ng-change="getStatistika()">
                                            <option value="0" ng-selected="selectedDateOption == 0">Od-Do</option>
                                            <option value="1" ng-selected="selectedDateOption == 1">Leto</option>
                                        </select>
                                    </div>
                                    <div ng-switch="selectedDateOption">
                                        <div ng-switch-when="0">
                                            <label for="form-field-select-2">
                                                Od
                                            </label>
                                            <p class="input-group">
                                              <input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="self.dateFrom" is-open="self.opened1" ng-change="getStatistika()"/>
                                              <span class="input-group-btn">
                                                <button type="button" class="btn btn-default" ng-click="self.open1()"><i class="glyphicon glyphicon-calendar"></i></button>
                                              </span>
                                            </p>
                                            <label for="form-field-select-2">
                                                Do
                                            </label>
                                            <p class="input-group">
                                                <input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="self.dateTo" is-open="self.opened2" ng-change="getStatistika()"/>
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" ng-click="self.open2()">
                                                        <i class="glyphicon glyphicon-calendar"></i>
                                                    </button>
                                                </span>
                                            </p>
                                        </div>
                                        <div ng-switch-when="1">
                                            <div class="form-group">
                                                <label for="form-field-select-2">
                                                    Leto
                                                </label>
                                                <select class="cs-select cs-skin-elastic" ng-model="self.selectedDateYear" ng-change="getStatistika()">
                                                    <option ng-repeat="option in dateYearOptions" value="{{option.id}}" ng-selected="self.selectedDateYear == {{option.id}}">{{option.formatedDate}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-field-select-2">
                                            UTM
                                        </label>
                                        <select class="cs-select cs-skin-elastic" ng-model="selectedUTMOption" ng-change="getStatistika()">
                                            <option ng-repeat="option in utmOptions" value="{{option.id}}" ng-selected="selectedUTMOption == {{option.id}}">{{option.title}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div style="width:100%; text-align:center;">
                                        <button type="button" class="btn btn-wide btn-primary" ng-click="showAddExpensesModal()">Dodaj mesečne stroške</button>
                                    </div>
                                </div>
                            </div>
                        </div>
        				<div class="col-md-7 col-lg-8">
        					<div class="panel panel-white no-radius" id="visits">
        						<div class="panel-heading border-light">
        							<h4 class="panel-title"> Statistika naročil </h4>
        						</div>
        						<div uib-collapse="visits" ng-init="visits=false" class="panel-wrapper">
        							<div class="panel-body">
        								<canvas class="chart chart-bar" chart-data="statistics[0].data" chart-labels="statistics[0].labels" chart-legend="true" chart-series="statistics[0].series" chart-options="options"> </canvas>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="panel panel-white no-radius" id="visits">
                                <div class="panel-heading border-light">
                                    <h4 class="panel-title"> Statistika rezerviranih </h4>
                                </div>
                                <div uib-collapse="visits" ng-init="visits=false" class="panel-wrapper">
                                    <div class="panel-body">
                                        <canvas class="chart chart-bar" chart-data="statistics[2].data" chart-labels="statistics[2].labels" chart-legend="true" chart-series="statistics[2].series" chart-options="options"> </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="panel panel-white no-radius" id="visits">
                                <div class="panel-heading border-light">
                                    <h4 class="panel-title"> Statistika realiziranih </h4>
                                </div>
                                <div uib-collapse="visits" ng-init="visits=false" class="panel-wrapper">
                                    <div class="panel-body">
                                        <canvas class="chart chart-bar" chart-data="statistics[3].data" chart-labels="statistics[3].labels" chart-legend="true" chart-series="statistics[3].series" chart-options="options"> </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7 col-lg-7">
                            <div class="panel panel-white no-radius">
                                <div class="panel-heading border-light">
                                    <h4 class="panel-title"> Uspešnost </h4>
                                </div>
                                <div uib-collapse="visits" ng-init="visits=false" class="panel-wrapper">
                                    <div class="panel-body">
                                        <canvas class="chart chart-line" chart-data="statistics[4].data" chart-labels="statistics[4].labels" chart-legend="true" chart-series="statistics[4].series" chart-options="options"> </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-lg-5">
                            <div class="panel panel-white no-radius">
                                <div class="panel-heading border-light">
                                    <h4 class="panel-title"> Profit </h4>
                                </div>
                                <div uib-collapse="visits" ng-init="visits=false" class="panel-wrapper">
                                    <div class="panel-body">
                                        <canvas class="chart chart-line" chart-data="statistics[1].data" chart-labels="statistics[1].labels" chart-legend="true" chart-series="statistics[1].series" chart-options="options"> </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="panel panel-white no-radius" id="visits">
                                <div class="panel-heading border-light">
                                    <h4 class="panel-title"> UTM statistika </h4>
                                </div>
                                <div uib-collapse="visits" ng-init="visits=false" class="panel-wrapper">
                                    <div class="panel-body">
                                        <canvas class="chart chart-bar" chart-data="statistics[5].data" chart-labels="statistics[5].labels" chart-legend="true" chart-series="statistics[5].series" chart-options="options"> </canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        		</div>
        	</div>
        </div>
    </div>
</div>

<script type="text/ng-template" id="AddExpensesModal.html">
    <div class="modal-header">
        <h3 class="modal-title">Dodaj mesečne stroške</h3>
    </div>
    <div class="modal-body">
        <label for="form-field-select-2">
            Mesec
        </label>
        <p class="input-group">
          <input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="date" datepicker-options="dateOptions" is-open="opened" ng-change="getExpenses()"/>
          <span class="input-group-btn">
            <button type="button" class="btn btn-default" ng-click="open()"><i class="glyphicon glyphicon-calendar"></i></button>
          </span>
        </p>
        <div class="form-group">
            <label>
                Stroške
            </label>
            <div class="input-group">
                <span class="input-group-addon">€</span>
                <input type="text" ng-model="expenses" ng-required="true" ng-pattern="/^[0-9]+([,.][0-9]+)?$/" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" ng-click="ok()">Shrani</button>
        <button class="btn btn-primary btn-o" ng-click="cancel()">Prekliči</button>
    </div>
</script>
