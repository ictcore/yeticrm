ICTBroadcast Module Install in YetiCRM
====================================

#### Install Module ICTBroadcast
--------------
* __Go to menu__
* __Click Settings__

[![Image Alt Text](http://ictbroadcast.com/sites/default/files/yeti_ictbroadcast/yetiScreenshotd1.png)](http://ictbroadcast.com/sites/default/files/yeti_ictbroadcast/yetiScreenshotd1.png)

* __Click Modules and then click "Install from file" button__
[![Image Alt Text](http://ictbroadcast.com/sites/default/files/yeti_ictbroadcast/yetiScreenshotd2.png)](http://ictbroadcast.com/sites/default/files/yeti_ictbroadcast/yetiScreenshotd1.png)
[![Image Alt Text](http://ictbroadcast.com/sites/default/files/yeti_ictbroadcast/yetiScreenshotd3.png)](http://ictbroadcast.com/sites/default/files/yeti_ictbroadcast/yetiScreenshotd1.png)
* __Select Zip file ICTBroadcast Module And click  "Import" button to install module __

[![Image Alt Text](http://ictbroadcast.com/sites/default/files/yeti_ictbroadcast/yetiScreenshotd4.png)](http://ictbroadcast.com/sites/default/files/yeti_ictbroadcast/yetiScreenshotd1.png)

* __When Module installed then changes two files one is Leads modules and second in vtiger core js file  __

#### Leads 
-------------------------------
 Yeticrm directory >>modules>>Leads>>models>>ListView.php
 
 * Find Function __"getListViewMassActions"__ and add code before __"foreach ($massActionLinks as $massActionLink) {"__
 * __Code__
 
```json

     if ($currentUserModel->hasModulePermission('IctBroadcast')) {
      $massActionLinks[]= [
        'linktype' => 'Start Broadcasting',
        'linklabel' => 'Start Broadcasting',
        'linkurl' => 'javascript:Vtiger_List_Js.triggerBroad("index.php?module='.'IctBroadcast'/*$this->getModule()->getName()*/.'&view=MassActionAjax&mode=showBroadCasting","IctBroadcast");',
        'linkicon' => ''
      ];
    }

Befor foreach ($massActionLinks as $massActionLink) {


```
#### Vtiger core file (List.js)  
----------------------------------
 Yeticrm directory >>public_html/layouts/basic/modules/Vtiger/resources>>List.js
 
 * Find Function __"triggerSendSms"__ and add function after __"triggerSendSms "__ Function
 * __Code__
```json
     triggerBroad : function(massActionUrl, module){
        var listInstance = app.controller();
        var validationResult = listInstance.checkListRecordSelected();
        if (validationResult != true) {
            app.helper.showProgress();
            app.helper.checkServerConfig(module).then(function (data) {
                app.helper.hideProgress();
                if (data == false) {
                    Vtiger_List_Js.triggerMassAction(massActionUrl);
                } else {
                    app.helper.showAlertBox({message: app.vtranslate('JS_SMS_SERVER_CONFIGURATION')})
                }
            });
        }
        else {
            listInstance.noRecordSelectedAlert();
        }

    },
```
__Now Module is ready for runnig in Leads Portion__


