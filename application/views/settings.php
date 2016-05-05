<div class="main-content ng-scope" ng-controller="settingsCtrl as settings" ng-init="initData()">
    <div class="wrap-content container fade-in-up ng-scope" id="container">
        <section id="page-title" class="padding-top-15 padding-bottom-15">
            <div class="row">
                <div class="col-sm-7">
                    <h1 class="mainTitle">NASTAVITVE</h1>
                    <span class="mainDescription">uporabniki, statusi, SMS, ponudba...</span>
                </div>
            </div>
        </section>

        <div ng-switch="selectedIndex">
            <div ng-switch-when="0">
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="over-title margin-bottom-15">Uporabniki
                                <button type="button" style="float:right" class="btn btn-wide btn-primary" ng-disabled="!user_type" ng-click="showCreateModal()">Dodaj uporabik</button>
                            </h4>
                            <table class="table table-hover" id="sample-table-1">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="hidden-xs">Uborabniško ime</th>
                                        <th class="hidden-xs">Tip</th>
                                        <th class="hidden-xs">Active / Inactive</th>
                                        <th class="hidden-xs">Datum ustvarjanja</th>
                                        <th ng-show="user_type"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="user in users track by $index">
                                        <td class="center">{{$index + 1}}</td>
                                        <td class="hidden-xs">{{user.username}}</td>
                                        <td>{{user.type}}</td>
                                        <td>{{(user.active == 1) ? 'Active' : 'Inactive'}}</td>
                                        <td class="hidden-xs">{{user.date_created}}</td>
                                        <td class="center" ng-show="user_type" ng-click="showAdvanced(user)">
                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                <a href="#" class="btn btn-transparent btn-xs" tooltip-placement="top" uib-tooltip="Uredi"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div ng-switch-when="1">
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="over-title margin-bottom-15">Statusi</h4>
                            <table class="table table-hover" id="sample-table-1">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="hidden-xs">Ime</th>
                                        <th class="hidden-xs">Barva</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="status in statuses">
                                        <td class="center">{{status.id}}</td>
                                        <td class="hidden-xs">{{status.name}}</td>
                                        <td>
                                            <div class="flex order_color" style="float:left; background-color:{{status.color}}">
                                                <span></span>
                                            </div>
                                        </td>
                                        <td class="center" ng-click="showColorsModal(status)">
                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                <a href="#" class="btn btn-transparent btn-xs" tooltip-placement="top" uib-tooltip="Spremeni barvo"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div ng-switch-when="2">
                <div class="container-fluid container-fullw bg-white" style="margin-bottom:30px">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="over-title margin-bottom-15">SMS
                                <button type="button" style="float:right" class="btn btn-wide btn-primary" ng-click="showCreateSMSModal()">Dodaj SMS</button>
                            </h4>
                            <table class="table table-hover" id="sample-table-1">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="hidden-xs">Naslov</th>
                                        <th class="hidden-xs">Vsebina</th>
                                        <th class="hidden-xs">Active / Inactive</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="sm in sms track by $index">
                                        <td class="center">{{$index + 1}}</td>
                                        <td class="hidden-xs">{{sm.name}}</td>
                                        <td>{{sm.text}}</td>
                                        <td>{{(sm.active == 1) ? 'Active' : 'Inactive'}}</td>
                                        <td class="center" ng-click="showEditSMSModal(sm.id)">
                                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                                <a href="#" class="btn btn-transparent btn-xs" tooltip-placement="top" uib-tooltip="Uredi"><i class="fa fa-pencil"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="container-fluid container-fullw bg-white" style="border-top: 1px solid #eee;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="over-title margin-bottom-15">SMS zgodovina</h4>
                            <table class="table table-hover" id="sample-table-1">
                                <thead>
                                    <tr>
                                        <th class="center">#</th>
                                        <th class="hidden-xs">Uporabniško ime</th>
                                        <th class="hidden-xs">Datum</th>
                                        <th class="hidden-xs">Telefonska številka</th>
                                        <th class="hidden-xs">Tekst</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="sms in smss track by $index">
                                        <td class="center">{{$index + 1}}</td>
                                        <td class="hidden-xs">{{sms.customer}}</td>
                                        <td>{{sms.date_sent}}</td>
                                        <td>{{sms.telephone}}</td>
                                        <td>{{sms.text}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div ng-switch-when="3">
                <div class="container-fluid container-fullw padding-bottom-10">
                    <form name="pro_form" ng-submit="saveEngine(engines, discounts, installments)">
                        <div class="row">
                            <h4 class="over-title margin-bottom-15" style="padding-left:20px !important;">Ponudba</h4>
                            <div class="col-sm-6">
                                <div class="panel panel-white no-radius">
                                    <div class="panel-heading border-light">
                                        <h4 class="panel-title">PRO</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="engines_table">
                                            <tbody>
                                                <tr>
                                                    <td class="nothing"> </td>
                                                    <td class="heading"> <b>Cena €</b> </td>
                                                    <td class="heading"> <b>Ure</b> </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>V4</b> </td>
                                                    <td><input notnumber type="text" ng-model="engines[0].v4_price" required placeholder="Vnesi ceno" class="form-control input-sm"/> </td>
                                                    <td> <input type="text" ng-model="engines[0].v4_work" required placeholder="Vnesi ure" class="form-control input-sm" /> </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>V6</b> </td>
                                                    <td> <input notnumber type="text" ng-model="engines[0].v6_price" required placeholder="Vnesi ceno" class="form-control input-sm"/> </td>
                                                    <td> <input type="text" ng-model="engines[0].v6_work" required placeholder="Vnesi ure" class="form-control input-sm"/> </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>V8</b> </td>
                                                    <td> <input notnumber type="text" ng-model="engines[0].v8_price" required placeholder="Vnesi ceno" class="form-control input-sm"/> </td>
                                                    <td> <input type="text" ng-model="engines[0].v8_work" required placeholder="Vnesi ure" class="form-control input-sm"/> </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"> <b>DODATNO MAZANJE VENTILOV</b> </td>
                                                    <td> <input notnumber type="text" ng-model="engines[0].lubricating" required placeholder="Vnesi ceno" class="form-control input-sm"/> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-white no-radius">
                                    <div class="panel-heading border-bottom">
                                        <h4 class="panel-title">PRO DIRECT</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="engines_table">
                                            <tbody>
                                                <tr>
                                                    <td class="nothing"> </td>
                                                    <td class="heading"> <b>Cena €</b> </td>
                                                    <td class="heading"> <b>Ure</b> </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>V4</b> </td>
                                                    <td>
                                                        <input notnumber type="text" ng-model="engines[1].v4_price" required placeholder="Vnesi ceno" class="form-control input-sm"/>
                                                    </td>
                                                    <td> <input type="text" ng-model="engines[1].v4_work" required placeholder="Vnesi ure" class="form-control input-sm"/> </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>V6</b> </td>
                                                    <td> <input notnumber type="text" ng-model="engines[1].v6_price" required placeholder="Vnesi ceno" class="form-control input-sm"/> </td>
                                                    <td> <input type="text" ng-model="engines[1].v6_work" required placeholder="Vnesi ure" class="form-control input-sm"/> </td>
                                                </tr>
                                                <tr>
                                                    <td> <b>V8</b> </td>
                                                    <td> <input notnumber type="text" ng-model="engines[1].v8_price" required placeholder="Vnesi ceno" class="form-control input-sm"/> </td>
                                                    <td> <input type="text" ng-model="engines[1].v8_work" required placeholder="Vnesi ure" class="form-control input-sm"/> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="panel panel-white no-radius">
                                    <div class="panel-heading border-light">
                                        <h4 class="panel-title">POPUSTI</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="engines_table">
                                            <tbody>
                                                <tr>
                                                    <td class="nothing"> </td>
                                                    <td class="heading"> <b>Cena €</b> </td>
                                                </tr>
                                                <tr ng-repeat="discount in discounts">
                                                    <td> <b>{{discount.type}}</b> </td>
                                                    <td>
                                                        <input notnumber type="text" ng-model="discount.value" required placeholder="Vnesi ceno" class="form-control input-sm"/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-white no-radius">
                                    <div class="panel-heading border-bottom">
                                        <h4 class="panel-title">OBROKI</h4>
                                    </div>
                                    <div class="panel-body">
                                        <table class="engines_table">
                                            <tbody>
                                                <tr>
                                                    <td class="nothing"> </td>
                                                    <td class="heading"> <b>Polog</b> </td>
                                                    <td class="heading"> <b>Št. obrokov</b> </td>
                                                    <td class="heading"> <b>Subvencija</b> </td>
                                                </tr>
                                                <tr ng-repeat="installment in installments">
                                                    <td class="threetd"> <b>{{installment.type}}</b> </td>
                                                    <td class="threetd"> <input notnumber type="text" ng-model="installment.deposit" required placeholder="Vnesi ceno" class="form-control input-sm"/></td>
                                                    <td class="threetd"> <input notnumber type="text" ng-model="installment.num_of_installments" required placeholder="Vnesi ure" class="form-control input-sm"/> </td>
                                                    <td class="threetd"> <input notnumber type="text" ng-model="installment.subsidy" required placeholder="Vnesi ure" class="form-control input-sm"/> </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="width:100%; text-align:center;">
                            <button type="submit" class="btn btn-wide btn-primary">Shrani</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/ng-template" id="SMSModalContent.html">
    <div class="modal-header">
        <h3 class="modal-title">{{title}}</h3>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa fa-pencil"></i> </span>
                <input type="text" class="form-control" placeholder="Naslov" ng-model="sms.name">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa fa-align-justify"></i> </span>
                <input type="text" class="form-control" placeholder="Vsebina" ng-model="sms.text">
            </div>
        </div>
            <div class="form-group">
                <label for="form-field-select-1">
                    Active / Inactive
                </label>
                <select class="cs-select cs-skin-slide" ng-model="sms.active">
                    <option value=""></option>
                    <option value="1" data-class="fa fa-circle" ng-selected="sms.active == 1">Active</option>
                    <option value="0" data-class="fa fa-circle-o" ng-selected="sms.active == 0">Inactive</option>
                </select>
            </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" ng-click="ok()">Shrani</button>
        <button class="btn btn-primary btn-o" ng-click="cancel()">Prekliči</button>
    </div>
</script>

<script type="text/ng-template" id="colorModalContent.html">
    <div class="modal-header">
        <h3 class="modal-title">Izberi barvo</h3>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa fa-eyedropper"></i> </span>
                <input colorpicker type="text" class="form-control" placeholder="Barva" ng-model="color">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" ng-click="ok()">Shrani</button>
        <button class="btn btn-primary btn-o" ng-click="cancel()">Prekliči</button>
    </div>
</script>

<script type="text/ng-template" id="createUserModal.html">
    <div class="modal-header">
        <h3 class="modal-title">{{title}}</h3>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa fa-user"></i> </span>
                <input type="text" class="form-control" placeholder="Ime" ng-model="user.username">
            </div>
        </div>
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-addon"> <i class="fa fa-unlock-alt"></i> </span>
                <input type="password" class="form-control" placeholder="Geslo" ng-model="user.password">
            </div>
        </div>
        <div class="form-group">
            <label for="form-field-select-1">
                Admin / Regular
            </label>
            <select class="cs-select cs-skin-slide" ng-model="user.type">
                <option value=""></option>
                <option value="admin" data-class="fa fa-user" ng-selected="user.type == 'admin'">Admin</option>
                <option value="regular" data-class="fa fa-users" ng-selected="user.type == 'regular'">Regular</option>
            </select>
        </div>
        <div class="form-group">
            <label for="form-field-select-1">
                Active / Inactive
            </label>
            <select class="cs-select cs-skin-slide" ng-model="user.active">
                <option value=""></option>
                <option value="1" data-class="fa fa-circle" ng-selected="user.active == 1">Active</option>
                <option value="0" data-class="fa fa-circle-o" ng-selected="user.active == 0">Inactive</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" ng-click="ok()">Shrani</button>
        <button class="btn btn-primary btn-o" ng-click="cancel()">Prekliči</button>
    </div>
</script>
