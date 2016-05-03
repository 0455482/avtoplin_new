<title>Statistics</title>
<div ng-controller="statisticsCtrl as statistics" ng-init="initData()" id="content" class="statistics_content">
    <uib-alert type="{{alert.type}}" close="closeAlert()" ng-if="show" dismiss-on-timeout="2000" class="alert">{{alert.msg}}</uib-alert>
    <!-- Main orders table wrap -->
    <section class="main_orders_wrap">
        <header>
            <div id="settings_panel" class="clearfix" ng-switch="selectedDateOption">
                <div class="wide">
                	<!-- Datum -->
	            	<md-input-container>
				        <label>Datum</label>
				        <md-select ng-model="selectedDateOption" ng-change="update()" ng-disabled="disableDateOption">
				          <md-option ng-repeat="option in dateOptions" value="{{option.id}}">
				            {{option.title}}
				          </md-option>
				        </md-select>
				     </md-input-container>
				    <!-- From-To -->
		            <md-datepicker ng-model="$parent.dateFrom" ng-change="update()" md-placeholder="From" ng-switch-when="0"></md-datepicker>
		            <md-datepicker ng-model="$parent.dateTo" ng-change="update()" md-placeholder="To" ng-switch-when="0"></md-datepicker>
					<!-- Year -->
		            <md-input-container md-no-float ng-switch-when="1" class="date-input-container">
				      	<md-icon md-svg-src="/avtoplin/resources/images/ic_date_range_black_24px.svg" class="date-icon"></md-icon>
				      	<md-select ng-model="$parent.selectedDateYear" ng-change="update()">
				          <md-option ng-repeat="option in dateYearOptions" value="{{option.id}}">
				            {{option.formatedDate}}
				          </md-option>
				        </md-select>
				    </md-input-container>
				    
					<!-- UTM -->
					<md-input-container ng-show="showUTM" class="utm-input-container">
				        <label>UTM</label>
				        <md-select ng-model="selectedUTMOption">
				          <md-option ng-repeat="option in utmOptions" value="{{option.id}}" >
				            {{option.title}}
				          </md-option>
				        </md-select>
				     </md-input-container>

                	<md-button class="md-raised float-right-button" ng-click="showAddExpensesModal()">Dodaj mesečne stroške</md-button>
                </div>
            </div>
        </header>

		<md-tabs md-dynamic-height="true" md-border-bottom md-autoselect md-selected="selectedTab" md-stretch-tabs>
	      	<md-tab ng-repeat="tab in tabs" ng-click="switchTab(tab.id)" ng-if="(user_type == 'admin' || tab.title != 'UTM Statistika')" label="{{tab.title}}">
	        	<md-content class="md-padding">
		        	<highchart config="chartConfig"></highchart>
		        </md-content>
		    </md-tab>
		</md-tabs>

        <!-- Loading -->
        <div id="main_loading" ng-show="loading" class="loading_overlay">
        	<div class="loading_fixed_wrap">
        		<img class="loading_img" src="/avtoplin/resources/images/loading_2.gif" />
        		<span class="loading_text">Loading</span>
        	</div>
        </div>
    </section>
</div>

<script type="text/ng-template" id="AddExpensesModal.html" >
    <md-dialog aria-label="Dodaj Mesečne Stroške" ng-cloak style="width: 550px; height: 350px;">  
        <md-toolbar style="background-color: #3375BD;">
            <div class="md-toolbar-tools">
                <h2>Dodaj Mesečne Stroške</h2>
                <span flex></span>
                <md-button class="md-icon-button" ng-click="cancel()">
                    <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
        <md-dialog-content ng-init="initData()" style="height:300px">
        	<div class="content">
  				<div class="col-md-8">
  					<label class="label-material-style">Mesec</label>
  				</div>
  				<form name="formExpenses" ng-submit="addExpenses(date, expenses)">
        			<div class="row">
	  					<div class="col-md-8">
	        				<uib-datepicker ng-model="date" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" datepicker-mode="'month'" ng-required="true" show-button-bar="false" ng-change="getExpenses()"></uib-datepicker>
						</div>
						<div class="col-md-4">
	        				<md-input-container md-no-float class="date-input-container expenses-container">
				             	<label>Stroške</label>
							    <md-icon md-svg-src="/avtoplin/resources/images/ic_euro_symbol_black_24px.svg" class="date-icon"></md-icon>
							    <input type="text" ng-model="expenses" ng-required="true" ng-pattern="/^[0-9]+([,.][0-9]+)?$/" placeholder="Stroške" />
							</md-input-container>
							<md-button type="submit" class="md-raised" ng-disabled="formExpenses.$invalid" style="width:120px;">Dodaj</md-button>
						</div>	
					</div>	
				</form>
            </div>
        </md-dialog-content>
    </md-dialog>
</scr>
