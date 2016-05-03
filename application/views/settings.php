<!-- start: DASHBOARD TITLE -->
<div class="main-content ng-scope">
    <div class="wrap-content container fade-in-up ng-scope" id="container">
        <section id="page-title" class="padding-top-15 padding-bottom-15">
            <div class="row">
                <div class="col-sm-7">
                    <h1 class="mainTitle">NASTAVITVE</h1>
                    <span class="mainDescription">uporabniki, statusi, SMS, ponudba...</span>
                </div>
            </div>
        </section>

        <div class="container-fluid container-fullw bg-white">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="over-title margin-bottom-15">Uporabniki</h4>
                    <table class="table table-hover" id="sample-table-1">
                        <thead>
                            <tr>
                                <th class="center">#</th>
                                <th class="hidden-xs">Uborabniško ime</th>
                                <th class="hidden-xs">Datum</th>
                                <th class="hidden-xs">Telefonska številka</th>
                                <th class="hidden-xs">Tekst</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="center">1</td>
                                <td class="hidden-xs">Google Chrome</td>
                                <td>Google</td>
                                <td>
                                    <a href="#" rel="nofollow" target="_blank">
                                        Terms of Service
                                    </a>
                                </td>
                                <td class="hidden-xs">Blink</td>
                                <td class="center">
                                    <div class="visible-md visible-lg hidden-sm hidden-xs">
                                        <a href="#" class="btn btn-transparent btn-xs" tooltip-placement="top" uib-tooltip="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="#" class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" uib-tooltip="Share"><i class="fa fa-share"></i></a>
                                        <a href="#" class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" uib-tooltip="Remove"><i class="fa fa-times fa fa-white"></i></a>
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
                                                <li>
                                                    <a href="#">
                                                        Share
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Remove
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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
