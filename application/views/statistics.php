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
        		<div class="col-md-12">
        			<h5 class="over-title margin-bottom-15"><span class="text-bold">3D rolling</span> links</h5>
        			<p>
        				Enclose your link inside the class <code>.cl-effect-2</code>
        			</p>
        			<div class="margin-top-30 margin-bottom-30">
        				<nav id="cl-effect-2" class="links cl-effect-2">
        					<a href><span data-hover="Ratatouille">Ratatouille</span></a>
        					<a href><span data-hover="Lassitude">Lassitude</span></a>
        					<a href><span data-hover="Murmurous">Murmurous</span></a>
        					<a href><span data-hover="Palimpsest">Palimpsest</span></a>
        					<a href><span data-hover="Assemblage">Assemblage</span></a>
        				</nav>
        			</div>
        		</div>
        	</div>
        	<div class="row">
        		<div class="col-sm-12">
        			<h5 class="over-title margin-bottom-15">Statistika naročil</h5>
        			<div class="row">
        				<!-- /// controller:  'ChartCtrl2' -  localtion: assets/js/controllers/chartsCtrl.js /// -->
        				<!-- <div ng-controller="ChartCtrl2">
        					<div class="col-sm-6">
        						<p class="margin-bottom-20">
        							A bar chart is a way of showing data as bars.
        							It is sometimes used to show trend data, and the comparison of multiple data sets side by side.
        						</p>
        						<p>
        							The bar chart has the a very similar data structure to the line chart, and has an array of datasets, each with colours and an array of data. Again, colours are in CSS format.
        							We have an array of labels too for display. In the example, we are showing the same data as the previous line chart example.
        						</p>
        						<p>
        							The label key on each dataset is optional, and can be used when generating a scale for the chart.
        						</p>
        						<p class="margin-top-20">
        							<div tc-chartjs-legend chart-legend="lineChart2"></div>
        						</p>
        					</div>
        					<div class="col-sm-6">
        						<canvas class="tc-chart" tc-chartjs-bar chart-options="options" chart-data="data" chart-legend="lineChart2"></canvas>
        					</div>
        				</div> -->
        			</div>
        		</div>
        	</div>
        </div>
    </div>
</div>
