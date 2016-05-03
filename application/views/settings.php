<title> Nastavitve </title>

<div ng-controller="settingsCtrl as settings" ng-init="initData()" class="sample" layout="column" ng-cloak>
  <uib-alert type="{{alert.type}}" close="closeAlert()" ng-if="show" dismiss-on-timeout="2000" class="alert">{{alert.msg}}</uib-alert>
  <md-content style="min-height: 800px;" class="md-padding">
  <div id="main_loading" ng-show="loading" class="loading_overlay">
    <div class="loading_fixed_wrap">
        <img class="loading_img" src="/avtoplin/resources/images/loading_2.gif" />
        <span class="loading_text">Loading</span>
    </div>
  </div>
    <md-tabs style="min-height: 800px;" md-selected="selectedIndex" md-border-bottom md-autoselect>
      <md-tab ng-repeat="tab in tabs"
              ng-click="switchTab(tab.title)"
              ng-disabled=""
              label="{{tab.title}}">
        <div ng-switch="tab.count" class="demo-tab tab{{$index%4}}" style="padding: 25px; text-align: center;">
          <div ng-switch-when="0" >
            <div class="content_table_wrap clearfix">
              <md-button style="margin: 6px 0; float: right;" ng-disabled="(user_type == 'admin') ? false : true" ng-click="showCreateModal()" class="md-raised">Dodaj uporabnik</md-button>
              <table class="content_table default_table">
                  <thead>
                      <tr>
                          <th class="left">Uborabniško ime</th>
                          <th class="left">Tip</th>
                          <th class="center">Active / Inactive</th>
                          <th class="left">Datum ustvarjanja</th>
                          <th class="center icon" ng-show="(user_type == 'admin') ? true : false">Uredi</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="user in users">
                      <td class="left">{{user.username}}</td>
                      <td class="left">{{user.type}}</td>
                      <td class="center">
                        {{(user.active == 1) ? 'Active' : 'Inactive'}}
                      </td>
                      <td class="left">{{user.date_created}}</td>
                      <td class="center icon" ng-show="(user_type == 'admin') ? true : false">
                        <button type="button" ng-click="showAdvanced(user)" class="glyphicon_btn">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div ng-switch-when="1">
            <div class="content_table_wrap clearfix">
              <table class="content_table default_table">
                  <thead>
                      <tr>
                          <th class="left">ID</th>
                          <th class="left">Ime</th>
                          <th class="center">Barva</th>
                          <th class="center ico">Spremeni barvo</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="status in statuses">
                      <td class="left">{{status.id}}</td>
                      <td class="left">{{status.name}}</td>
                      <td class="center">
                        <div class="flex order_color" style="background-color:{{status.color}}">
                            <span></span>
                        </div>
                      </td>
                      <td class="center icon">
                        <button type="button" ng-click="showColorsModal(status)" class="glyphicon_btn">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div ng-switch-when="2">
            <div class="content_table_wrap clearfix">
              <div style="margin: 6px 0; float:right;">
                <md-button ng-click="showCreateSMSModal()" class="md-raised">Dodaj SMS</md-button>
                <md-button ng-click="showSMSHistoryModal()" class="md-raised">Prikaži SMS Zgodovino</md-button>
              </div>
              <table class="content_table default_table">
                  <thead>
                      <tr>
                          <th class="left">Naslov</th>
                          <th class="left">Vsebina</th>
                          <th class="center">Active / Inactive</th>
                          <th class="center icon">Uredi</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="sm in sms">
                      <td class="left">{{sm.name}}</td>
                      <td class="left">{{sm.text}}</td>
                      <td class="center">{{(sm.active == 1) ? 'Active' : 'Inactive'}}</td>
                      <td class="center icon">
                        <button type="button" ng-click="showEditSMSModal(sm.id)" class="glyphicon_btn">
                            <span class="glyphicon glyphicon-edit"></span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
              </table>
            </div>
          </div>
          <div ng-switch-when="3">
            <form name="pro_form" ng-submit="saveEngine(engines, discounts, installments)">
            <div layout="row" class="row_wraper" layout-margin>
                <div layout="column" class="column_wraper" flex="50" layout-margin>
                    <header>
                        <h4>PRO</h4>
                    </header>
                    <table class="engines_table">
                        <tbody>
                    	    <tr>
                                <td class="nothing"> </td>
                                <td class="heading"> <b>Cena €</b> </td>
                                <td class="heading"> <b>Ure</b> </td>
                            </tr>
                            <tr>
                                <td> <b>V4</b> </td>
                                <td><input notnumber type="text" ng-model="engines[0].v4_price" required placeholder="Vnesi ceno" /> </td>
                                <td> <input type="text" ng-model="engines[0].v4_work" required placeholder="Vnesi ure" /> </td>
                            </tr>
                            <tr>
                                <td> <b>V6</b> </td>
                                <td> <input notnumber type="text" ng-model="engines[0].v6_price" required placeholder="Vnesi ceno" /> </td>
                                <td> <input type="text" ng-model="engines[0].v6_work" required placeholder="Vnesi ure" /> </td>
                            </tr>
                            <tr>
                                <td> <b>V8</b> </td>
                                <td> <input notnumber type="text" ng-model="engines[0].v8_price" required placeholder="Vnesi ceno" /> </td>
                                <td> <input type="text" ng-model="engines[0].v8_work" required placeholder="Vnesi ure" /> </td>
                            </tr>
                            <tr>
                                <td colspan="2"> <b>DODATNO MAZANJE VENTILOV</b> </td>
                                <td> <input notnumber type="text" ng-model="engines[0].lubricating" required placeholder="Vnesi ceno" /> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div layout="column" class="column_wraper" flex="50" layout-margin>
                    <header>
                        <h4>PRO DIRECT</h4>
                    </header>
                    
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
                                    <input notnumber type="text" ng-model="engines[1].v4_price" required placeholder="Vnesi ceno" />
                                </td>
                                <td> <input type="text" ng-model="engines[1].v4_work" required placeholder="Vnesi ure" /> </td>
                            </tr>
                            <tr>
                                <td> <b>V6</b> </td>
                                <td> <input notnumber type="text" ng-model="engines[1].v6_price" required placeholder="Vnesi ceno" /> </td>
                                <td> <input type="text" ng-model="engines[1].v6_work" required placeholder="Vnesi ure" /> </td>
                            </tr>
                            <tr>
                                <td> <b>V8</b> </td>
                                <td> <input notnumber type="text" ng-model="engines[1].v8_price" required placeholder="Vnesi ceno" /> </td>
                                <td> <input type="text" ng-model="engines[1].v8_work" required placeholder="Vnesi ure" /> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div layout="row" class="row_wraper" layout-margin>
                <div layout="column" class="column_wraper" flex="50" layout-margin>
                    <header>
                        <h4>POPUSTI</h4>
                    </header>
                    <table class="engines_table">
                        <tbody>
                    	    <tr>
                                <td class="nothing"> </td>
                                <td class="heading"> <b>Cena €</b> </td>
                            </tr>
                            <tr ng-repeat="discount in discounts">
                                <td> <b>{{discount.type}}</b> </td>
                                <td> 
                                    <input notnumber type="text" ng-model="discount.value" required placeholder="Vnesi ceno" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div layout="column" class="column_wraper" flex="50" layout-margin>
                    <header>
                        <h4>OBROKI</h4>
                    </header>
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
                                <td class="threetd"> <input notnumber type="text" ng-model="installment.deposit" required placeholder="Vnesi ceno" /></td>
                                <td class="threetd"> <input notnumber type="text" ng-model="installment.num_of_installments" required placeholder="Vnesi ure" /> </td>
                                <td class="threetd"> <input notnumber type="text" ng-model="installment.subsidy" required placeholder="Vnesi ure" /> </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <md-button type="submit" style="background-color: #3375BD; width: 20%;" class="md-raised md-primary">Shrani</md-button>
            </form>
          </div>
        </div>
      <md-tab>
     <md-tab>
   <md-content>
 <div>


<script type="text/ng-template" id="editUserModal.html">
  <md-dialog aria-label="Uredi uporabnik"  ng-cloak>
    <form ng-submit="updateUser(user)">
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Uredi uporabnik</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
          <md-input-container class="md-icon-float md-block">
            <label>Username</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_person_black_24px.svg" class="name"></md-icon>
            <input required ng-model="user.username" type="text">
          </md-input-container>
          <md-input-container class="md-icon-float md-block">
            <label>Password</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_vpn_key_black_24px.svg" class="name"></md-icon>
            <input required ng-model="user.password" type="password">
          </md-input-container>
          <md-input-container class="md-icon-float md-block" flex-gt-sm>
            <label>Type</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_settings_black_24px.svg" class="name"></md-icon>
            <md-select required ng-model="user.type">
              <md-option ng-repeat="type in types" ng-selected="(type == user.type) ? true : false">{{ type }}</md-option> 
            </md-select>
          </md-input-container>
          <md-input-container class="md-icon-float md-block" flex-gt-sm>
            <label>Active / Inactive</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_accessibility_black_24px.svg" class="name"></md-icon>
            <md-select ng-model="user.active">
              <md-option ng-repeat="act in active" ng-value="act.id" ng-selected="(act.id == user.active) ? true : false">
               {{act.status}}
              </md-option>
            </md-select>
          </md-input-container>
        </div>
      </md-dialog-content>
      <md-dialog-actions layout="row">
        <md-button type="submit" style="background-color: #3375BD;" class="md-raised md-primary">Save</md-button>
      </md-dialog-actions>
    </form>
  </md-dialog>
</script>

<script type="text/ng-template" id="createUserModal.html">
  <md-dialog aria-label="Dodaj uporabnik"  ng-cloak>
    <form ng-submit="createUser(newUser)">
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Dodaj uporabnik</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
          <md-input-container class="md-icon-float md-block">
            <label>Username</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_person_black_24px.svg" class="name"></md-icon>
            <input autofill="false" required ng-model="newUser.username" type="text">
          </md-input-container>
          <md-input-container class="md-icon-float md-block">
            <label>Password</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_vpn_key_black_24px.svg" class="name"></md-icon>
            <input required ng-model="newUser.password" type="password">
          </md-input-container>
          <md-input-container class="md-icon-float md-block" flex-gt-sm>
            <label>Type</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_settings_black_24px.svg" class="name"></md-icon>
            <md-select required ng-model="newUser.type">
              <md-option ng-repeat="type in types" ng-selected="(type == user.type) ? true : false">{{ type }}</md-option> 
            </md-select>
          </md-input-container>
          <md-input-container class="md-icon-float md-block" flex-gt-sm>
            <label>Active / Inactive</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_accessibility_black_24px.svg" class="name"></md-icon>
            <md-select required ng-model="newUser.active">
              <md-option ng-repeat="act in active" ng-value="act.id" ng-selected="(act.id == user.active) ? true : false">
               {{act.status}}
              </md-option>
            </md-select>
          </md-input-container>
        </div>
      </md-dialog-content>
      <md-dialog-actions layout="row">
        <md-button type="submit" style="background-color: #3375BD;" class="md-raised md-primary">Dodaj</md-button>
      </md-dialog-actions>
    </form>
  </md-dialog>
</script>

<script type="text/ng-template" id="colorModalContent.html">
  <md-dialog style="min-width:150px;" aria-label="Izberi barvo"  ng-cloak>
    <form ng-submit="changeColor(color)">
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>Izberi barvo</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
          <md-input-container class="md-icon-float md-block">
            <label>Izberi barvo</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_format_color_fill_black_24px.svg" class="name"></md-icon>
            <input colorpicker ng-model="color" type="text">
          </md-input-container>
        </div>
      </md-dialog-content>
      <md-dialog-actions layout="row">
        <md-button type="submit" style="background-color: #3375BD;" class="md-raised md-primary">Shrani</md-button>
      </md-dialog-actions>
    </form>
  </md-dialog>
</script>

<script type="text/ng-template" id="SMSModalContent.html">
  <md-dialog aria-label="SMS"  ng-cloak>
    <form ng-submit="edit_createSMS(sms)">
      <md-toolbar style="background-color: #3375BD;">
        <div class="md-toolbar-tools">
          <h2>{{naslov}}</h2>
          <span flex></span>
          <md-button class="md-icon-button" ng-click="cancel()">
            <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
          </md-button>
        </div>
      </md-toolbar>
      <md-dialog-content>
        <div class="md-dialog-content">
          <md-input-container class="md-icon-float md-block">
            <label>Naslov</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_create_black_24px.svg" class="name"></md-icon>
            <input required ng-model="sms.name" type="text">
          </md-input-container>
          <md-input-container class="md-icon-float md-block">
            <label>Vsebina</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_drafts_black_24px.svg" class="name"></md-icon>
            <textarea ng-model="sms.text" rows="5" md-select-on-focus></textarea>
          </md-input-container>
          <md-input-container class="md-icon-float md-block" flex-gt-sm>
            <label>Active / Inactive</label>
            <md-icon md-svg-src="/avtoplin/resources/images/ic_accessibility_black_24px.svg" class="name"></md-icon>
            <md-select required ng-model="sms.active">
              <md-option ng-repeat="type in types" ng-value="type.id" ng-selected="(type.id == sms.active) ? true : false">{{ type.status }}</md-option> 
            </md-select>
          </md-input-container>
        </div>
        
      </md-dialog-content>
      <md-dialog-actions layout="row">
        <md-button type="submit" style="background-color: #3375BD;" class="md-raised md-primary">Shrani</md-button>
      </md-dialog-actions>
    </form>
  </md-dialog>
</script>

<script type="text/ng-template" id="showSMSHistoryModalContent.html">
  <md-dialog aria-label="SMS Zgodovina" ng-cloak style="width: 650px; height: 650px;">  
        <md-toolbar style="background-color: #3375BD;">
            <div class="md-toolbar-tools">
                <h2>SMS Zgodovina</h2>
                <span flex></span>
                <md-button class="md-icon-button" ng-click="cancel()">
                    <md-icon md-svg-src="/avtoplin/resources/images/ic_clear_white_24px.svg" aria-label="Close dialog"></md-icon>
                </md-button>
            </div>
        </md-toolbar>
      <md-dialog-content ng-init="initData()">
        <div class="md-dialog-content">
            <table class="content_table default_table">
                  <thead>
                      <tr>
                          <th class="left">Uborabniško ime</th>
                          <th class="left">Datum</th>
                          <th class="center">Telefonska številka</th>
                          <th class="left">Tekst</th>
                      </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat="sms in smss">
                      <td class="left">{{sms.customer}}</td>
                      <td class="left">{{sms.date_sent}}</td>
                      <td class="center">
                        {{sms.telephone}}
                      </td>
                      <td class="left">{{sms.text}}</td>
                    </tr>
                  </tbody>
              </table>
        </div>
        <div id="main_loading" ng-show="loading" class="loading_overlay">
          <div class="loading_fixed_wrap">
              <img class="loading_img" src="/avtoplin/resources/images/loading_2.gif" />
              <span class="loading_text">Loading</span>
          </div>
        </div>
      </md-dialog-content>
  </md-dialog>
</script>