<div class="main-content ng-scope" ng-controller="statisticsCtrl as settings" ng-init="initData()">
    <div class="wrap-content container fade-in-up ng-scope" id="container">
        <section id="page-title" class="padding-top-15 padding-bottom-15">
            <div class="row">
                <div class="col-sm-7">
                    <h1 class="mainTitle">STATISTIKA</h1>
                    <span class="mainDescription">statistika naročil, profit, statistika rezerviranih, statistika realiziranih, uspešnost, UTM statistika...</span>
                </div>
            </div>
        </section>

        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-sm-12">
                    <h5 class="over-title margin-bottom-15">Statistika naročil</h5>
                    <div class="row">
                        <div class="col-sm-3">


                        </div>
                        <div class="col-sm-9">
                            <!-- <canvas class="chart chart-line" chart-data="data" chart-labels="labels" chart-legend="true" chart-series="series" chart-click="onClick" chart-options="options"></canvas> -->
                            <canvas class="chart chart-bar" chart-data="data" chart-labels="labels" chart-legend="true" chart-series="series" chart-options="options"> </canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
